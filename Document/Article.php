<?php
declare(strict_types = 1);

namespace mssimi\ContentManagementBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @PHPCR\Document(repositoryClass="mssimi\ContentManagementBundle\Repository\ArticleRepository", translator="attribute", mixins={"mix:created", "mix:lastModified"})
 * @Vich\Uploadable
 */
class Article extends AbstractPage
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
    public function setImageName(string $imageName = null)
    {
        $this->imageName = $imageName;
    }
}