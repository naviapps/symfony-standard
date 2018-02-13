<?php

namespace Naviapps\Bundle\CustomerBundle\DependencyInjection;

use Naviapps\Bundle\CustomerBundle\Form\Admin\CustomerType;
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
        $rootNode = $treeBuilder->root('naviapps_customer');

        $this->addAdminCustomerSection($rootNode);

        return $treeBuilder;
    }

    /**
     * @param ArrayNodeDefinition $node
     */
    private function addAdminCustomerSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('admin_customer')
                    ->addDefaultsIfNotSet()
                    ->canBeUnset()
                    ->children()
                        ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('type')->defaultValue(CustomerType::class)->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
