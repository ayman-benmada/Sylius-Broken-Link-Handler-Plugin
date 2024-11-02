<?php

declare(strict_types=1);

namespace Abenmada\BrokenLinkHandlerPlugin\Model\SlugHistory;

use Abenmada\BrokenLinkHandlerPlugin\Entity\SlugHistory\TaxonSlugHistory;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

trait TaxonSlugHistoryTrait
{
    /** @ORM\OneToMany(targetEntity=TaxonSlugHistory::class, mappedBy="taxon", orphanRemoval=true, cascade={"all"}) */
    #[ORM\OneToMany(mappedBy: 'taxon', targetEntity: TaxonSlugHistory::class, cascade: ['all'], orphanRemoval: true)]
    private Collection $taxonSlugHistories;

    /** @return Collection<array-key, TaxonSlugHistory> */
    public function getTaxonSlugHistories(): Collection
    {
        return $this->taxonSlugHistories;
    }

    /** @param Collection<array-key, TaxonSlugHistory> $taxonSlugHistories */
    public function setTaxonSlugHistories(Collection $taxonSlugHistories): void
    {
        $this->taxonSlugHistories = $taxonSlugHistories;
    }

    public function addTaxonSlugHistory(TaxonSlugHistory $taxonSlugHistory): void
    {
        if ($this->taxonSlugHistories->contains($taxonSlugHistory)) {
            return;
        }

        $this->taxonSlugHistories[] = $taxonSlugHistory;
        $taxonSlugHistory->setTaxon($this);
    }

    public function removeTaxonSlugHistory(TaxonSlugHistory $taxonSlugHistory): void
    {
        $this->taxonSlugHistories->removeElement($taxonSlugHistory);
    }

    public function getGroupSlugsByLocale(): array
    {
        $groupedSlugs = [];

        foreach ($this->getTaxonSlugHistories() as $taxonSlugHistory) {
            $groupedSlugs[$taxonSlugHistory->getLocale()][] = $taxonSlugHistory->getSlug();
        }

        return $groupedSlugs;
    }

    public function hasTaxonSlugHistory(string $locale, string $slug): bool
    {
        foreach ($this->getTaxonSlugHistories() as $taxonSlugHistory) {
            if ($taxonSlugHistory->getLocale() === $locale && $taxonSlugHistory->getSlug() === $slug) {
                return true;
            }
        }

        return false;
    }
}
