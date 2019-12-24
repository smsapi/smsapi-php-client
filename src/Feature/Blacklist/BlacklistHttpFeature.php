<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Blacklist;

use Smsapi\Client\Feature\Blacklist\Bag\CreateBlacklistedPhoneNumberBag;
use Smsapi\Client\Feature\Blacklist\Bag\FindBlacklistedPhoneNumbersBag;
use Smsapi\Client\Feature\Blacklist\Data\BlacklistedPhoneNumberFactory;
use Smsapi\Client\Feature\Blacklist\Data\BlacklistedPhoneNumber;
use Smsapi\Client\Infrastructure\RequestExecutor\RestRequestExecutor;

/**
 * @internal
 */
class BlacklistHttpFeature implements BlacklistFeature
{
    private $restRequestExecutor;
    private $blacklistedPhoneNumberFactory;

    public function __construct(RestRequestExecutor $restRequestExecutor, BlacklistedPhoneNumberFactory $blacklistedPhoneNumberFactory)
    {
        $this->restRequestExecutor = $restRequestExecutor;
        $this->blacklistedPhoneNumberFactory = $blacklistedPhoneNumberFactory;
    }

    public function createBlacklistedPhoneNumber(CreateBlacklistedPhoneNumberBag $createBlacklistedPhoneNumberBag): BlacklistedPhoneNumber
    {
        $result = $this->restRequestExecutor->create('blacklist/phone_numbers', (array)$createBlacklistedPhoneNumberBag);

        return $this->blacklistedPhoneNumberFactory->createFromObject($result);
    }

    public function findBlacklistedPhoneNumbers(FindBlacklistedPhoneNumbersBag $blacklistPhoneNumbersFindBag): array
    {
        $result = $this->restRequestExecutor->read('blacklist/phone_numbers', (array)$blacklistPhoneNumbersFindBag);

        return array_map(
            [$this->blacklistedPhoneNumberFactory, 'createFromObject'],
            $result->collection
        );
    }

    public function deleteBlacklistedPhoneNumber(Bag\DeleteBlacklistedPhoneNumberBag $blacklistPhoneNumberDeleteBag)
    {
        $this->restRequestExecutor->delete('blacklist/phone_numbers/' . $blacklistPhoneNumberDeleteBag->id, []);
    }

    public function deleteBlacklistedPhoneNumbers()
    {
        $this->restRequestExecutor->delete('blacklist/phone_numbers/', []);
    }
}
