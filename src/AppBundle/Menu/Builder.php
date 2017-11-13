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

        $menu->addChild('title.dashboard', ['route' => 'admin_index'])->setExtra('icon', 'fa fa-fw fa-th-large');
        $menu->addChild('title.orders', ['route' => 'admin_order_index'])->setExtra('icon', 'fa fa-fw fa-usd');
        $menu->addChild('title.customers', ['route' => 'admin_customer_index'])->setExtra('icon', 'fa fa-fw fa-user');

        $content = $menu->addChild('title.content')->setExtra('icon', 'fa fa-fw fa-columns');
        $content->addChild('title.pages', ['route' => 'admin_page_index']);

        $system = $menu->addChild('title.system')->setExtra('icon', 'fa fa-fw fa-cog');
        $system->addChild('title.users', ['route' => 'admin_user_index']);

        return $menu;
    }
}
