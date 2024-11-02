<?php

declare(strict_types=1);

namespace Abenmada\BrokenLinkHandlerPlugin\EventListener;

use Abenmada\BrokenLinkHandlerPlugin\Factory\TaxonSlugHistoryFactory;
use Sylius\Component\Core\Model\TaxonInterface;
use Sylius\Component\Taxonomy\Model\TaxonTranslationInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

readonly class TaxonListener
{
    public function __construct(private TaxonSlugHistoryFactory $taxonSlugHistoryFactory)
    {
    }

    public function preCreate(GenericEvent $event): void
    {
        $taxon = $event->getSubject();
        assert($taxon instanceof TaxonInterface);

        /** @var TaxonTranslationInterface $taxonTranslation */
        foreach ($taxon->getTranslations() as $taxonTranslation) {
            $this->taxonSlugHistoryFactory->createNewFromTaxonTranslation($taxon, $taxonTranslation);
        }
    }

    public function preUpdate(GenericEvent $event): void
    {
        $taxon = $event->getSubject();
        assert($taxon instanceof TaxonInterface);

        /** @var TaxonTranslationInterface $taxonTranslation */
        foreach ($taxon->getTranslations() as $taxonTranslation) {
            // @phpstan-ignore-next-line
            if ($taxon->hasTaxonSlugHistory($taxonTranslation->getLocale(), $taxonTranslation->getSlug())) {
                continue;
            }

            $this->taxonSlugHistoryFactory->createNewFromTaxonTranslation($taxon, $taxonTranslation);
        }
    }
}
