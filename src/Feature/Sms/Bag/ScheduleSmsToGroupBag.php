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
 */
#[\AllowDynamicProperties]
class ScheduleSmsToGroupBag
{

    /** @var string */
    public $group;

    /** @var bool */
    public $dateValidate = true;

    /** @var DateTimeInterface */
    public $date;

    public static function withMessage(DateTimeInterface $scheduleAt, string $group, string $message): self
    {
        $bag = new self();
        $bag->date = $scheduleAt;
        $bag->group = $group;
        $bag->message = $message;

        return $bag;
    }

    public static function withTemplateName(DateTimeInterface $scheduleAt, string $group, string $templateName): self
    {
        $bag = new self();
        $bag->date = $scheduleAt;
        $bag->group = $group;
        $bag->template = $templateName;

        return $bag;
    }

    public function setExternalId(string $idx, bool $checkIdx = null): self
    {
        $this->idx = [$idx];
        $this->checkIdx = $checkIdx;

        return $this;
    }

    /**
     * @deprecated
     * @see ScheduleSmsToGroupBag::setExternalId()
     */
    public function setIdx(array $idx, bool $checkIdx = null): self
    {
        $this->idx = $idx;
        $this->checkIdx = $checkIdx;

        return $this;
    }
}
