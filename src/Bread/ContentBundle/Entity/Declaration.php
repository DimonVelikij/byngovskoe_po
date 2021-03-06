<?php

namespace Bread\ContentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class Declaration
 * @package Bread\ContentBundle\Entity
 * @ORM\Table(name="declarations")
 * @ORM\Entity
 *
 * @JMS\ExclusionPolicy("all")
 */
class Declaration
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     *
     * @JMS\Expose
     * @JMS\Type("integer")
     * @JMS\SerializedName("Id")
     * @JMS\Groups({"api"})
     */
    private $id;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255, nullable=false)
     *
     * @JMS\Expose
     * @JMS\Type("string")
     * @JMS\SerializedName("Title")
     * @JMS\Groups({"api"})
     */
    private $title;

    /**
     * @var string $description
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     *
     * @JMS\Expose
     * @JMS\Type("string")
     * @JMS\SerializedName("Description")
     * @JMS\Groups({"api"})
     */
    private $description;

    /**
     * @ORM\OneToOne(targetEntity="Bread\ContentBundle\Entity\Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="image_id", referencedColumnName="id", onDelete="SET NULL")
     *
     * @JMS\Expose
     * @JMS\SerializedName("Image")
     * @JMS\Groups({"api"})
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="image_crop", type="string", length=255, nullable=true)
     */
    private $imageCrop;

    /**
     * @var UploadedFile
     */
    private $uploadedFile;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getTitle() ?? '';
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Declaration
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Declaration
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set imageCrop
     *
     * @param string $imageCrop
     *
     * @return Declaration
     */
    public function setImageCrop($imageCrop)
    {
        $this->imageCrop = $imageCrop;

        return $this;
    }

    /**
     * Get imageCrop
     *
     * @return string
     */
    public function getImageCrop()
    {
        return $this->imageCrop;
    }

    /**
     * Set image
     *
     * @param \Bread\ContentBundle\Entity\Image $image
     *
     * @return Declaration
     */
    public function setImage(\Bread\ContentBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \Bread\ContentBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param $uploadedFile
     * @return Product
     */
    public function setUploadedFile($uploadedFile)
    {
        $this->uploadedFile = $uploadedFile;

        return $this;
    }

    /**
     * @return UploadedFile
     */
    public function getUploadedFile()
    {
        return $this->uploadedFile;
    }
}
