<?php
declare(strict_types = 1);

namespace mssimi\ContentManagementBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

/**
 * @PHPCR\Document(repositoryClass="mssimi\ContentManagementBundle\Repository\SliderRepository", mixins={"mix:created", "mix:lastModified"})
 */
class Slider extends AbstractNode
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
}