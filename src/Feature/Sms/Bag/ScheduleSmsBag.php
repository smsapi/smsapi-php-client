<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Sms\Bag;

use DateTimeInterface;

/**
 * @api
 * @property string $from
 * @property string $message
 * @property string $template
 * @property string $encoding
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
class ScheduleSmsBag
{

    /** @var string */
    public $to;

    /** @var DateTimeInterface */
    public $date;

    public static function withMessage(DateTimeInterface $scheduleAt, string $receiver, string $message): self
    {
        $bag = new self();
        $bag->date = $scheduleAt;
        $bag->to = $receiver;
        $bag->message = $message;

        return $bag;
    }

    public static function withTemplateName(DateTimeInterface $scheduleAt, string $receiver, string $templateName): self
    {
        $bag = new self();
        $bag->date = $scheduleAt;
        $bag->to = $receiver;
        $bag->template = $templateName;

        return $bag;
    }

    public function setParams(array $params): self
    {
        for ($i = 1; $i <= 4; $i++) {
            $this->{'param' . $i} = $params;
        }

        return $this;
    }

    public function setIdx(array $idx, bool $checkIdx = null): self
    {
        $this->idx = $idx;
        $this->checkIdx = $checkIdx;

        return $this;
    }
}
