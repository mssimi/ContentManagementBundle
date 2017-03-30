<?php

namespace mssimi\ContentManagementBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

/**
 * @PHPCR\Document(repositoryClass="mssimi\ContentManagementBundle\Repository\MenuRepository", translator="attribute")
 *
 */
class Menu
{
    CONST linkTypeUrl = 'url';
    CONST linkTypeRoute = 'route';
    CONST linkTypePath = 'path';

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
     * @PHPCR\Field(type="string", translated=true)
     */
    private $label;

    /**
     * @PHPCR\Field(type="string", translated=true, nullable=true)
     */
    private $link;

    /**
     * @PHPCR\Field(type="string")
     */
    private $linkType = self::linkTypeUrl;

    /**
     * @PHPCR\Field(type="boolean")
     */
    private $targetBlank = false;

    /**
     * @PHPCR\Locale
     */
    private $locale;

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
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param mixed $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @return mixed
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mixed $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * @return mixed
     */
    public function getTargetBlank()
    {
        return $this->targetBlank;
    }

    /**
     * @param mixed $targetBlank
     */
    public function setTargetBlank($targetBlank)
    {
        $this->targetBlank = $targetBlank;
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
    public function getLinkType()
    {
        return $this->linkType;
    }

    /**
     * @param mixed $linkType
     */
    public function setLinkType($linkType)
    {
        $this->linkType = $linkType;
    }
}