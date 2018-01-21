<?php

namespace Naviapps\Bundle\CustomerBundle;

//use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class NaviappsCustomerBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        //$container->addCompilerPass(DoctrineOrmMappingsPass::createYamlMappingDriver([__DIR__.'/Resources/config/doctrine/model' => 'Naviapps\Bundle\CustomerBundle\Model']));
    }
}
