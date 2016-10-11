<?php
use SMSApi\Client;
use SMSApi\Proxy\Http\Curl;
use SMSApi\Proxy\Proxy;

abstract class SmsapiTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @var null|\SMSApi\Proxy\Proxy
     */
    protected $proxy;

    /**
     * @var Proxy|null
     */
    protected $contactsProxy;

    /** @var Client|null */
    protected $client;

    public function setProxy(Proxy $proxy)
    {
        $this->proxy = $proxy;
    }

    public function setContactsProxy(Proxy $proxy)
    {
        $this->contactsProxy = $proxy;
    }

    public function setClient(Client $client)
    {
        $this->client = $client;
    }

	protected function client()
    {
        if ($this->client) {
            return $this->client;
        }

		try {
			$client = new \SMSApi\Client($this->getApiLogin());
			$client->setPasswordHash($this->getApiPassword());

			return $client;
		} catch ( \SMSApi\Exception\ClientException $ex ) {
			/**
			 * 101 Niepoprawne lub brak danych autoryzacji. 102 Nieprawidłowy login lub hasło 103 Brak punków dla tego
			 * użytkownika 105 Błędny adres IP 110 Usługa nie jest dostępna na danym koncie 1000 Akcja dostępna tylko
			 * dla użytkownika głównego 1001 Nieprawidłowa akcja
			 */
			echo $ex->getMessage();
			die();
		}
	}

    private function getApiLogin()
    {
        $configuration = $this->getConfiguration();

        return $configuration['api_login'];
    }

    private function getApiPassword()
    {
        $configuration = $this->getConfiguration();

        return $configuration['api_password'];
    }

    /**
     * @return null|\SMSApi\Proxy\Http\Curl
     */
    protected function proxy()
    {
        if (!$this->proxy && $this->getHost())
        {
            $this->proxy = new \SMSApi\Proxy\Http\Curl($this->getHost());
        }

        return $this->proxy;
    }

    protected function contactsProxy()
    {
        if (!$this->contactsProxy && $this->getContactsHost()) {
            $this->contactsProxy = new Curl($this->getContactsHost());
        }

        return $this->contactsProxy;
    }

    private function getHost()
    {
        $configuration = $this->getConfiguration();

        return $configuration['host'];
    }

    private function getContactsHost()
    {
        $configuration = $this->getConfiguration();

        return $configuration['contacts_host'];
    }

    protected function getConfiguration()
    {
        return include __DIR__ . '/config.php';
    }

    protected function getNumberTest()
    {
        $configuration = $this->getConfiguration();

        return $configuration['number_test'];
    }

    protected function getSmsTemplateName()
    {
        $configuration = $this->getConfiguration();

        return $configuration['sms_template_name'];
    }

	protected function renderMessageItem( \SMSApi\Api\Response\MessageResponse $item ) {

		print("ID: " . $item->getId()
			. " Number: " . $item->getNumber()
			. " Points:" . $item->getPoints()
			. " Status:" . $item->getStatus()
			. " IDx: " . $item->getIdx()
			. "\n"
		);
	}

    protected function collectIds(\SMSApi\Api\Response\StatusResponse $response)
    {
        $ids = array();

        foreach ($response->getList() as $item) {
            if (!$item->getError()) {
                $ids[] = $item->getId();
            }
        }

        return $ids;
    }

    protected function countErrors(\SMSApi\Api\Response\StatusResponse $response)
    {
        $errors = 0;

        foreach ($response->getList() as $item) {
            if ($item->getError()) {
                $errors++;
            }
        }

        return $errors;
    }

    protected function renderStatusResponse(\SMSApi\Api\Response\StatusResponse $response)
    {
        foreach ($response->getList() as $item) {
            if (!$item->getError()) {
                $this->renderMessageItem($item);
            }
        }
    }
}
