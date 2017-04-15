<?php
declare(strict_types = 1);

namespace mssimi\ContentManagementBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @PHPCR\Document(repositoryClass="mssimi\ContentManagementBundle\Repository\SliderImageRepository", translator="attribute")
 */
class SliderImage extends AbstractImage
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
     * @PHPCR\Field(type="string", translated=true, nullable=true)
     */
    private $imageName;

    /**
     * @var string
     *
     * @PHPCR\Field(type="string", translated=true, nullable=true)
     */
    private $link;

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
    public function getLink(): ?string
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link)
    {
        $this->link = $link;
    }
}