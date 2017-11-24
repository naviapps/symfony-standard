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
        $menu->addChild('title.orders', ['route' => 'naviapps_sales_admin_order_index'])->setExtra('icon', 'fa fa-fw fa-usd');
        $menu->addChild('title.customers', ['route' => 'naviapps_customer_admin_customer_index'])->setExtra('icon', 'fa fa-fw fa-user');

        $content = $menu->addChild('title.content')->setExtra('icon', 'fa fa-fw fa-columns');
        $content->addChild('title.pages', ['route' => 'naviapps_cms_admin_page_index']);
        $content->addChild('title.blocks', ['route' => 'naviapps_cms_admin_block_index']);

        $system = $menu->addChild('title.system')->setExtra('icon', 'fa fa-fw fa-cog');
        $system->addChild('title.users', ['route' => 'naviapps_user_admin_user_index']);

        return $menu;
    }
}
