<?php

require_once '../../smsapi/Autoload.php';

class SmsapiTest extends PHPUnit_Framework_TestCase {

	protected $fileToIds = "_ids_test.txt";
	protected $numberTest = "694562829";
	
	protected $api_login = "twoj_login";
	protected $api_password = "twoje_haslo_do_api";

	protected function setUp() {
		
	}

	protected function client() {
		try {

			$client = new \SMSApi\Client( $this->api_login );
			$client->setPasswordRAW( $this->api_password );
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

	protected function renderMessageItem( \SMSApi\Api\Response\MessageResponse $item ) {

		print("ID: " . $item->getId()
			. " Number: " . $item->getNumber()
			. " Points:" . $item->getPoints()
			. " Status:" . $item->getStatus()
			. " IDx: " . $item->getIdx()
			. "\n"
		);
	}

	protected function readIds() {
		$str = file_get_contents( $this->fileToIds );
		return unserialize( $str );
	}

	protected function writeIds( $ids ) {
		file_put_contents( $this->fileToIds, serialize( $ids ) );
	}

}
