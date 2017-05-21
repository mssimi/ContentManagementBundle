<?php
declare(strict_types = 1);

namespace mssimi\ContentManagementBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Knp\Menu\NodeInterface;

/**
 * @PHPCR\Document(repositoryClass="mssimi\ContentManagementBundle\Repository\MenuItemRepository", translator="attribute", mixins={"mix:created", "mix:lastModified"})
 *
 */
class MenuItem extends AbstractNode implements NodeInterface
{
    CONST linkTypeUrl = 'url';
    CONST linkTypeRoute = 'route';
    CONST linkTypePath = 'path';
    CONST linkTypePage = 'page';

    /**
     * @PHPCR\Children
     */
    private $children;

    /**
     * @var string
     *
     * @PHPCR\Field(type="string", translated=true)
     */
    private $label;

    /**
     * @var string
     *
     * @PHPCR\Field(type="string", translated=true, nullable=true)
     */
    private $link;

    /**
     * @var string
     *
     * @PHPCR\Field(type="string")
     */
    private $linkType = self::linkTypeUrl;

    /**
     * @var boolean
     *
     * @PHPCR\Field(type="boolean")
     */
    private $targetBlank = false;

    /**
     * @var string
     *
     * @PHPCR\Locale
     */
    private $locale;

    public function __clone()
    {
        $this->id = null;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return substr($this->getId(), strrpos($this->getId(), '/') + 1);
    }

    /**
     * @return string
     */
    public function getMenuId(): ?string
    {
        preg_match('/\/cms\/menu\/(.*?)\//', $this->getParent()->getId(), $match);
        return $match ? '/cms/menu/' . $match[1] : $this->getParent()->getId();
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
     * @return string
     */
    public function getLabel(): ?string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label)
    {
        $this->label = $label;
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

    /**
     * @return string
     */
    public function getLinkType(): ?string
    {
        return $this->linkType;
    }

    /**
     * @param string $linkType
     */
    public function setLinkType(string $linkType)
    {
        $this->linkType = $linkType;
    }

    /**
     * @return bool
     */
    public function getTargetBlank(): ?bool
    {
        return $this->targetBlank;
    }

    /**
     * @param bool $targetBlank
     */
    public function setTargetBlank(bool $targetBlank)
    {
        $this->targetBlank = $targetBlank;
    }

    /**
     * @return string
     */
    public function getLocale(): ?string
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


    public function getUriOption()
    {
        return $this->linkType == (self::linkTypeUrl || self::linkTypePath) ? $this->link : null;
    }

    public function getRouteOption()
    {
        switch ($this->linkType){
            case self::linkTypeRoute:
                return $this->link;
                break;
            case self::linkTypePage:
                return 'mssimi_page_render';
                break;
            default:
                return null;
        }
    }

    public function getParamOption()
    {
        return $this->linkType == self::linkTypePage ? ['id' => str_replace('/cms/page/','', $this->link)] : [];
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions()
    {
        return [
            'uri' => $this->getUriOption(),
            'route' => $this->getRouteOption(),
            'label' => $this->getLabel(),
            'attributes' => [],
            'childrenAttributes' => [],
            'display' => true,
            'displayChildren' => true,
            'routeParameters' => $this->getParamOption(),
            'routeAbsolute' => $this->getTargetBlank(),
            'linkAttributes' => [],
            'labelAttributes' => [],
        ];
    }
}