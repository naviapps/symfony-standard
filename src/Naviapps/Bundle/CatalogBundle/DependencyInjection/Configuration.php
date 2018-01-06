<?php

namespace Naviapps\Bundle\CatalogBundle\DependencyInjection;

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
        $rootNode = $treeBuilder->root('naviapps_catalog');

        $rootNode
            ->children()
                ->scalarNode('table_prefix')->defaultValue('naviapps_catalog_')->end()
                ->scalarNode('category_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('product_class')->isRequired()->cannotBeEmpty()->end()
            ->end();

        $this->addAdminCategorySection($rootNode);
        $this->addAdminProductSection($rootNode);

        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addAdminCategorySection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('admin_category')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                ->end()
            ->end();
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addAdminProductSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('admin_product')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                ->end()
            ->end();
    }
}
