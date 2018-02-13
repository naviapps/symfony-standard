<?php

namespace Naviapps\Bundle\CustomerBundle\DependencyInjection;

use Naviapps\Component\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class NaviappsCustomerExtension extends Extension
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

        if (!empty($config['admin_customer'])) {
            $this->loadAdminCustomer($config['admin_customer'], $container);
        }
    }

    /**
     * @param array $config
     * @param ContainerBuilder $container
     */
    private function loadAdminCustomer(array $config, ContainerBuilder $container)
    {
        $this->remapParametersNamespaces($config, $container, array(
            'form' => 'naviapps_customer.admin_customer.form.%s',
        ));
    }
}
