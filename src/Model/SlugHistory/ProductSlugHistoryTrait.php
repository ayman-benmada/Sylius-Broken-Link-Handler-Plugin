<?php

declare(strict_types=1);

namespace Abenmada\BrokenLinkHandlerPlugin\Model\SlugHistory;

use Abenmada\BrokenLinkHandlerPlugin\Entity\SlugHistory\ProductSlugHistory;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

trait ProductSlugHistoryTrait
{
    /** @ORM\OneToMany(targetEntity=ProductSlugHistory::class, mappedBy="product", orphanRemoval=true, cascade={"all"}) */
    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductSlugHistory::class, cascade: ['all'], orphanRemoval: true)]
    private Collection $productSlugHistories;

    /** @return Collection<array-key, ProductSlugHistory> */
    public function getProductSlugHistories(): Collection
    {
        return $this->productSlugHistories;
    }

    /** @param Collection<array-key, ProductSlugHistory> $productSlugHistories */
    public function setProductSlugHistories(Collection $productSlugHistories): void
    {
        $this->productSlugHistories = $productSlugHistories;
    }

    public function addProductSlugHistory(ProductSlugHistory $productSlugHistory): void
    {
        if ($this->productSlugHistories->contains($productSlugHistory)) {
            return;
        }

        $this->productSlugHistories[] = $productSlugHistory;
        $productSlugHistory->setProduct($this);
    }

    public function removeProductSlugHistory(ProductSlugHistory $productSlugHistory): void
    {
        $this->productSlugHistories->removeElement($productSlugHistory);
    }

    public function getGroupSlugsByLocale(): array
    {
        $groupedSlugs = [];

        foreach ($this->getProductSlugHistories() as $productSlugHistory) {
            $groupedSlugs[$productSlugHistory->getLocale()][] = $productSlugHistory->getSlug();
        }

        return $groupedSlugs;
    }

    public function hasProductSlugHistory(string $locale, string $slug): bool
    {
        foreach ($this->getProductSlugHistories() as $productSlugHistory) {
            if ($productSlugHistory->getLocale() === $locale && $productSlugHistory->getSlug() === $slug) {
                return true;
            }
        }

        return false;
    }
}
