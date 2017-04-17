<?php
declare(strict_types = 1);

namespace mssimi\ContentManagementBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @PHPCR\Document(repositoryClass="mssimi\ContentManagementBundle\Repository\GalleryImageRepository", translator="attribute", referenceable=true, mixins={"mix:created", "mix:lastModified"})
 * @Vich\Uploadable
 */
class GalleryImage extends AbstractImage
{
    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="content_management", fileNameProperty="imageName")
     */
    private $imageFile;

    /**
     * @var string
     *
     * @PHPCR\Field(type="string", nullable=true)
     */
    private $imageName;

    /**
     * @var string
     *
     * @PHPCR\Field(type="string", translated=true, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @PHPCR\Field(type="string", translated=true, nullable=true)
     */
    private $perex;

    /**
     * GalleryImage constructor.
     */
    public function __construct()
    {
        $this->setId('/cms/image/' . bin2hex(random_bytes(10)));
    }

    /**
     * @return File
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param File $imageFile
     */
    public function setImageFile(File $imageFile)
    {
        $this->imageFile = $imageFile;

        if ($imageFile) {
            $this->setLastModified(new \DateTime());
        }
    }

    /**
     * @return string
     */
    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    /**
     * @param string $imageName
     */
    public function setImageName(string $imageName)
    {
        $this->imageName = $imageName;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getPerex(): ?string
    {
        return $this->perex;
    }

    /**
     * @param string $perex
     */
    public function setPerex(string $perex = null)
    {
        $this->perex = $perex;
    }
}