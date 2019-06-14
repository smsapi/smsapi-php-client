<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Sms\Bag;

/**
 * @api
 */
class DeleteSmsBag
{
    /** @var string */
    public $smsId;

    public function __construct(string $smsId)
    {
        $this->smsId = $smsId;
    }
}
