<?php

declare(strict_types=1);

namespace Abenmada\BrokenLinkHandlerPlugin\Repository;

use Abenmada\BrokenLinkHandlerPlugin\Entity\SlugHistory\ProductSlugHistory;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Channel\Model\ChannelInterface;
use Sylius\Component\Core\Model\ProductInterface;

class ProductSlugHistoryRepository extends EntityRepository
{
    public function findOneByChannelAndLocaleAndSlug(ChannelInterface $channel, ?string $locale, ?string $slug): ?ProductSlugHistory
    {
        return $this // @phpstan-ignore-line
            ->createQueryBuilder('o')
            ->innerJoin('o.product', 'product')
            ->andWhere('o.locale = :locale')
            ->andWhere('o.slug = :slug')
            ->andWhere(':channel MEMBER OF product.channels')
            ->andWhere('product.enabled = :enabled')
            ->setParameter('channel', $channel)
            ->setParameter('locale', $locale)
            ->setParameter('slug', $slug)
            ->setParameter('enabled', true)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function slugExistsInOtherProductHistories(ProductInterface $product, ?string $slug): bool
    {
        return $this
            ->createQueryBuilder('o')
            ->select('COUNT(o.id)')
            ->innerJoin('o.product', 'product')
            ->andWhere('product.id != :productId')
            ->andWhere('o.slug = :slug')
            ->setParameter('productId', $product->getId())
            ->setParameter('slug', $slug)
            ->getQuery()
            ->getSingleScalarResult() > 0
        ;
    }
}
