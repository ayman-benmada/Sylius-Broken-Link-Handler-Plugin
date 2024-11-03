# CHANGELOG

## CHANGELOG FOR `1.0.0` (2024-11-03)

#### Details

- Automatic and permanent redirection to the new product slug when accessing the `sylius_shop_product_show` route via an old slug.
- Automatic and permanent redirection to the new taxon slug when accessing the `sylius_shop_product_index` route via an old slug.
- Restriction on using a slug that exists in the history of another product or taxon when creating/modifying a slug.
- Added a section in the product and taxon creation/edit forms to display the history of associated slugs.
