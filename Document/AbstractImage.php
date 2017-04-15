<?php
declare(strict_types = 1);

namespace mssimi\ContentManagementBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

/**
 * @PHPCR\MappedSuperclass()
 * @PHPCR\Document(translator="attribute")
 */
class AbstractImage extends AbstractNode
{
}