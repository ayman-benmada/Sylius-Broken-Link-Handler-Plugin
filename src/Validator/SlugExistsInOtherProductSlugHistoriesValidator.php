<?php

declare(strict_types=1);

namespace Abenmada\BrokenLinkHandlerPlugin\Validator;

use Abenmada\BrokenLinkHandlerPlugin\Repository\ProductSlugHistoryRepository;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductTranslationInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class SlugExistsInOtherProductSlugHistoriesValidator extends ConstraintValidator
{
    public function __construct(private readonly ProductSlugHistoryRepository $productSlugHistoryRepository)
    {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof SlugExistsInOtherProductSlugHistories) {
            throw new UnexpectedTypeException($constraint, SlugExistsInOtherProductSlugHistories::class);
        }

        assert($value instanceof ProductInterface);

        /** @var ProductTranslationInterface $productTranslation */
        foreach ($value->getTranslations() as $productTranslation) {
            if (!$this->productSlugHistoryRepository->slugExistsInOtherProductHistories($value, $productTranslation->getSlug())) {
                continue;
            }

            $this->context
                ->buildViolation($constraint->message)
                ->atPath('translations[' . $productTranslation->getLocale() . '].slug')
                ->addViolation();
        }
    }
}
