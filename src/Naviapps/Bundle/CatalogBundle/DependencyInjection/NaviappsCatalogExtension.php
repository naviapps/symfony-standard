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
                'category_class' => 'naviapps_catalog.model.category.class',
                'product_class' => 'naviapps_catalog.model.product.class',
            ],
        ]);

        if (!empty($config['admin_category'])) {
            $this->loadAdminCategory($config['admin_category'], $container);
        }

        if (!empty($config['admin_product'])) {
            $this->loadAdminProduct($config['admin_product'], $container);
        }
    }

    /**
     * @param array $config
     * @param ContainerBuilder $container
     */
    private function loadAdminCategory(array $config, ContainerBuilder $container)
    {
    }

    /**
     * @param array $config
     * @param ContainerBuilder $container
     */
    private function loadAdminProduct(array $config, ContainerBuilder $container)
    {
    }
}
