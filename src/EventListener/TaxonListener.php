<?php

declare(strict_types=1);

namespace Abenmada\BrokenLinkHandlerPlugin\EventListener;

use Sylius\Component\Core\Model\TaxonInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

class TaxonListener
{
    public function preCreate(GenericEvent $event): void
    {
        $taxon = $event->getSubject();
        assert($taxon instanceof TaxonInterface);
    }

    public function preUpdate(GenericEvent $event): void
    {
        $taxon = $event->getSubject();
        assert($taxon instanceof TaxonInterface);
    }
}
