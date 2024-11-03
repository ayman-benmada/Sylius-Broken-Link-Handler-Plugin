<h1>Sylius Broken Link Handler Plugin</h1>

<p>
    The Broken Link Handler plugin enables automatic permanent redirection from outdated links to updated ones and prevents their use by other entities.
</p>
<p>
    The goal is to optimize your site so that search engines can index it more effectively, which will help improve its organic search ranking (SEO).
</p>

## Presentation

Whenever you create or update a product's slug, it will be automatically saved in the product's slug history.<br/>
![presentation photo](https://github.com/ayman-benmada/sylius-broken-link-handler-plugin/blob/main/src/Resources/public/presentation-1.png?raw=true)

A slug that has already been used for a product can never be reused for another. This ensures that old slugs will always remain associated with the same product, so that when accessing an old slug, the user will be redirected to the new one.<br/>
![presentation photo](https://github.com/ayman-benmada/sylius-broken-link-handler-plugin/blob/main/src/Resources/public/presentation-2.png?raw=true)

For example, if someone tries to access the URL `/fr_FR/products/000f-grey-jeans`, a 301 redirect will automatically lead to `/fr_FR/products/000f-v2-jean-gris`.<br/>

This slug management system is also implemented for taxons. Thus, when attempting to access the page `/fr_FR/taxons/t-shirts/les-hommes`, a redirection will occur to `/fr_FR/taxons/t-shirts/hommes`.<br/>
![presentation photo](https://github.com/ayman-benmada/sylius-broken-link-handler-plugin/blob/main/src/Resources/public/presentation-3.png?raw=true)

## Installation

Require plugin with composer :

```bash
composer require abenmada/sylius-broken-link-handler-plugin
```

Change your `config/bundles.php` file to add the line for the plugin :

```php
<?php

return [
    //..
    Abenmada\BrokenLinkHandlerPlugin\BrokenLinkHandlerPlugin::class => ['all' => true],
]
```

Then create the config file in `config/packages/abenmada_broken_link_handler_plugin.yaml` :

```yaml
imports:
    - { resource: "@BrokenLinkHandlerPlugin/Resources/config/services.yaml" }
```

Copy the view responsible for displaying the taxon creation form :
````bash
mkdir -p templates/bundles/SyliusAdminBundle/Taxon
cp vendor/abenmada/sylius-broken-link-handler-plugin/src/Resources/views/Admin/Taxon/_form.html.twig templates/bundles/SyliusAdminBundle/Taxon/_form.html.twig
````

Update the entity `src/Entity/Product/Product.php` :

```php
<?php

declare(strict_types=1);

namespace App\Entity\Product;

use Abenmada\BrokenLinkHandlerPlugin\Model\SlugHistory\ProductSlugHistoryTrait;
use Abenmada\BrokenLinkHandlerPlugin\Validator\SlugExistsInOtherProductSlugHistories;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Product as BaseProduct;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_product")
 */
#[ORM\Entity]
#[ORM\Table(name: 'sylius_product')]
class Product extends BaseProduct
{
    use ProductSlugHistoryTrait;

    public function __construct()
    {
        $this->productSlugHistories = new ArrayCollection();
        parent::__construct();
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addConstraint(new SlugExistsInOtherProductSlugHistories([
            'groups' => 'sylius',
        ]));
    }
}
```

Update the entity `src/Entity/Taxonomy/Taxon.php` :

```php
<?php

declare(strict_types=1);

namespace App\Entity\Taxonomy;

use Abenmada\BrokenLinkHandlerPlugin\Model\SlugHistory\TaxonSlugHistoryTrait;
use Abenmada\BrokenLinkHandlerPlugin\Validator\SlugExistsInOtherTaxonSlugHistories;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Taxon as BaseTaxon;
use Symfony\Component\Validator\Mapping\ClassMetadata;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_taxon")
 */
#[ORM\Entity]
#[ORM\Table(name: 'sylius_taxon')]
class Taxon extends BaseTaxon
{
    use TaxonSlugHistoryTrait;

    public function __construct()
    {
        $this->taxonSlugHistories = new ArrayCollection();
        parent::__construct();
    }

    public static function loadValidatorMetadata(ClassMetadata $metadata): void
    {
        $metadata->addConstraint(new SlugExistsInOtherTaxonSlugHistories([
            'groups' => 'sylius',
        ]));
    }
}
```

Run the migration :
```bash
bin/console doctrine:migration:migrate
```
