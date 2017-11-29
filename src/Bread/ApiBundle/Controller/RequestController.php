<?php

namespace Bread\ApiBundle\Controller;

use Bread\ApiBundle\Form\FormInterface;
use Bread\ApiBundle\Service\UserService;
use Bread\ContentBundle\Entity\Request;
use Bread\ContentBundle\Entity\RequestType;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View;

/**
 * @Rest\Prefix("request")
 * @Rest\NamePrefix("api-request-")
 *
 * Class RequestController
 * @package Bread\ApiBundle\Controller
 */
class RequestController extends FOSRestController
{
    /**
     * @Rest\Route(path="", methods={"POST"})
     *
     * @Rest\RequestParam(name="Name")
     *
     * @Rest\RequestParam(name="Phone")
     *
     * @Rest\RequestParam(name="Email", nullable=true)
     *
     * @Rest\RequestParam(name="Type")
     *
     * @Rest\RequestParam(name="Agree", requirements="0|1", nullable=false, allowBlank=false, strict=true, default=false)
     *
     * @Rest\RequestParam(name="Token", nullable=false, allowBlank=false, strict=true, default="token")
     *
     * @Rest\RequestParam(name="Data", nullable=true, allowBlank=false, strict=false)
     *
     * @param ParamFetcher $paramFetcher
     *
     * @param ParamFetcher $paramFetcher
     * @return View
     * @throws \Exception
     */
    public function saveAction(ParamFetcher $paramFetcher)
    {
        try {
            /** @var View $view */
            $view = $this->view();

            $formType = $paramFetcher->get('Type');
            $formType = 'bread_api.' . $formType . '_type';

            if (!$this->has($formType)) {
                throw new \Exception("Undefined type '{$formType}'");
            }

            /** @var FormInterface $form */
            $form = $this->get($formType);

            $form->handleRequest($paramFetcher);

            if (!$form->isValid()) {
                return $view->setData([
                    'success'   =>  false,
                    'errors'    =>  $form->getFormErrors()
                ]);
            }

            /** @var UserService $userService */
            $userService = $this->get('bread_api.user_service');
            $user = $userService->findOrCreateUser($paramFetcher);

            /** @var RequestType $requestType */
            $requestType = $this->getDoctrine()
                ->getRepository('BreadContentBundle:RequestType')
                ->findOneBy(['title' => $paramFetcher->get('Type')]);

            $request = new Request();
            $request
                ->setType($requestType)
                ->setClient($user)
                ->setData($paramFetcher->get('Data'));

            $this->getDoctrine()->getManager()->persist($request);
            $this->getDoctrine()->getManager()->flush();

            //отправка email

            return $view->setData([
                'success'   =>  true,
                'errors'    =>  false
            ]);
        } catch (\Exception $e) {
            return $view->setData([
                'success'   =>  false,
                'errors'    =>  null
            ]);
        }
    }
}