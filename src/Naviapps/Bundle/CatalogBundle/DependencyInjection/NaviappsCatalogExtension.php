<?php

namespace Naviapps\Bundle\CatalogBundle\DependencyInjection;

use Naviapps\Component\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class NaviappsCatalogExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');

        $this->remapParametersNamespaces($config, $container, [
            '' => [
                'table_prefix' => 'naviapps_catalog.table_prefix',
            ],
        ]);

        if (!empty($config['category'])) {
            $this->loadCategory($config['category'], $container);
        }

        if (!empty($config['product'])) {
            $this->loadProduct($config['product'], $container);
        }
    }

    /**
     * @param array $config
     * @param ContainerBuilder $container
     */
    private function loadCategory(array $config, ContainerBuilder $container)
    {
        $this->remapParametersNamespaces($config, $container, [
            '' => [
                'class' => 'naviapps_catalog.category.class',
            ],
        ]);
    }

    /**
     * @param array $config
     * @param ContainerBuilder $container
     */
    private function loadProduct(array $config, ContainerBuilder $container)
    {
        $this->remapParametersNamespaces($config, $container, [
            '' => [
                'class' => 'naviapps_catalog.product.class',
            ],
        ]);
    }
}