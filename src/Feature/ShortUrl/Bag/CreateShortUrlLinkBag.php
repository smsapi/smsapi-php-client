<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\ShortUrl\Bag;

use DateTimeInterface;

/**
 * @api
 * @property string $url
 * @property string $file
 * @property string $name
 * @property DateTimeInterface $expire
 * @property string $description
 */
#[\AllowDynamicProperties]
class CreateShortUrlLinkBag
{

    public static function withUrl(string $url): self
    {
        $bag = new CreateShortUrlLinkBag();
        $bag->url = $url;
        return $bag;
    }

    public static function withFile(string $file): self
    {
        $bag = new self();
        $bag->file = $file;
        return $bag;
    }
}
