<?php

declare(strict_types=1);

namespace Abenmada\BrokenLinkHandlerPlugin\EventListener;

use Sylius\Component\Core\Model\ProductInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class ProductListener
{
    public function preCreate(GenericEvent $event): void
    {
        $product = $event->getSubject();
        assert($product instanceof ProductInterface);
    }

    public function preUpdate(GenericEvent $event): void
    {
        $product = $event->getSubject();
        assert($product instanceof ProductInterface);
    }
}
