<?php

declare(strict_types=1);

namespace Abenmada\BrokenLinkHandlerPlugin\EventListener;

use Abenmada\BrokenLinkHandlerPlugin\Repository\ProductSlugHistoryRepository;
use Abenmada\BrokenLinkHandlerPlugin\Repository\TaxonSlugHistoryRepository;
use Sylius\Component\Channel\Context\ChannelContextInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;

readonly class Exception404Listener
{
    public function __construct(
        private RouterInterface $router,
        private ProductSlugHistoryRepository $productSlugHistoryRepository,
        private TaxonSlugHistoryRepository $taxonSlugHistoryRepository,
        private ChannelContextInterface $channelContext,
    ) {
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        if (!$event->getThrowable() instanceof NotFoundHttpException) {
            return;
        }

        $request = $event->getRequest();

        $routeName = $request->attributes->get('_route');

        if (!in_array($routeName, ['sylius_shop_product_show', 'sylius_shop_product_index'], true)) {
            return;
        }

        $locale = $request->attributes->get('_locale');
        assert(is_string($locale));

        $slug = $request->attributes->get('slug');
        assert(is_string($slug));

        if ($routeName === 'sylius_shop_product_show') {
            $channel = $this->channelContext->getChannel();

            $productSlugHistory = $this->productSlugHistoryRepository->findOneByChannelAndLocaleAndSlug($channel, $locale, $slug);

            if ($productSlugHistory === null) {
                return;
            }

            $productTranslation = $productSlugHistory->getProduct()->getTranslation($productSlugHistory->getLocale());

            $redirectUrl = $this->router->generate('sylius_shop_product_show', ['_locale' => $productTranslation->getLocale(), 'slug' => $productTranslation->getSlug()]);
        } else {
            $taxonSlugHistory = $this->taxonSlugHistoryRepository->findOneByLocaleAndSlug($locale, $slug);
            if ($taxonSlugHistory === null) {
                return;
            }

            $taxonTranslation = $taxonSlugHistory->getTaxon()->getTranslation($taxonSlugHistory->getLocale());

            $redirectUrl = $this->router->generate('sylius_shop_product_index', ['_locale' => $taxonTranslation->getLocale(), 'slug' => $taxonTranslation->getSlug()]);
        }

        $response = new RedirectResponse($redirectUrl, Response::HTTP_MOVED_PERMANENTLY);

        $event->setResponse($response);
    }
}
