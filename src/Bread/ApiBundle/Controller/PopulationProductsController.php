<?php

namespace Bread\ApiBundle\Controller;

use Doctrine\ORM\EntityRepository;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;

/**
 * @Rest\Prefix("population-products")
 * @Rest\NamePrefix("api-population-products-")
 *
 * Class DataResourceController
 * @package Bread\ApiBundle\Controller
 */
class PopulationProductsController extends FOSRestController
{
    /**
     * @Rest\Get("")
     * @Rest\View(serializerGroups={"api"})
     */
    public function listAction()
    {
        /** @var EntityRepository $productRepo */
        $productRepo = $this->getDoctrine()->getRepository('BreadContentBundle:Product');
        return $productRepo->createQueryBuilder('p')
            ->where('p.public = :public')
            ->setParameters(['public' => true])
            ->getQuery()
            ->getResult();
    }
}