<?php

declare(strict_types=1);

namespace Abenmada\BrokenLinkHandlerPlugin\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class SlugExistsInOtherTaxonSlugHistories extends Constraint
{
    public string $message = 'abenmada_broken_link_handler_plugin.error.the_slug_appears_in_the_slug_history_of_another_taxon';

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
