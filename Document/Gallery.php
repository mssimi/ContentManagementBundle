<?php
declare(strict_types = 1);

namespace mssimi\ContentManagementBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

/**
 * @PHPCR\Document(mixins={"mix:created", "mix:lastModified"}, repositoryClass="mssimi\ContentManagementBundle\Repository\GalleryRepository", translator="attribute")
 */
class Gallery extends Page
{
}