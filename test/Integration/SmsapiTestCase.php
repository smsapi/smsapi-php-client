<?php

abstract class SmsapiTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * @var null|\SMSApi\Proxy\Proxy
     */
    protected $proxy;

    public function setProxy(\SMSApi\Proxy\Proxy $proxy)
    {
        $this->proxy = $proxy;
    }

	protected function client()
    {
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
		return null;
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

    private function getConfiguration()
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
