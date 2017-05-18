<?php

namespace mssimi\ContentManagementBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 */
class ContentManagementExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $container->setParameter('content_management.locales', $config['locales']);
        $container->setParameter('content_management.items_per_page', $config['items_per_page']);
        $container->setParameter('content_management.articles_per_page', $config['articles_per_page']);
        $container->setParameter('content_management.page_template', $config['page_template']);
        $container->setParameter('content_management.blog_template', $config['blog_template']);
        $container->setParameter('content_management.article_template', $config['article_template']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
