<?php
declare(strict_types = 1);

namespace mssimi\ContentManagementBundle\Document;

use Doctrine\ODM\PHPCR\ChildrenCollection;
use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

/**
 * @PHPCR\MappedSuperclass()
 * @PHPCR\Document()
 */
class AbstractNode
{
    /**
     * @var string
     *
     * @PHPCR\Id
     */
    protected $id;

    /**
     * @var object
     *
     * @PHPCR\ParentDocument
     */
    protected $parent;

    /**
     * @var \DateTime
     *
     * @PHPCR\Field(type="date", property="jcr:created")
     */
    protected $created;

    /**
     * @var string
     *
     * @PHPCR\Field(type="string", property="jcr:createdBy")
     */
    protected $createdBy;

    /**
     * @var \DateTime
     *
     * @PHPCR\Field(type="date", property="jcr:lastModified")
     */
    protected $lastModified;

    /**
     * @var string
     *
     * @PHPCR\Field(type="string", property="jcr:lastModifiedBy")
     */
    protected $lastModifiedBy;

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