<?php
declare(strict_types=1);

namespace Smsapi\Client\Feature\Sms\Sendernames;

use Smsapi\Client\Feature\Sms\Sendernames\Bag\CreateSendernameBag;
use Smsapi\Client\Feature\Sms\Sendernames\Bag\DeleteSendernameBag;
use Smsapi\Client\Feature\Sms\Sendernames\Bag\FindSendernameBag;
use Smsapi\Client\Feature\Sms\Sendernames\Bag\MakeSendernameDefaultBag;
use Smsapi\Client\Feature\Sms\Sendernames\Data\Sendername;
use Smsapi\Client\Feature\Sms\Sendernames\Data\SendernameFactory;
use Smsapi\Client\Infrastructure\RequestExecutor\RestRequestExecutor;
use Smsapi\Client\SmsapiClientException;

/**
 * @internal
 */
class SendernamesHttpFeature implements SendernamesFeature
{
    private $restRequestExecutor;
    private $sendernameFactory;

    public function __construct(RestRequestExecutor $restRequestExecutor, SendernameFactory $sendernameFactory)
    {
        $this->restRequestExecutor = $restRequestExecutor;
        $this->sendernameFactory = $sendernameFactory;
    }

    /**
     * @param FindSendernameBag $findSendernameBag
     * @return Sendername
     * @throws SmsapiClientException
     */
    public function findSendername(FindSendernameBag $findSendernameBag): Sendername
    {
        $result = $this->restRequestExecutor->read(
            sprintf('sms/sendernames/%s', $findSendernameBag->sender),
            []
        );

        return $this->sendernameFactory->createFromObject($result);
    }

    public function findSendernames(): array
    {
        $result = $this->restRequestExecutor->read('sms/sendernames', []);

        return array_map([$this->sendernameFactory, 'createFromObject'], $result->collection);
    }

    /**
     * @param CreateSendernameBag $createSendernameBag
     * @return Sendername
     * @throws SmsapiClientException
     */
    public function createSendername(CreateSendernameBag $createSendernameBag): Sendername
    {
        $result = $this->restRequestExecutor->create('sms/sendernames', (array)$createSendernameBag);

        return $this->sendernameFactory->createFromObject($result);
    }

    /**
     * @param DeleteSendernameBag $deleteSendernameBag
     * @return void
     * @throws SmsapiClientException
     */
    public function deleteSendername(DeleteSendernameBag $deleteSendernameBag)
    {
        $this->restRequestExecutor->delete(sprintf('sms/sendernames/%s', $deleteSendernameBag->sender), []);
    }

    /**
     * @param MakeSendernameDefaultBag $makeSendernameDefault
     * @return void
     * @throws SmsapiClientException
     */
    public function makeSendernameDefault(MakeSendernameDefaultBag $makeSendernameDefault)
    {
        $this->restRequestExecutor->create(
            sprintf('sms/sendernames/%s/commands/make_default', $makeSendernameDefault->sender),
            []
        );
    }
}
