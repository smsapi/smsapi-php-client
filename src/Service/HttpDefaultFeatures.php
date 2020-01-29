<?php
declare(strict_types=1);

namespace Smsapi\Client\Service;

use Smsapi\Client\Feature\Blacklist\BlacklistFeature;
use Smsapi\Client\Feature\Blacklist\BlacklistHttpFeature;
use Smsapi\Client\Feature\Contacts\ContactsFeature;
use Smsapi\Client\Feature\Contacts\ContactsHttpFeature;
use Smsapi\Client\Feature\Data\DataFactoryProvider;
use Smsapi\Client\Feature\Hlr\HlrFeature;
use Smsapi\Client\Feature\Hlr\HlrHttpFeature;
use Smsapi\Client\Feature\Push\PushFeature;
use Smsapi\Client\Feature\Push\PushHttpFeature;
use Smsapi\Client\Feature\ShortUrl\ShortUlrHttpFeature;
use Smsapi\Client\Feature\ShortUrl\ShortUrlFeature;
use Smsapi\Client\Feature\Mfa\MfaFeature;
use Smsapi\Client\Feature\Mfa\MfaHttpFeature;
use Smsapi\Client\Feature\Sms\SmsFeature;
use Smsapi\Client\Feature\Sms\SmsHttpFeature;
use Smsapi\Client\Feature\Subusers\SubusersFeature;
use Smsapi\Client\Feature\Ping\PingFeature;
use Smsapi\Client\Feature\Ping\PingHttpFeature;
use Smsapi\Client\Feature\Subusers\SubusersHttpFeature;
use Smsapi\Client\Infrastructure\RequestExecutor\RequestExecutorFactory;

/**
 * @internal
 */
trait HttpDefaultFeatures
{
    /** @var RequestExecutorFactory */
    private $requestExecutorFactory;

    /** @var DataFactoryProvider */
    private $dataFactoryProvider;

    public function pingFeature(): PingFeature
    {
        return new PingHttpFeature($this->requestExecutorFactory->createRestRequestExecutor());
    }

    public function smsFeature(): SmsFeature
    {
        return new SmsHttpFeature($this->requestExecutorFactory, $this->dataFactoryProvider);
    }

    public function mfaFeature(): MfaFeature
    {
        $restRequestExecutor = $this->requestExecutorFactory->createRestRequestExecutor();
        $mfaFactory = $this->dataFactoryProvider->provideMfaFactory();

        return new MfaHttpFeature($restRequestExecutor, $mfaFactory);
    }

    public function hlrFeature(): HlrFeature
    {
        return new HlrHttpFeature(
            $this->requestExecutorFactory->createLegacyRequestExecutor(),
            $this->dataFactoryProvider->provideHlrFactory()
        );
    }

    public function subusersFeature(): SubusersFeature
    {
        return new SubusersHttpFeature(
            $this->requestExecutorFactory->createRestRequestExecutor(),
            $this->dataFactoryProvider->provideSubuserFactory()
        );
    }

    public function shortUrlFeature(): ShortUrlFeature
    {
        return new ShortUlrHttpFeature(
            $this->requestExecutorFactory->createRestRequestExecutor(),
            $this->dataFactoryProvider->provideShortUrlLinkFactory()
        );
    }

    public function contactsFeature(): ContactsFeature
    {
        return new ContactsHttpFeature(
            $this->requestExecutorFactory->createRestRequestExecutor(),
            $this->dataFactoryProvider
        );
    }

    public function pushFeature(): PushFeature
    {
        return new PushHttpFeature(
            $this->requestExecutorFactory->createRestRequestExecutor(),
            $this->dataFactoryProvider->providePushShipmentFactory()
        );
    }

    public function blacklistFeature(): BlacklistFeature
    {
        return new BlacklistHttpFeature(
            $this->requestExecutorFactory->createRestRequestExecutor(),
            $this->dataFactoryProvider->provideBlacklistedPhoneNumberFactory()
        );
    }
}
