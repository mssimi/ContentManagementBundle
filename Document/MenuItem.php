<?php
declare(strict_types = 1);

namespace mssimi\ContentManagementBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Knp\Menu\NodeInterface;

/**
 * @PHPCR\Document(repositoryClass="mssimi\ContentManagementBundle\Repository\MenuItemRepository", translator="attribute")
 *
 */
class MenuItem implements NodeInterface
{
    CONST linkTypeUrl = 'url';
    CONST linkTypeRoute = 'route';
    CONST linkTypePath = 'path';

    /**
     * @var string
     *
     * @PHPCR\Id
     */
    private $id;

    /**
     * @PHPCR\ParentDocument
     */
    private $parent;

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

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return substr($this->id, strrpos($this->id, '/') + 1);
    }

    /**
     * @return string
     */
    public function getMenuId(): ?string
    {
        preg_match('/\/cms\/menu\/(.*?)\//', $this->id, $match);
        return '/cms/menu/' . $match[1];
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
        return $this->linkType == self::linkTypeUrl ? $this->link : null;
    }

    public function getRouteOption()
    {
        switch ($this->linkType){
            case self::linkTypeRoute:
                return $this->link;
                break;
            case self::linkTypePath:
                return 'mssimi_page_render';
                break;
            default:
                return null;
        }
    }

    public function getParamOption()
    {
        return $this->linkType == self::linkTypePath ? ['id' => str_replace('/cms/page/','', $this->link)] : [];
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