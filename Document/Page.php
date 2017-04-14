<?php
declare(strict_types = 1);

namespace mssimi\ContentManagementBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

/**
 * @PHPCR\Document(mixins={"mix:created", "mix:lastModified"}, repositoryClass="mssimi\ContentManagementBundle\Repository\PageRepository", translator="attribute")
 */
class Page extends AbstractNode
{
    /**
     * @var string
     *
     * @PHPCR\Field(type="string", translated=true, nullable=true)
     */
    private $metaKeywords;

    /**
     * @var string
     *
     * @PHPCR\Field(type="string", translated=true, nullable=true)
     */
    private $metaDescription;

    /**
     * @var string
     *
     * @PHPCR\Field(type="string", translated=true)
     */
    private $heading;

    /**
     * @var string
     *
     * @PHPCR\Field(type="string", translated=true, nullable=true)
     */
    private $content;

    /**
     * @var string
     *
     * @PHPCR\Locale
     */
    private $locale;

    /**
     * @var string
     *
     * @PHPCR\Field(type="string")
     */
    private $template = '@ContentManagement/Page/page.html.twig';

    /**
     * @return string
     */
    public function getMetaKeywords(): string
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
    public function getMetaDescription(): string
    {
        return $this->metaDescription;
    }

    /**
     * @param string $metaDescription
     */
    public function setMetaDescription(string $metaDescription)
    {
        $this->metaDescription = $metaDescription;
    }

    /**
     * @return string
     */
    public function getHeading(): string
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
    public function getContent(): string
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
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * @param string $template
     */
    public function setTemplate(string $template)
    {
        $this->template = $template;
    }
}