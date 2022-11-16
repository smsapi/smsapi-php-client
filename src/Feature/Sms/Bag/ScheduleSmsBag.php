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
class ScheduleSmsBag
{
    /** @var string */
    public $to;

    /** @var DateTimeInterface */
    public $date;

    /** @var string */
    public $encoding = 'utf-8';

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

    /**
     * @deprecated
     * @see ScheduleSmsBag::setExternalId()
     */
    public function setIdx(array $idx, bool $checkIdx = null): self
    {
        $this->idx = $idx;
        $this->checkIdx = $checkIdx;

        return $this;
    }
}
