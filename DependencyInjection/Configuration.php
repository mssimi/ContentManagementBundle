<?php

namespace mssimi\ContentManagementBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
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

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.
        $rootNode
            ->children()
                ->arrayNode('locales')
                    ->defaultValue(array('en'))
                    ->cannotBeEmpty()
                    ->prototype('scalar')->end()
                ->end()
            ->end()
            ->children()
                ->arrayNode('templates')
                    ->defaultValue(array('templateSimple' => '@ContentManagement/Page/page.html.twig'))
                    ->cannotBeEmpty()
                    ->useAttributeAsKey('name')
                    ->prototype('scalar')
                    ->end()
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
