<?php

declare(strict_types=1);

namespace Abenmada\BrokenLinkHandlerPlugin\Repository;

use Abenmada\BrokenLinkHandlerPlugin\Entity\SlugHistory\TaxonSlugHistory;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Model\TaxonInterface;

class TaxonSlugHistoryRepository extends EntityRepository
{
    public function findOneByLocaleAndSlug(?string $locale, ?string $slug): ?TaxonSlugHistory
    {
        return $this // @phpstan-ignore-line
            ->createQueryBuilder('o')
            ->innerJoin('o.taxon', 'taxon')
            ->andWhere('o.locale = :locale')
            ->andWhere('o.slug = :slug')
            ->andWhere('taxon.enabled = :enabled')
            ->setParameter('locale', $locale)
            ->setParameter('slug', $slug)
            ->setParameter('enabled', true)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function slugExistsInOtherTaxonHistories(TaxonInterface $taxon, ?string $slug): bool
    {
        return $this
                ->createQueryBuilder('o')
                ->select('COUNT(o.id)')
                ->innerJoin('o.taxon', 'taxon')
                ->andWhere('taxon.id != :taxonId')
                ->andWhere('o.slug = :slug')
                ->setParameter('taxonId', $taxon->getId())
                ->setParameter('slug', $slug)
                ->getQuery()
                ->getSingleScalarResult() > 0
        ;
    }
}
