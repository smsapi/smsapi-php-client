<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Sms\Mfa\Bag;

/**
 * @api
 * @property string $from
 * @property string $content
 * @property bool $fast
 */
class CreateMfaBag
{
    /**
     * @var string
     */
    public $phone_number;

    /**
     * CreateMfaBag constructor.
     * @param string $phone_number
     */
    public function __construct(string $phone_number)
    {
        $this->phone_number = $phone_number;
    }

    /**
     * @param string $phonenumber
     * @return static
     */
    public static function notFast(string $phonenumber): self
    {
        $createMfaBag = new self($phonenumber);
        $createMfaBag->fast = false;

        return $createMfaBag;
    }
}
