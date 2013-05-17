<?php

namespace SMSApi\Api\Action;

abstract class Base {

	public function __construct() { }

	/**
	 * @var \SMSApi\Api\Proxy
	 */
	protected $proxy = null;

	public function proxy(\SMSApi\Api\Proxy $proxy) {
		$this->proxy = $proxy;
		return $this;
	}

	/**
	 * @var \SMSApi\Api\Client
	 */
	protected $client = null;

	public function client(\SMSApi\Api\Client $client) {
		$this->client = $client;
		return $this;
	}

	abstract protected function uri();
	abstract protected function values();
	protected function files() { }
	abstract protected function makeResult(\stdClass $obj);

	public function execute() {

		$data = $this->proxy->execute($this->uri(), $this->values());

		$response = json_decode($data);

		$this->handleError($response);

		$result = $this->makeResult($response);

		return $result;
	}

	private function handleError($data) {

		if( empty($data) ) {
			throw new \SMSApi\Api\HostException('empty response', -1);
		}

		$code = isset($data->error) ? $data->error : 0;

		if( $code != 0 ) {

			$message = isset($data->message) ? $data->message : 'unknown';

			if( $this->isHostError($code) ) {
				throw new \SMSApi\Api\HostException($message, $code);
			}
			if( $this->isClientError($code)) {
				throw new \SMSApi\Api\ClientException($message, $code);
			}
			else {
				throw new \SMSApi\Api\ActionException($message, $code);
			}
		}
	}

	/**
	 * 8 Błąd w odwołaniu
	 * 666 Wewnętrzny błąd systemu
	 * 999 Wewnętrzny błąd systemu
	 * 201 Wewnętrzny błąd systemu
	 */
	private function isHostError($code) {

		if( $code == 8 ) return true;
		if( $code == 201 ) return true;
		if( $code == 666 ) return true;
		if( $code == 999 ) return true;

		return false;
	}

	/**
	 * 101 Niepoprawne lub brak danych autoryzacji.
	 * 102 Nieprawidłowy login lub hasło
	 * 103 Brak punków dla tego użytkownika
	 * 105 Błędny adres IP
	 * 110 Usługa nie jest dostępna na danym koncie
	 * 1000 Akcja dostępna tylko dla użytkownika głównego
	 * 1001 Nieprawidłowa akcja
	 */
	private function isClientError($code) {

		if( $code == 101 ) return true;
		if( $code == 102 ) return true;
		if( $code == 103 ) return true;
		if( $code == 105 ) return true;
		if( $code == 110 ) return true;
		if( $code == 1000 ) return true;
		if( $code == 1001 ) return true;

		return false;
	}
}