<?php

declare(strict_types=1);

namespace Abenmada\BrokenLinkHandlerPlugin\Entity\SlugHistory;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Sylius\Component\Core\Model\TaxonInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * @ORM\Entity
 *
 * @ORM\Table(name="abenmada_taxon_slug_history")
 */
#[ORM\Table(name: 'abenmada_taxon_slug_history')]
#[ORM\Entity]
class TaxonSlugHistory implements ResourceInterface
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     *
     * @ORM\GeneratedValue
     *
     * @ORM\Column(type="integer")
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /** @ORM\Column(name="slug", type="string", length=255, nullable=false) */
    #[ORM\Column(name: 'slug', type: 'string', length: 255, nullable: false)]
    private string $slug;

    /** @ORM\Column(name="slug", type="string", length=255, nullable=true) */
    #[ORM\Column(name: 'locale', type: 'string', length: 255, nullable: true)]
    private ?string $locale = null;

    /**
     * @ORM\ManyToOne(targetEntity=TaxonInterface::class, inversedBy="taxonSlugHistories")
     *
     * @ORM\JoinColumn(name="taxon_id", nullable=false)
     */
    #[ORM\JoinColumn(name: 'taxon_id', nullable: false)]
    #[ORM\ManyToOne(targetEntity: TaxonInterface::class, inversedBy: 'taxonSlugHistories')]
    private TaxonInterface $taxon;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(?string $locale): void
    {
        $this->locale = $locale;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function getTaxon(): TaxonInterface
    {
        return $this->taxon;
    }

    public function setTaxon(TaxonInterface $taxon): void
    {
        $this->taxon = $taxon;
    }
}
