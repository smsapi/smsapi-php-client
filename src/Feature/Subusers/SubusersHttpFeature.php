<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Subusers;

use Smsapi\Client\Feature\Subusers\Bag\CreateSubuserBag;
use Smsapi\Client\Feature\Subusers\Bag\DeleteSubuserBag;
use Smsapi\Client\Feature\Subusers\Bag\UpdateSubuserBag;
use Smsapi\Client\Feature\Subusers\Data\Subuser;
use Smsapi\Client\Feature\Subusers\Data\SubuserFactory;
use Smsapi\Client\Infrastructure\RequestExecutor\RestRequestExecutor;
use Smsapi\Client\SmsapiClientException;

/**
 * @internal
 */
class SubusersHttpFeature implements SubusersFeature
{
    private $restRequestExecutor;
    private $subuserFactory;

    public function __construct(RestRequestExecutor $restRequestExecutor, SubuserFactory $subuserFactory)
    {
        $this->restRequestExecutor = $restRequestExecutor;
        $this->subuserFactory = $subuserFactory;
    }

    /**
     * @param CreateSubuserBag $createSubuser
     * @return Subuser
     * @throws SmsapiClientException
     */
    public function createSubuser(CreateSubuserBag $createSubuser): Subuser
    {
        $result = $this->restRequestExecutor->create('subusers', (array)$createSubuser);

        return $this->subuserFactory->createFromObject($result);
    }

    /**
     * @return array
     * @throws SmsapiClientException
     */
    public function findSubusers(): array
    {
        $result = $this->restRequestExecutor->read('subusers', []);

        return array_map([$this->subuserFactory, 'createFromObject'], $result->collection);
    }

    /**
     * @param DeleteSubuserBag $deleteSubuser
     * @throws SmsapiClientException
     */
    public function deleteSubuser(DeleteSubuserBag $deleteSubuser)
    {
        $this->restRequestExecutor->delete(sprintf('subusers/%s', $deleteSubuser->id), []);
    }

    public function updateSubuser(UpdateSubuserBag $updateSubuser): Subuser
    {
        $subuserId = $updateSubuser->id;
        unset($updateSubuser->id);

        $result = $this->restRequestExecutor->update(sprintf('subusers/%s', $subuserId), (array)$updateSubuser);

        return $this->subuserFactory->createFromObject($result);
    }
}
