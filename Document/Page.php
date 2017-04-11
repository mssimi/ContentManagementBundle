<?php

namespace mssimi\ContentManagementBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @PHPCR\Document(mixins={"mix:created", "mix:lastModified"}, repositoryClass="mssimi\ContentManagementBundle\Repository\PageRepository", translator="attribute")
 * @Vich\Uploadable
 */
class Page
{
    /**
     * @PHPCR\Id
     */
    private $id;

    /**
     * @PHPCR\Nodename
     */
    private $name;

    /**
     * @PHPCR\ParentDocument
     */
    private $parent;

    /**
     * @PHPCR\Children
     */
    private $children;

    /**
     * @PHPCR\Field(type="string", translated=true, nullable=true)
     */
    private $metaKeywords;

    /**
     * @PHPCR\Field(type="string", translated=true, nullable=true)
     */
    private $metaDescription;

    /**
     * @PHPCR\Field(type="string", translated=true)
     */
    private $heading;

    /**
     * @PHPCR\Field(type="string", translated=true, nullable=true)
     */
    private $content;

    /**
     * @PHPCR\Locale
     */
    private $locale;

    /**
     * @PHPCR\Field(type="boolean")
     */
    private $publish = true;

    /**
     *
     * @Vich\UploadableField(mapping="content_management", fileNameProperty="imageName")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @PHPCR\Field(type="string", nullable=true)
     *
     * @var string
     */
    private $imageName;

    /** @PHPCR\Field(type="date", property="jcr:created") */
    private $created;

    /** @PHPCR\Field(type="string", property="jcr:createdBy") */
    private $createdBy;

    /** @PHPCR\Field(type="date", property="jcr:lastModified") */
    private $lastModified;

    /** @PHPCR\Field(type="string", property="jcr:lastModifiedBy") */
    private $lastModifiedBy;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param mixed $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param mixed $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return mixed
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }

    /**
     * @param mixed $metaKeywords
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;
    }

    /**
     * @return mixed
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * @param mixed $metaDescription
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;
    }

    /**
     * @return mixed
     */
    public function getHeading()
    {
        return $this->heading;
    }

    /**
     * @param mixed $heading
     */
    public function setHeading($heading)
    {
        $this->heading = $heading;
    }

    /**
     * @return mixed
     */
    public function getPublish()
    {
        return $this->publish;
    }

    /**
     * @param mixed $publish
     */
    public function setPublish($publish)
    {
        $this->publish = $publish;
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param File $imageFile
     */
    public function setImageFile($imageFile)
    {
        $this->imageFile = $imageFile;

        if ($imageFile) {
            $this->lastModified = new \DateTime();
        }
    }

    /**
     * @return string
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * @param string $imageName
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    /**
     * @return mixed
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param mixed $createdBy
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @return mixed
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * @param mixed $lastModified
     */
    public function setLastModified($lastModified)
    {
        $this->lastModified = $lastModified;
    }

    /**
     * @return mixed
     */
    public function getLastModifiedBy()
    {
        return $this->lastModifiedBy;
    }

    /**
     * @param mixed $lastModifiedBy
     */
    public function setLastModifiedBy($lastModifiedBy)
    {
        $this->lastModifiedBy = $lastModifiedBy;
    }
}