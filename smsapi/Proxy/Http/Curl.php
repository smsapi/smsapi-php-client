<?php

namespace SMSApi\Proxy\Http;

use SMSApi\Proxy\Proxy;

class Curl extends AbstractHttp implements Proxy {

	private $response = array( 'code'	 => null, 'output' => null );

	public function execute( \SMSApi\Api\Action\AbstractAction $action ) {

		try {

			$this->uri = $action->uri();
			$this->file = $action->file();

			if ( $this->uri == null ) {
				throw new \SMSApi\Exception\ProxyException( "Invalid URI" );
			}

			if ( !empty( $this->file ) && file_exists( $this->file ) ) {

				$this->toConnect( $this->file );
			} else {

				$this->toConnect();
			}

			$this->checkCode( $this->response[ 'code' ] );


			if ( empty( $this->response[ 'output' ] ) ) {
				throw new \SMSApi\Exception\ProxyException( 'Error fetching remote content empty' );
			}
		} catch ( \Exception $ex ) {
			throw new \SMSApi\Exception\ProxyException( $ex->getMessage() );
		}

		return $this->response[ 'output' ];
	}

	private function toConnect( $filename = null ) {

		$body = "";

		$this->headers[ 'User-Agent' ] = 'SMSApi';
		$this->headers[ 'Accept' ] = '';

		if ( $filename ) {

			$this->headers[ 'Content-Type' ] = 'multipart/form-data; boundary=' . $this->boundary;

			$body = $this->prepareFileContent( $filename );
		} else {
			$this->headers[ 'Content-Type' ] = 'application/x-www-form-urlencoded';
		}

		$this->doCurl( $body );
	}

	private function doCurl( $body ) {

		if ( isset( $this->uri ) ) {

			$url = $this->uri->getSchema() . "://" . $this->uri->getHost() . $this->uri->getPath();

			$curl = curl_init();

			curl_setopt( $curl, CURL_HTTP_VERSION_1_1, true );

			curl_setopt( $curl, CURLOPT_HEADER, false );

			curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, false );

			if ( $this->getPort() != 80 ) {
				curl_setopt( $curl, CURLOPT_PORT, intval( $this->getPort() ) );
			}

			if ( isset( $this->timeout ) ) {
				curl_setopt( $curl, CURLOPT_CONNECTTIMEOUT, $this->timeout );
			}

			if ( isset( $this->maxRedirects ) ) {
				curl_setopt( $curl, CURLOPT_MAXREDIRS, $this->maxRedirects );
			}

			if ( !$curl ) {
				throw new \SMSApi\Exception\ProxyException( 'Unable to connect' );
			}


			if ( $this->method == "POST" ) {

				$body = $this->renderQueryByBody( $this->uri->getQuery(), $body );

				curl_setopt( $curl, CURLOPT_URL, $url );

				curl_setopt( $curl, CURLOPT_POST, true );

				curl_setopt( $curl, CURLOPT_POSTFIELDS, $body );
			} else {
				curl_setopt( $curl, CURLOPT_URL, $url . '?' . $this->uri->getQuery() );
			}

			$curlHeaders = array( );
			foreach ( $this->headers as $key => $value ) {
				$curlHeaders[ ] = $key . ': ' . $value;
			}

			curl_setopt( $curl, CURLOPT_HTTPHEADER, $curlHeaders );

			curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );

			$this->response[ 'output' ] = curl_exec( $curl );
			$this->response[ 'code' ] = curl_getinfo( $curl, CURLINFO_HTTP_CODE );

			curl_close( $curl );
		}
	}

}