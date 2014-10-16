<?php

require_once __DIR__  . '/../../smsapi/Autoload.php';

abstract class SmsapiTest extends PHPUnit_Framework_TestCase
{

    private $fileToIds = "_ids_test.txt";

	protected $numberTest = "xxxyyyzzz";

	private  $api_login = "twoj_login";
	private  $api_password = "twoje_haslo_do_api";

	protected function client()
    {
		try {
			$client = new \SMSApi\Client($this->getApiLogin());
			$client->setPasswordRAW($this->getApiPassword());

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
        return $this->api_login;
    }

    private function getApiPassword()
    {
        return $this->api_password;
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

	protected function readIds()
    {
		$str = file_get_contents($this->getFileToIdsPath());
		return unserialize( $str );
	}

	protected function writeIds( $ids )
    {
		file_put_contents($this->getFileToIdsPath(), serialize( $ids ));
	}

    private function getFileToIdsPath()
    {
        return __DIR__ . '/' . $this->fileToIds;
    }
}
