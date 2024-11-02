<?php

declare(strict_types=1);

namespace Abenmada\BrokenLinkHandlerPlugin\Menu\Listener;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

class AdminProductFormMenuListener
{
    public function addItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $menu
            ->addChild('productSlugHistories')
            ->setAttribute('template', '@BrokenLinkHandlerPlugin/Admin/Product/Tab/_productSlugHistories.html.twig')
            ->setLabel('abenmada_broken_link_handler_plugin.ui.slug_histories');
    }
}
