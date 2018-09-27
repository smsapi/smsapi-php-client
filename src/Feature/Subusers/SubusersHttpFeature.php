<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Subusers;

use Fig\Http\Message\RequestMethodInterface;
use Smsapi\Client\Feature\Subusers\Bag\CreateSubuserBag;
use Smsapi\Client\Feature\Subusers\Bag\DeleteSubuserBag;
use Smsapi\Client\Feature\Subusers\Data\Subuser;
use Smsapi\Client\Feature\Subusers\Data\SubuserFactory;
use Smsapi\Client\Infrastructure\Request\RestRequestBuilderFactory;
use Smsapi\Client\Infrastructure\RequestExecutor\RestRequestExecutor;
use Smsapi\Client\SmsapiClientException;

/**
 * @internal
 */
class SubusersHttpFeature implements SubusersFeature
{
    /**
     * @var RestRequestExecutor
     */
    private $restRequestExecutor;

    /**
     * @var RestRequestBuilderFactory
     */
    private $restRequestBuilderFactory;

    /**
     * @var SubuserFactory
     */
    private $subuserFactory;

    public function __construct(
        RestRequestExecutor $restRequestExecutor,
        RestRequestBuilderFactory $restRequestBuilderFactory,
        SubuserFactory $subuserFactory
    ) {
        $this->restRequestExecutor = $restRequestExecutor;
        $this->restRequestBuilderFactory = $restRequestBuilderFactory;
        $this->subuserFactory = $subuserFactory;
    }

    /**
     * @param CreateSubuserBag $createSubuser
     * @return Subuser
     * @throws SmsapiClientException
     */
    public function createSubuser(CreateSubuserBag $createSubuser): Subuser
    {
        $requestBuilder = $this->restRequestBuilderFactory->create();

        $request = $requestBuilder
            ->withMethod(RequestMethodInterface::METHOD_POST)
            ->withPath('subusers')
            ->withBuiltInParameters((array) $createSubuser)
            ->get();

        $result = $this->restRequestExecutor->execute($request);

        return $this->subuserFactory->createFromObject($result);
    }

    /**
     * @return array
     * @throws SmsapiClientException
     */
    public function findSubusers(): array
    {
        $requestBuilder = $this->restRequestBuilderFactory->create();

        $request = $requestBuilder
            ->withMethod(RequestMethodInterface::METHOD_GET)
            ->withPath('subusers')
            ->get();

        $result = $this->restRequestExecutor->execute($request);

        return array_map([$this->subuserFactory, 'createFromObject'], $result->collection);
    }

    /**
     * @param DeleteSubuserBag $deleteSubuser
     * @throws SmsapiClientException
     */
    public function deleteSubuser(DeleteSubuserBag $deleteSubuser)
    {
        $requestBuilder = $this->restRequestBuilderFactory->create();

        $request = $requestBuilder
            ->withMethod(RequestMethodInterface::METHOD_DELETE)
            ->withPath(sprintf('subusers/%s', $deleteSubuser->id))
            ->get();

        $this->restRequestExecutor->execute($request);
    }
}
