<?php

declare(strict_types=1);

namespace Abenmada\BrokenLinkHandlerPlugin\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class SlugExistsInOtherProductSlugHistories extends Constraint
{
    public string $message = "Le slug figure dans l'historique des slugs d'un autre produit.";

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}
