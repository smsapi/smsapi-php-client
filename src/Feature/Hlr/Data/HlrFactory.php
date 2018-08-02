<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Hlr\Data;

use stdClass;

/**
 * @internal
 */
class HlrFactory
{
    public function createFromObject(stdClass $result): Hlr
    {
        $hlr = new Hlr();
        $hlr->status = $result->status;
        $hlr->number = $result->number;
        $hlr->id = $result->id;
        $hlr->price = (float)$result->price;

        return $hlr;
    }
}
