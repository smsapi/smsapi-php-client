<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Profile\Data;

use DateTime;
use stdClass;

/**
 * @internal
 */
class ProfilePriceFactory
{

    private $countryFactory;

    private $networkFactory;

    private $moneyFactory;

    public function __construct(
        ProfilePriceCountryFactory $countryFactory,
        ProfilePriceNetworkFactory $networkFactory,
        MoneyFactory $moneyFactory
    ) {
        $this->countryFactory = $countryFactory;
        $this->networkFactory = $networkFactory;
        $this->moneyFactory = $moneyFactory;
    }

    public function createFromObject(stdClass $object): ProfilePrice
    {
        $profilePrice = new ProfilePrice();

        $profilePrice->type = $object->type;
        $profilePrice->price = $this->moneyFactory->createFromObject($object->price);
        $profilePrice->country = $this->countryFactory->createFromObject($object->country);
        $profilePrice->network = $this->networkFactory->createFromObject($object->network);

        if ($object->changed_at) {
            $profilePrice->changedAt = DateTime::createFromFormat('Y-m-d', $object->changed_at);
        }

        return $profilePrice;
    }
}
