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
 */
#[\AllowDynamicProperties]
class SendSmsToGroupBag
{
    /** @var string */
    public $group;

    /** @var string */
    public $encoding = 'utf-8';

    public static function withMessage(string $group, string $message): self
    {
        $bag = new self();
        $bag->group = $group;
        $bag->message = $message;

        return $bag;
    }

    public static function withTemplateName(string $group, string $templateName): self
    {
        $bag = new self();
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
     * @see SendSmsToGroupBag::setExternalId()
     */
    public function setIdx(array $idx, bool $checkIdx = null): self
    {
        $this->idx = $idx;
        $this->checkIdx = $checkIdx;

        return $this;
    }
}
