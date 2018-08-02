<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Assert;

use DateTime;
use PHPUnit\Framework\Assert;
use Smsapi\Client\Feature\ShortUrl\Data\ShortUrlLink;
use stdClass;

class ShortUrlLinkAssert extends Assert
{

    public function assert(stdClass $expectedLink, ShortUrlLink $link)
    {
        $this->assertEquals($expectedLink->id, $link->id);
        $this->assertEquals($expectedLink->url, $link->url);
        $this->assertEquals($expectedLink->short_url, $link->shortUrl);
        $this->assertEquals($expectedLink->name, $link->name);
        $this->assertEquals($expectedLink->description, $link->description);
        $this->assertEquals($expectedLink->hits_unique, $link->hitsUnique);
        $this->assertEquals(new DateTime($expectedLink->expire), $link->expire);
        $this->assertEquals($expectedLink->type, $link->type);
        $this->assertEquals($expectedLink->filename, $link->filename);
    }
}
