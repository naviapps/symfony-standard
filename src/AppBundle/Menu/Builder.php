<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @param FactoryInterface $factory
     * @param array $options
     * @return ItemInterface
     */
    public function sideMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('ダッシュボード', ['route' => 'admin_index'])->setExtra('icon', 'fa fa-fw fa-th-large');

        $menu->addChild('ユーザー', ['route' => 'admin_user_index'])->setExtra('icon', 'fa fa-fw fa-user');

        $system = $menu->addChild('システム')->setExtra('icon', 'fa fa-fw fa-cog');
        $system->addChild('ユーザー', ['route' => 'admin_admin_user_index']);

        return $menu;
    }
}
