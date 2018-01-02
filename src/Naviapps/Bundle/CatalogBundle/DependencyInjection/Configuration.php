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
            ->end();

        $this->addCategorySection($rootNode);
        $this->addProductSection($rootNode);

        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addCategorySection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('category')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                    ->children()
                        ->scalarNode('class')->isRequired()->cannotBeEmpty()->end()
                    ->end()
                ->end()
            ->end();
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addProductSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('product')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                    ->children()
                        ->scalarNode('class')->isRequired()->cannotBeEmpty()->end()
                    ->end()
                ->end()
            ->end();
    }
}