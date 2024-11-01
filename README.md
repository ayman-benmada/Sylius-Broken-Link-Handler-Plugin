<h1>Sylius Broken Link Handler Plugin</h1>

<p>
    The Broken Link Handler plugin enables automatic permanent redirection from outdated links to updated ones and prevents their use by other entities.
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

Run the migration :
```bash
bin/console doctrine:migration:migrate
```
