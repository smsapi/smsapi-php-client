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
 * @property array $param1
 * @property array $param2
 * @property array $param3
 * @property array $param4
 */
#[\AllowDynamicProperties]
class ScheduleSmssBag
{
    /** @var array */
    public $to;

    /** @var DateTimeInterface */
    public $date;

    /** @var string */
    public $encoding = 'utf-8';

    public static function withMessage(DateTimeInterface $scheduleAt, array $receivers, string $message): self
    {
        $bag = new self();
        $bag->date = $scheduleAt;
        $bag->to = $receivers;
        $bag->message = $message;

        return $bag;
    }

    public static function withTemplateName(DateTimeInterface $scheduleAt, array $receivers, string $templateName): self
    {
        $bag = new self();
        $bag->date = $scheduleAt;
        $bag->to = $receivers;
        $bag->template = $templateName;

        return $bag;
    }

    public function setParams(array $params): self
    {
        foreach ($params as $index => $indexParams) {
            $this->{'param' . $index} = $indexParams;
        }

        return $this;
    }

    public function setExternalId(array $idx, bool $checkIdx = null): self
    {
        $this->idx = $idx;
        $this->checkIdx = $checkIdx;

        return $this;
    }
}
