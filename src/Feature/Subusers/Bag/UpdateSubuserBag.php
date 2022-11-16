<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Subusers\Bag;

/**
 * @api
 * @property array $credentials
 * @property array $points
 * @property bool $active
 * @property string $description
 */
#[\AllowDynamicProperties]
class UpdateSubuserBag
{
    /** @var string */
    public $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function setPassword(string $panelPassword)
    {
        $this->credentials['password'] = $panelPassword;
    }

    public function setApiPassword(string $apiPassword)
    {
        $this->credentials['api_password'] = $apiPassword;
    }

    public function setPoints(float $fromAccount, float $perMonth)
    {
        $this->points = ['from_account' => $fromAccount, 'per_month' => $perMonth];
    }
}
