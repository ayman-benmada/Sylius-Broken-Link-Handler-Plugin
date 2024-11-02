<h1>Sylius Broken Link Handler Plugin</h1>

<p>
    The Broken Link Handler plugin enables automatic permanent redirection from outdated links to updated ones and prevents their use by other entities.
</p>
<p>
    The goal is to optimize your site so that search engines can index it more effectively, which will help improve its organic search ranking (SEO).
</p>

![presentation photo](https://github.com/ayman-benmada/sylius-broken-link-handler-plugin/blob/main/src/Resources/public/presentation.png?raw=true)

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
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Product as BaseProduct;

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
}
```

Update the entity `src/Entity/Taxonomy/Taxon.php` :

```php
<?php

declare(strict_types=1);

namespace App\Entity\Taxonomy;

use Abenmada\BrokenLinkHandlerPlugin\Model\SlugHistory\TaxonSlugHistoryTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Taxon as BaseTaxon;

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
}
```

Run the migration :
```bash
bin/console doctrine:migration:migrate
```
