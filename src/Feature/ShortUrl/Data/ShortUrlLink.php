<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\ShortUrl\Data;

use DateTimeInterface;

/**
 * @api
 */
class ShortUrlLink
{

    /** @var int */
    public $id;

    /** @var string */
    public $name;

    /** @var string */
    public $url;

    /** @var string */
    public $shortUrl;

    /** @var string|null */
    public $filename;

    /** @var string */
    public $type;

    /** @var DateTimeInterface */
    public $expire;

    /** @var int */
    public $hits;

    /** @var int */
    public $hitsUnique;

    /** @var string */
    public $description;
}
