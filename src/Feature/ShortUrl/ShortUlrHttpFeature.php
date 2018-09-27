<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\ShortUrl;

use Fig\Http\Message\RequestMethodInterface;
use Smsapi\Client\Feature\ShortUrl\Bag\CreateShortUrlLinkBag;
use Smsapi\Client\Feature\ShortUrl\Data\ShortUrlLink;
use Smsapi\Client\Feature\ShortUrl\Data\ShortUrlLinkFactory;
use Smsapi\Client\Infrastructure\Request\RestRequestBuilderFactory;
use Smsapi\Client\Infrastructure\RequestExecutor\RestRequestExecutor;

/**
 * @internal
 */
class ShortUlrHttpFeature implements ShortUrlFeature
{
    /**
     * @var RestRequestExecutor
     */
    private $requestExecutor;

    /**
     * @var ShortUrlLinkFactory
     */
    private $factory;

    /**
     * @var RestRequestBuilderFactory
     */
    private $requestBuilderFactory;

    public function __construct(
        RestRequestExecutor $requestExecutor,
        RestRequestBuilderFactory $requestBuilderFactory,
        ShortUrlLinkFactory $factory
    ) {
        $this->requestExecutor = $requestExecutor;
        $this->requestBuilderFactory = $requestBuilderFactory;
        $this->factory = $factory;
    }

    /**
     * @inheritdoc
     */
    public function createShortUrlLink(CreateShortUrlLinkBag $createShortUrlLink): ShortUrlLink
    {
        $builder = $this->requestBuilderFactory->create();

        $request = $builder
            ->withMethod(RequestMethodInterface::METHOD_POST)
            ->withPath('short_url/links')
            ->withBuiltInParameters((array) $createShortUrlLink)
            ->get();

        $result = $this->requestExecutor->execute($request);

        return $this->factory->createFromObject($result);
    }
}
