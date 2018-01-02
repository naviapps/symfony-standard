<?php

namespace Naviapps\Bundle\CmsBundle\DependencyInjection;

use Naviapps\Bundle\CmsBundle\Entity\Block;
use Naviapps\Bundle\CmsBundle\Entity\Page;
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
        $rootNode = $treeBuilder->root('naviapps_cms');

        $rootNode
            ->children()
                ->scalarNode('table_prefix')->defaultValue('naviapps_cms_')->end()
            ->end();

        return $treeBuilder;
    }
}
