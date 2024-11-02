<?php

declare(strict_types=1);

namespace Abenmada\BrokenLinkHandlerPlugin\EventListener;

use Abenmada\BrokenLinkHandlerPlugin\Factory\ProductSlugHistoryFactory;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductTranslationInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

readonly class ProductListener
{
    public function __construct(private ProductSlugHistoryFactory $productSlugHistoryFactory)
    {
    }

    public function preCreate(GenericEvent $event): void
    {
        $product = $event->getSubject();
        assert($product instanceof ProductInterface);

        /** @var ProductTranslationInterface $productTranslation */
        foreach ($product->getTranslations() as $productTranslation) {
            $this->productSlugHistoryFactory->createNewFromProductTranslation($product, $productTranslation);
        }
    }

    public function preUpdate(GenericEvent $event): void
    {
        $product = $event->getSubject();
        assert($product instanceof ProductInterface);

        /** @var ProductTranslationInterface $productTranslation */
        foreach ($product->getTranslations() as $productTranslation) {
            // @phpstan-ignore-next-line
            if ($product->hasProductSlugHistory($productTranslation->getLocale(), $productTranslation->getSlug())) {
                continue;
            }

            $this->productSlugHistoryFactory->createNewFromProductTranslation($product, $productTranslation);
        }
    }
}
