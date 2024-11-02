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

    public function getProductSlugHistories(): Collection
    {
        return $this->productSlugHistories;
    }

    public function setProductSlugHistories(Collection $productSlugHistories): void
    {
        $this->productSlugHistories = $productSlugHistories;
    }

    public function addSlugHistory(ProductSlugHistory $productSlugHistory): void
    {
        if ($this->productSlugHistories->contains($productSlugHistory)) {
            return;
        }

        $this->productSlugHistories[] = $productSlugHistory;
        $productSlugHistory->setProduct($this);
    }

    public function removeSlugHistory(ProductSlugHistory $productSlugHistory): void
    {
        $this->productSlugHistories->removeElement($productSlugHistory);
    }
}
