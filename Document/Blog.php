<?php
declare(strict_types = 1);

namespace mssimi\ContentManagementBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

/**
 * @PHPCR\Document(repositoryClass="mssimi\ContentManagementBundle\Repository\BlogRepository")
 */
class Blog extends AbstractPage
{
}