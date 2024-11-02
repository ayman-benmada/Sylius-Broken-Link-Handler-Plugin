<?php

declare(strict_types=1);

namespace Abenmada\BrokenLinkHandlerPlugin\Factory;

use Abenmada\BrokenLinkHandlerPlugin\Entity\SlugHistory\ProductSlugHistory;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductTranslationInterface;

class ProductSlugHistoryFactory
{
    public function createNew(): ProductSlugHistory
    {
        return new ProductSlugHistory();
    }

    public function createNewFromProductTranslation(ProductInterface $product, ProductTranslationInterface $productTranslation): ProductSlugHistory
    {
        $productSlugHistory = $this->createNew();

        $productSlugHistory->setSlug($productTranslation->getSlug());
        $productSlugHistory->setLocale($productTranslation->getLocale());
        $productSlugHistory->setProduct($product);

        $product->addProductSlugHistory($productSlugHistory); // @phpstan-ignore-line

        return $productSlugHistory;
    }
}
