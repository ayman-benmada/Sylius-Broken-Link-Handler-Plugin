<?php

declare(strict_types=1);

namespace Abenmada\BrokenLinkHandlerPlugin\Entity\SlugHistory;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

/**
 * @ORM\Entity
 *
 * @ORM\Table(name="abenmada_product_slug_history")
 */
#[ORM\Table(name: 'abenmada_product_slug_history')]
#[ORM\Entity]
class ProductSlugHistory implements ResourceInterface
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

    /** @ORM\Column(name="slug", type="string", length=255, nullable=true) */
    #[ORM\Column(name: 'slug', type: 'string', length: 255, nullable: true)]
    private ?string $slug;

    /** @ORM\Column(name="slug", type="string", length=255, nullable=true) */
    #[ORM\Column(name: 'locale', type: 'string', length: 255, nullable: true)]
    private ?string $locale = null;

    /**
     * @ORM\ManyToOne(targetEntity=ProductInterface::class, inversedBy="productSlugHistories")
     *
     * @ORM\JoinColumn(name="product_id", nullable=false)
     */
    #[ORM\JoinColumn(name: 'product_id', nullable: false)]
    #[ORM\ManyToOne(targetEntity: ProductInterface::class, inversedBy: 'productSlugHistories')]
    private ProductInterface $product;

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

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): void
    {
        $this->slug = $slug;
    }

    public function getProduct(): ProductInterface
    {
        return $this->product;
    }

    public function setProduct(ProductInterface $product): void
    {
        $this->product = $product;
    }
}
