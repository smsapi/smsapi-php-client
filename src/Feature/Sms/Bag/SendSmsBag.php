<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Sms\Bag;

use DateTimeInterface;

/**
 * @api
 * @property string $from
 * @property string $message
 * @property string $template
 * @property array $idx
 * @property bool $checkIdx
 * @property string $partnerId
 * @property DateTimeInterface $expirationDate
 * @property bool $single
 * @property bool $noUnicode
 * @property bool $normalize
 * @property string $notifyUrl
 * @property bool $test
 * @property bool $fast
 * @property string $param1
 * @property string $param2
 * @property string $param3
 * @property string $param4
 */
#[\AllowDynamicProperties]
class SendSmsBag
{
    /** @var string */
    public $to;

    /** @var string */
    public $encoding = 'utf-8';

    public static function withMessage(string $receiver, string $message): self
    {
        $bag = new self();
        $bag->to = $receiver;
        $bag->message = $message;

        return $bag;
    }

    public static function withTemplateName(string $receiver, string $template): self
    {
        $bag = new self();
        $bag->to = $receiver;
        $bag->template = $template;

        return $bag;
    }

    public function setParams(array $params): self
    {
        foreach ($params as $index => $indexParam) {
            $this->{'param' . $index} = $indexParam;
        }

        return $this;
    }

    public function setExternalId(string $idx, bool $checkIdx = null): self
    {
        $this->idx = [$idx];
        $this->checkIdx = $checkIdx;

        return $this;
    }
}
