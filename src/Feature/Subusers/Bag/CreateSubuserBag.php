<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Subusers\Bag;

/**
 * @api
 * @property bool $active
 * @property string $description
 */
#[\AllowDynamicProperties]
class CreateSubuserBag
{
    /** @var string */
    public $username;

    public $credentials = [
        'username' => null,
        'password' => null,
        'api_password' => null,
    ];

    /**
     * @var array|null
     */
    public $points = [
        'from_account' => null,
        'per_month' => null,
    ];

    public function __construct(string $username, string $panelPassword)
    {
        $this->credentials['username'] = $username;
        $this->credentials['password'] = $panelPassword;
    }

    public function setPoints(float $fromAccount, float $perMonth)
    {
        $this->points = ['from_account' => $fromAccount, 'per_month' => $perMonth];
    }
}
