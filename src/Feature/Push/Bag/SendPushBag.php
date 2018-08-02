<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Push\Bag;

use DateTimeInterface;

/**
 * @api
 * @property DateTimeInterface $scheduledDate
 * @property array $data
 * @property array $channels
 * @property array $deviceIds
 * @property array $deviceType
 * @property array $fallback
 */
class SendPushBag
{
    /** @var string */
    public $appId;

    public function __construct(string $appId, string $alert)
    {
        $this->appId = $appId;
        $this->data['alert'] = $alert;
    }

    public function setFallback(string $message, string $from, int $delay): self
    {
        $this->fallback['message'] = $message;
        $this->fallback['from'] = $from;
        $this->fallback['delay'] = $delay;

        return $this;
    }

    public function setAndroidData(string $title, string $url): self
    {
        $this->data['from'] = $title;
        $this->data['delay'] = $url;

        return $this;
    }

    public function setIosData(string $badge, string $sound, string $category, bool $contentAvailable): self
    {
        $this->data['badge'] = $badge;
        $this->data['sound'] = $sound;
        $this->data['category'] = $category;
        $this->data['contentAvailable'] = $contentAvailable;

        return $this;
    }
}
