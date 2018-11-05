<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Unit\Feature\ShortUrl;

use Smsapi\Client\Feature\ShortUrl\Bag\CreateShortUrlLinkBag;
use Smsapi\Client\Feature\ShortUrl\ShortUrlFeature;
use Smsapi\Client\Infrastructure\ResponseHttpCode;
use Smsapi\Client\Tests\Assert\ShortUrlLinkAssert;
use Smsapi\Client\Tests\Fixture;
use Smsapi\Client\Tests\SmsapiClientUnitTestCase;

class ShortUrlFeatureTest extends SmsapiClientUnitTestCase
{

    /** @var ShortUrlFeature */
    private $feature;

    /** @var ShortUrlLinkAssert */
    private $assert;

    /**
     * @before
     */
    public function before()
    {
        $this->feature = self::$smsapiService->shortUrlFeature();
        $this->assert = new ShortUrlLinkAssert();
    }

    /**
     * @test
     */
    public function it_should_create_link()
    {
        $body = Fixture::getJson('short_url_link_response');
        $this->mockResponse(ResponseHttpCode::CREATED, $body);
        $expectedLink = json_decode($body);
        $createShortUrlLinkBag = CreateShortUrlLinkBag::withUrl($expectedLink->url);

        $link = $this->feature->createShortUrlLink($createShortUrlLinkBag);

        $this->assert->assert($expectedLink, $link);
    }
}
