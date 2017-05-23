<?php
declare(strict_types = 1);

namespace mssimi\ContentManagementBundle\Document;

use Doctrine\ODM\PHPCR\ChildrenCollection;
use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

/**
 * @PHPCR\MappedSuperclass()
 * @PHPCR\Document(repositoryClass="mssimi\ContentManagementBundle\Repository\AbstractPageRepository", translator="attribute")
 */
class AbstractPage extends AbstractNode
{
    /**
     * @var string
     *
     * @PHPCR\Nodename
     */
    protected $name;

    /**
     *
     * @PHPCR\Children
     */
    protected $children;

    /**
     * @var boolean
     *
     * @PHPCR\Field(type="boolean")
     */
    protected $publish = true;

    /**
     * @var string
     *
     * @PHPCR\Field(type="string", translated=true, nullable=true)
     */
    protected $metaKeywords;

    /**
     * @var string
     *
     * @PHPCR\Field(type="string", translated=true)
     */
    protected $heading;

    /**
     * @var string
     *
     * @PHPCR\Field(type="string", translated=true, nullable=true)
     */
    protected $content;

    /**
     * @var string
     *
     * @PHPCR\Locale
     */
    protected $locale;

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return ChildrenCollection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @param $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
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

    /**
     * @return string
     */
    public function getMetaKeywords(): ?string
    {
        return $this->metaKeywords;
    }

    /**
     * @param string $metaKeywords
     */
    public function setMetaKeywords(string $metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;
    }

    /**
     * @return string
     */
    public function getHeading(): ?string
    {
        return $this->heading;
    }

    /**
     * @param string $heading
     */
    public function setHeading(string $heading)
    {
        $this->heading = $heading;
    }

    /**
     * @return string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale(string $locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return mixed
     */
    public function getPath(){
        return str_replace('/cms/page/','', $this->getId());
    }
}