<?php
declare(strict_types = 1);

namespace mssimi\ContentManagementBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

/**
 * @PHPCR\MappedSuperclass(mixins={"mix:created", "mix:lastModified"})
 * @PHPCR\Document(translator="attribute")
 */
class AbstractImage
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
     * @PHPCR\Locale
     */
    private $locale;

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