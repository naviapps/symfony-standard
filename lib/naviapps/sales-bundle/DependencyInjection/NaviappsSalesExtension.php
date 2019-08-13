<?php

namespace Naviapps\Bundle\SalesBundle\DependencyInjection;

use Naviapps\Bundle\FrameworkBundle\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class NaviappsSalesExtension extends Extension
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
                'table_prefix' => 'naviapps_sales.table_prefix',
                'order_class' => 'naviapps_sales.model.order.class',
            ],
        ]);

        if (!empty($config['admin_order'])) {
            $this->loadAdminOrder($config['admin_order'], $container);
        }
    }

    /**
     * @param array $config
     * @param ContainerBuilder $container
     */
    private function loadAdminOrder(array $config, ContainerBuilder $container)
    {
    }
}
