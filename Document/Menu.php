<?php
declare(strict_types = 1);

namespace mssimi\ContentManagementBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Knp\Menu\NodeInterface;

/**
 * @PHPCR\Document(repositoryClass="mssimi\ContentManagementBundle\Repository\MenuRepository", mixins={"mix:created", "mix:lastModified"})
 */
class Menu extends AbstractNode implements NodeInterface
{
    /**
     * @var string
     *
     * @PHPCR\Nodename
     */
    private $name;

    /**
     *
     * @PHPCR\Children
     */
    private $children;

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
     * {@inheritdoc}
     */
    public function getOptions()
    {
        return [
            'uri' => [],
            'route' => [],
            'label' => [],
            'attributes' => [],
            'childrenAttributes' => [],
            'display' => true,
            'displayChildren' => true,
            'routeParameters' => [],
            'routeAbsolute' => [],
            'linkAttributes' => [],
            'labelAttributes' => [],
        ];
    }
}