<?php

namespace Naviapps\Bundle\AdminBundle\DependencyInjection;

use Naviapps\Bundle\AdminBundle\Entity\User;
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
        $rootNode = $treeBuilder->root('naviapps_admin');

        $rootNode
            ->children()
                ->scalarNode('table_prefix')->defaultValue('naviapps_admin_')->end()
            ->end();

        return $treeBuilder;
    }
}
