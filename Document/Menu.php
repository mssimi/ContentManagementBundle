<?php
declare(strict_types = 1);

namespace mssimi\ContentManagementBundle\Document;

use Doctrine\ODM\PHPCR\Mapping\Annotations as PHPCR;
use Knp\Menu\NodeInterface;

/**
 * @PHPCR\Document(repositoryClass="mssimi\ContentManagementBundle\Repository\MenuRepository")
 */
class Menu extends AbstractNode implements NodeInterface
{
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