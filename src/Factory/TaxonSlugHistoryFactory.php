<?php

declare(strict_types=1);

namespace Abenmada\BrokenLinkHandlerPlugin\Factory;

use Abenmada\BrokenLinkHandlerPlugin\Entity\SlugHistory\TaxonSlugHistory;
use Sylius\Component\Core\Model\TaxonInterface;
use Sylius\Component\Taxonomy\Model\TaxonTranslationInterface;

class TaxonSlugHistoryFactory
{
    public function createNew(): TaxonSlugHistory
    {
        return new TaxonSlugHistory();
    }

    public function createNewFromTaxonTranslation(TaxonInterface $taxon, TaxonTranslationInterface $taxonTranslation): TaxonSlugHistory
    {
        $taxonSlugHistory = $this->createNew();

        $taxonSlugHistory->setSlug($taxonTranslation->getSlug());
        $taxonSlugHistory->setLocale($taxonTranslation->getLocale());
        $taxonSlugHistory->setTaxon($taxon);

        $taxon->addTaxonSlugHistory($taxonSlugHistory); // @phpstan-ignore-line

        return $taxonSlugHistory;
    }
}
