<?php
declare(strict_types = 1);

namespace mssimi\ContentManagementBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @PHPCR\Document(repositoryClass="mssimi\ContentManagementBundle\Repository\SliderImageRepository", translator="attribute", mixins={"mix:created", "mix:lastModified"})
 * @Vich\Uploadable
 */
class SliderImage extends AbstractImage
{
    /**
     * @var File|null
     *
     * @Vich\UploadableField(mapping="content_management", fileNameProperty="imageName")
     */
    private $imageFile;

    /**
     * @var string|null
     *
     * @PHPCR\Field(type="string", translated=true)
     */
    private $imageName;

    /**
     * @var string|null
     *
     * @Assert\Url()
     * @PHPCR\Field(type="Uri", translated=true, nullable=true)
     */
    private $link;

    /**
     * @var boolean
     *
     * @PHPCR\Field(type="boolean")
     */
    private $publish = true;

    public function __clone()
    {
        $this->id = null;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return substr($this->id, strrpos($this->id, '/') + 1);
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
            $this->lastModified = new \DateTime();
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
    public function setImageName(string $imageName = null)
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
    public function setLink(string $link = null)
    {
        $this->link = $link;
    }

    /**
     * @return bool
     */
    public function getPublish(): bool
    {
        return $this->publish;
    }

    /**
     * @param bool $publish
     */
    public function setPublish(bool $publish)
    {
        $this->publish = $publish;
    }
}