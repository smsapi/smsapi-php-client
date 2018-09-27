<?php
declare(strict_types=1);

namespace Smsapi\Client\Service;

use Smsapi\Client\Feature\Contacts\ContactsFeature;
use Smsapi\Client\Feature\Contacts\ContactsHttpFeature;
use Smsapi\Client\Feature\Data\DataFactoryProvider;
use Smsapi\Client\Feature\Hlr\HlrFeature;
use Smsapi\Client\Feature\Hlr\HlrHttpFeature;
use Smsapi\Client\Feature\Push\PushFeature;
use Smsapi\Client\Feature\Push\PushHttpFeature;
use Smsapi\Client\Feature\ShortUrl\ShortUlrHttpFeature;
use Smsapi\Client\Feature\ShortUrl\ShortUrlFeature;
use Smsapi\Client\Feature\Sms\SmsFeature;
use Smsapi\Client\Feature\Sms\SmsHttpFeature;
use Smsapi\Client\Feature\Subusers\SubusersFeature;
use Smsapi\Client\Feature\Ping\PingFeature;
use Smsapi\Client\Feature\Ping\PingHttpFeature;
use Smsapi\Client\Feature\Subusers\SubusersHttpFeature;
use Smsapi\Client\Infrastructure\Request\LegacyRequestBuilderFactory;
use Smsapi\Client\Infrastructure\Request\RestRequestBuilderFactory;
use Smsapi\Client\Infrastructure\RequestExecutor\LegacyRequestExecutor;
use Smsapi\Client\Infrastructure\RequestExecutor\RestRequestExecutor;

/**
 * @internal
 */
trait HttpDefaultFeatures
{
    /**
     * @var LegacyRequestExecutor
     */
    private $legacyExecutor;

    /**
     * @var RestRequestExecutor
     */
    private $restExecutor;

    /**
     * @var RestRequestBuilderFactory
     */
    private $restRequestBuilderFactory;

    /**
     * @var LegacyRequestBuilderFactory
     */
    private $legacyRequestBuilderFactory;

    /** @var DataFactoryProvider */
    private $dataFactoryProvider;

    public function pingFeature(): PingFeature
    {
        return new PingHttpFeature(
            $this->restExecutor,
            $this->restRequestBuilderFactory
        );
    }

    public function smsFeature(): SmsFeature
    {
        return new SmsHttpFeature(
            $this->legacyExecutor,
            $this->restExecutor,
            $this->legacyRequestBuilderFactory,
            $this->restRequestBuilderFactory,
            $this->dataFactoryProvider
        );
    }

    public function hlrFeature(): HlrFeature
    {
        return new HlrHttpFeature(
            $this->legacyExecutor,
            $this->legacyRequestBuilderFactory,
            $this->dataFactoryProvider->provideHlrFactory()
        );
    }

    public function subusersFeature(): SubusersFeature
    {
        return new SubusersHttpFeature(
            $this->restExecutor,
            $this->restRequestBuilderFactory,
            $this->dataFactoryProvider->provideSubuserFactory()
        );
    }

    public function shortUrlFeature(): ShortUrlFeature
    {
        return new ShortUlrHttpFeature(
            $this->restExecutor,
            $this->restRequestBuilderFactory,
            $this->dataFactoryProvider->provideShortUrlLinkFactory()
        );
    }

    public function contactsFeature(): ContactsFeature
    {
        return new ContactsHttpFeature(
            $this->restExecutor,
            $this->restRequestBuilderFactory,
            $this->dataFactoryProvider
        );
    }

    public function pushFeature(): PushFeature
    {
        return new PushHttpFeature(
            $this->restExecutor,
            $this->restRequestBuilderFactory,
            $this->dataFactoryProvider->providePushShipmentFactory()
        );
    }
}
