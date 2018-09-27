<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Sms\Sendernames;

use Fig\Http\Message\RequestMethodInterface;
use Smsapi\Client\Feature\Sms\Sendernames\Bag\CreateSendernameBag;
use Smsapi\Client\Feature\Sms\Sendernames\Bag\DeleteSendernameBag;
use Smsapi\Client\Feature\Sms\Sendernames\Bag\FindSendernameBag;
use Smsapi\Client\Feature\Sms\Sendernames\Bag\FindSendernamesBag;
use Smsapi\Client\Feature\Sms\Sendernames\Bag\MakeSendernameDefaultBag;
use Smsapi\Client\Feature\Sms\Sendernames\Data\Sendername;
use Smsapi\Client\Feature\Sms\Sendernames\Data\SendernameFactory;
use Smsapi\Client\Infrastructure\Request\RestRequestBuilderFactory;
use Smsapi\Client\Infrastructure\RequestExecutor\RestRequestExecutor;
use Smsapi\Client\SmsapiClientException;

/**
 * @internal
 */
class SendernamesHttpFeature implements SendernamesFeature
{
    /**
     * @var RestRequestExecutor
     */
    private $requestExecutor;

    /**
     * @var RestRequestBuilderFactory
     */
    private $requestBuilderFactory;

    /**
     * @var SendernameFactory
     */
    private $sendernameFactory;

    public function __construct(
        RestRequestExecutor $restRequestExecutor,
        RestRequestBuilderFactory $requestBuilderFactory,
        SendernameFactory $sendernameFactory
    ) {
        $this->requestExecutor = $restRequestExecutor;
        $this->requestBuilderFactory = $requestBuilderFactory;
        $this->sendernameFactory = $sendernameFactory;
    }

    /**
     * @param FindSendernameBag $findSendernameBag
     * @return Sendername
     * @throws SmsapiClientException
     */
    public function findSendername(FindSendernameBag $findSendernameBag): Sendername
    {
        $builder = $this->requestBuilderFactory->create();

        $request = $builder
            ->withMethod(RequestMethodInterface::METHOD_GET)
            ->withPath(sprintf('sms/sendernames/%s', $findSendernameBag->sender))
            ->get();

        $result = $this->requestExecutor->execute($request);

        return $this->sendernameFactory->createFromObject($result);
    }

    /**
     * @param FindSendernamesBag|null $findSendernamesBag
     * @return array
     * @throws SmsapiClientException
     */
    public function findSendernames(FindSendernamesBag $findSendernamesBag = null): array
    {
        $builder = $this->requestBuilderFactory->create();

        $request = $builder
            ->withMethod(RequestMethodInterface::METHOD_GET)
            ->withPath('sms/sendernames')
            ->withBuiltInParameters((array) $findSendernamesBag)
            ->get();

        $result = $this->requestExecutor->execute($request);

        return array_map([$this->sendernameFactory, 'createFromObject'], $result->collection);
    }

    /**
     * @param CreateSendernameBag $createSendernameBag
     * @return Sendername
     * @throws SmsapiClientException
     */
    public function createSendername(CreateSendernameBag $createSendernameBag): Sendername
    {
        $builder = $this->requestBuilderFactory->create();

        $request = $builder
            ->withMethod(RequestMethodInterface::METHOD_POST)
            ->withPath('sms/sendernames')
            ->withBuiltInParameters((array) $createSendernameBag)
            ->get();

        $result = $this->requestExecutor->execute($request);

        return $this->sendernameFactory->createFromObject($result);
    }

    /**
     * @param DeleteSendernameBag $deleteSendernameBag
     * @return void
     * @throws SmsapiClientException
     */
    public function deleteSendername(DeleteSendernameBag $deleteSendernameBag)
    {
        $builder = $this->requestBuilderFactory->create();

        $request = $builder
            ->withMethod(RequestMethodInterface::METHOD_DELETE)
            ->withPath(sprintf('sms/sendernames/%s', $deleteSendernameBag->sender))
            ->get();

        $this->requestExecutor->execute($request);
    }

    /**
     * @param MakeSendernameDefaultBag $makeSendernameDefault
     * @return void
     * @throws SmsapiClientException
     */
    public function makeSendernameDefault(MakeSendernameDefaultBag $makeSendernameDefault)
    {
        $builder = $this->requestBuilderFactory->create();

        $request = $builder
            ->withMethod(RequestMethodInterface::METHOD_POST)
            ->withPath(sprintf('sms/sendernames/%s/commands/make_default', $makeSendernameDefault->sender))
            ->get();

        $this->requestExecutor->execute($request);
    }
}
