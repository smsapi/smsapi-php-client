<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Hlr;

use Smsapi\Client\Feature\Hlr\Bag\SendHlrBag;
use Smsapi\Client\Feature\Hlr\Data\Hlr;

/**
 * @api
 */
interface HlrFeature
{
    public function sendHlr(SendHlrBag $sendHlrBag): Hlr;
}
