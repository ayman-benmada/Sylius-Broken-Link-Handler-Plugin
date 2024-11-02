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

    public function getTaxonSlugHistories(): Collection
    {
        return $this->taxonSlugHistories;
    }

    public function setTaxonSlugHistories(Collection $taxonSlugHistories): void
    {
        $this->taxonSlugHistories = $taxonSlugHistories;
    }

    public function addSlugHistory(TaxonSlugHistory $taxonSlugHistory): void
    {
        if ($this->taxonSlugHistories->contains($taxonSlugHistory)) {
            return;
        }

        $this->taxonSlugHistories[] = $taxonSlugHistory;
        $taxonSlugHistory->setTaxon($this);
    }

    public function removeSlugHistory(TaxonSlugHistory $taxonSlugHistory): void
    {
        $this->taxonSlugHistories->removeElement($taxonSlugHistory);
    }
}
