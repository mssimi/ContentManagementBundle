<?php
declare(strict_types = 1);

namespace mssimi\ContentManagementBundle\Document;

use Doctrine\ODM\PHPCR\ChildrenCollection;
use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

/**
 * @PHPCR\MappedSuperclass()
 * @PHPCR\Document(mixins={"mix:created", "mix:lastModified"})
 */
class AbstractNode
{
    /**
     * @var string
     *
     * @PHPCR\Id
     */
    private $id;

    /**
     * @var string
     *
     * @PHPCR\Nodename
     */
    private $name;

    /**
     * @var object
     *
     * @PHPCR\ParentDocument
     */
    private $parent;

    /**
     *
     * @PHPCR\Children
     */
    private $children;

    /**
     * @var boolean
     *
     * @PHPCR\Field(type="boolean")
     */
    private $publish = true;

    /**
     * @var \DateTime
     *
     * @PHPCR\Field(type="date", property="jcr:created")
     */
    private $created;

    /**
     * @var string
     *
     * @PHPCR\Field(type="string", property="jcr:createdBy")
     */
    private $createdBy;

    /**
     * @var \DateTime
     *
     * @PHPCR\Field(type="date", property="jcr:lastModified")
     */
    private $lastModified;

    /**
     * @var string
     *
     * @PHPCR\Field(type="string", property="jcr:lastModifiedBy")
     */
    private $lastModifiedBy;

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
     * @return object
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
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
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * @param \DateTime $created
     */
    public function setCreated(\DateTime $created)
    {
        $this->created = $created;
    }

    /**
     * @return string
     */
    public function getCreatedBy(): string
    {
        return $this->createdBy;
    }

    /**
     * @param string $createdBy
     */
    public function setCreatedBy(string $createdBy)
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @return \DateTime
     */
    public function getLastModified(): \DateTime
    {
        return $this->lastModified;
    }

    /**
     * @param \DateTime $lastModified
     */
    public function setLastModified(\DateTime $lastModified)
    {
        $this->lastModified = $lastModified;
    }

    /**
     * @return string
     */
    public function getLastModifiedBy(): string
    {
        return $this->lastModifiedBy;
    }

    /**
     * @param string $lastModifiedBy
     */
    public function setLastModifiedBy(string $lastModifiedBy)
    {
        $this->lastModifiedBy = $lastModifiedBy;
    }
}