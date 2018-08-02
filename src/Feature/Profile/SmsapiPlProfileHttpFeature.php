<?php

declare(strict_types=1);

namespace Smsapi\Client\Feature\Profile;

use Smsapi\Client\Feature\Data\DataFactoryProvider;
use Smsapi\Client\Infrastructure\RequestExecutor\RestRequestExecutor;

/**
 * @api
 */
class SmsapiPlProfileHttpFeature implements SmsapiPlProfileFeature
{
    use ProfileDefaultHttpFeatures;

    private $restRequestExecutor;
    private $dataFactoryProvider;

    public function __construct(RestRequestExecutor $restRequestExecutor, DataFactoryProvider $dataFactoryProvider)
    {
        $this->restRequestExecutor = $restRequestExecutor;
        $this->dataFactoryProvider = $dataFactoryProvider;
    }

    public function findProfilePrices(): array
    {
        $result = $this->restRequestExecutor->read('profile/prices', []);
        return array_map(
            [$this->dataFactoryProvider->provideProfilePriceFactory(), 'createFromObject'],
            $result->collection
        );
    }
}
