<?php

namespace mssimi\ContentManagementBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('content_management');

        $rootNode
            ->children()
                ->arrayNode('locales')
                    ->defaultValue(array('en'))
                    ->cannotBeEmpty()
                    ->prototype('scalar')->end()
                ->end()
            ->end()
            ->children()
                ->integerNode('items_per_page')
                    ->defaultValue(20)
                    ->min(1)
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
