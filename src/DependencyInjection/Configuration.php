<?php

declare(strict_types=1);

namespace Abenmada\BrokenLinkHandlerPlugin\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        return new TreeBuilder('abenmada_broken_link_handler_plugin');
    }
}
