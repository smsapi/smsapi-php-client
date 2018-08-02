<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\ShortUrl\Data;

use DateTime;
use stdClass;

/**
 * @internal
 */
class ShortUrlLinkFactory
{

    public function createFromObject(stdClass $object): ShortUrlLink
    {
        $shortUrlLink = new ShortUrlLink();
        $shortUrlLink->id = $object->id;
        $shortUrlLink->name = $object->name;
        $shortUrlLink->url = $object->url;
        $shortUrlLink->shortUrl = $object->short_url;
        $shortUrlLink->filename = $object->filename;
        $shortUrlLink->type = $object->type;
        $shortUrlLink->expire = new DateTime($object->expire);
        $shortUrlLink->hits = $object->hits;
        $shortUrlLink->hitsUnique = $object->hits_unique;
        $shortUrlLink->description = $object->description;
        return $shortUrlLink;
    }
}
