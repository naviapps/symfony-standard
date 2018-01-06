<?php

namespace Naviapps\Bundle\SalesBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
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
        $rootNode = $treeBuilder->root('naviapps_sales');

        $rootNode
            ->children()
                ->scalarNode('table_prefix')->defaultValue('naviapps_sales_')->end()
                ->scalarNode('order_class')->isRequired()->cannotBeEmpty()->end()
            ->end();

        $this->addAdminOrderSection($rootNode);

        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addAdminOrderSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('admin_order')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                ->end()
            ->end();
    }
}
