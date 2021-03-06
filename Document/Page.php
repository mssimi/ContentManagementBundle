<?php
declare(strict_types = 1);

namespace mssimi\ContentManagementBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;

/**
 * @PHPCR\Document(repositoryClass="mssimi\ContentManagementBundle\Repository\PageRepository", mixins={"mix:created", "mix:lastModified"})
 */
class Page extends AbstractPage
{
}