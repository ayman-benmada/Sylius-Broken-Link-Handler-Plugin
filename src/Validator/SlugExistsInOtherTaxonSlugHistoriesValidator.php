<?php

declare(strict_types=1);

namespace Abenmada\BrokenLinkHandlerPlugin\Validator;

use Abenmada\BrokenLinkHandlerPlugin\Repository\TaxonSlugHistoryRepository;
use Sylius\Component\Core\Model\TaxonInterface;
use Sylius\Component\Taxonomy\Model\TaxonTranslationInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class SlugExistsInOtherTaxonSlugHistoriesValidator extends ConstraintValidator
{
    public function __construct(private readonly TaxonSlugHistoryRepository $taxonSlugHistoryRepository)
    {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof SlugExistsInOtherTaxonSlugHistories) {
            throw new UnexpectedTypeException($constraint, SlugExistsInOtherTaxonSlugHistories::class);
        }

        assert($value instanceof TaxonInterface);

        /** @var TaxonTranslationInterface $taxonTranslation */
        foreach ($value->getTranslations() as $taxonTranslation) {
            if (!$this->taxonSlugHistoryRepository->slugExistsInOtherTaxonHistories($value, $taxonTranslation->getSlug())) {
                continue;
            }

            $this->context
                ->buildViolation($constraint->message)
                ->atPath('translations[' . $taxonTranslation->getLocale() . '].slug')
                ->addViolation();
        }
    }
}
