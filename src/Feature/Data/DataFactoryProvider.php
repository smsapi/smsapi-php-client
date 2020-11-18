<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Data;

use Smsapi\Client\Feature\Blacklist\Data\BlacklistedPhoneNumberFactory;
use Smsapi\Client\Feature\Contacts\Data\ContactCustomFieldFactory;
use Smsapi\Client\Feature\Contacts\Data\ContactFactory;
use Smsapi\Client\Feature\Contacts\Data\ContactGroupFactory;
use Smsapi\Client\Feature\Contacts\Fields\Data\ContactFieldFactory;
use Smsapi\Client\Feature\Contacts\Fields\Data\ContactFieldOptionFactory;
use Smsapi\Client\Feature\Contacts\Groups\Permissions\Data\GroupPermissionFactory;
use Smsapi\Client\Feature\Hlr\Data\HlrFactory;
use Smsapi\Client\Feature\Mms\Data\MmsFactory;
use Smsapi\Client\Feature\Ping\Data\PingFactory;
use Smsapi\Client\Feature\Profile\Data\MoneyFactory;
use Smsapi\Client\Feature\Profile\Data\ProfileFactory;
use Smsapi\Client\Feature\Profile\Data\ProfilePriceCountryFactory;
use Smsapi\Client\Feature\Profile\Data\ProfilePriceFactory;
use Smsapi\Client\Feature\Profile\Data\ProfilePriceNetworkFactory;
use Smsapi\Client\Feature\ShortUrl\Data\ShortUrlLinkFactory;
use Smsapi\Client\Feature\Sms\Data\SmsFactory;
use Smsapi\Client\Feature\Mfa\Data\MfaFactory;
use Smsapi\Client\Feature\Sms\Sendernames\Data\SendernameFactory;
use Smsapi\Client\Feature\Subusers\Data\SubuserFactory;
use Smsapi\Client\Feature\Vms\Data\VmsFactory;

/**
 * @internal
 */
class DataFactoryProvider
{
    public function provideSmsFactory(): SmsFactory
    {
        return new SmsFactory();
    }

    public function provideMmsFactory(): MmsFactory
    {
        return new MmsFactory();
    }

    public function provideVmsFactory(): VmsFactory
    {
        return new VmsFactory();
    }

    public function provideHlrFactory(): HlrFactory
    {
        return new HlrFactory();
    }

    public function provideProfileFactory(): ProfileFactory
    {
        return new ProfileFactory();
    }

    public function provideProfilePriceFactory(): ProfilePriceFactory
    {
        return new ProfilePriceFactory(
            new ProfilePriceCountryFactory(),
            new ProfilePriceNetworkFactory(),
            new MoneyFactory()
        );
    }

    public function provideSendernameFactory(): SendernameFactory
    {
        return new SendernameFactory();
    }

    public function provideMfaFactory(): MfaFactory
    {
        return new MfaFactory();
    }

    public function provideSubuserFactory(): SubuserFactory
    {
        return new SubuserFactory(new PointsFactory());
    }

    public function provideShortUrlLinkFactory(): ShortUrlLinkFactory
    {
        return new ShortUrlLinkFactory();
    }

    public function provideContactFactory(): ContactFactory
    {
        return new ContactFactory($this->provideContactGroupFactory(), $this->provideConntactCustomFieldFactory());
    }

    public function provideContactGroupFactory(): ContactGroupFactory
    {
        return new ContactGroupFactory($this->provideGroupPermissionFactory());
    }

    public function provideGroupPermissionFactory(): GroupPermissionFactory
    {
        return new GroupPermissionFactory();
    }

    public function provideContactFieldFactory(): ContactFieldFactory
    {
        return new ContactFieldFactory();
    }

    public function provideContactFieldOptionFactory(): ContactFieldOptionFactory
    {
        return new ContactFieldOptionFactory();
    }

    public function provideBlacklistedPhoneNumberFactory(): BlacklistedPhoneNumberFactory
    {
        return new BlacklistedPhoneNumberFactory();
    }

    public function provideConntactCustomFieldFactory(): ContactCustomFieldFactory
    {
        return new ContactCustomFieldFactory();
    }

    public function providePingFactory(): PingFactory
    {
        return new PingFactory();
    }
}
