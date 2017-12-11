<?php

namespace App\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;

class MenuBuilder
{
    /** @var FactoryInterface */
    private $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param array $options
     * @return ItemInterface
     */
    public function createAdminSideMenu(array $options)
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('title.dashboard', ['route' => 'admin_index'])->setExtra('icon', 'fa fa-fw fa-th-large');
        $menu->addChild('title.orders', ['route' => 'admin_sales_order_index'])->setExtra('icon', 'fa fa-fw fa-usd');

        $catalog = $menu->addChild('title.catalog')->setExtra('icon', 'fa fa-fw fa-cube');
        $catalog->addChild('title.products', ['route' => 'admin_catalog_product_index']);
        $catalog->addChild('title.categories', ['route' => 'admin_catalog_category_index']);

        $menu->addChild('title.customers', ['route' => 'admin_user_index'])->setExtra('icon', 'fa fa-fw fa-user');

        $content = $menu->addChild('title.content')->setExtra('icon', 'fa fa-fw fa-columns');
        $content->addChild('title.pages', ['route' => 'naviapps_cms_admin_page_index']);
        $content->addChild('title.blocks', ['route' => 'naviapps_cms_admin_block_index']);

        $system = $menu->addChild('title.system')->setExtra('icon', 'fa fa-fw fa-cog');
        $system->addChild('title.users', ['route' => 'admin_admin_user_index']);

        return $menu;
    }
}
