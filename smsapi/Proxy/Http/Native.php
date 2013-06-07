<?php

namespace SMSApi\Proxy\Http;

use SMSApi\Proxy\Proxy;

class Native extends AbstractHttp implements Proxy {

	const CONNECT_FOPEN = 1;
	const CONNECT_SOCKET = 2;

	private $connGateway = self::CONNECT_FOPEN;
	private $response = array( 'meta'	 => null, 'output' => null );

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

			$code = $this->getStatusCode( $this->response[ 'meta' ] );

			$this->checkCode( $code );

			if ( empty( $this->response[ 'output' ] ) ) {
				throw new \SMSApi\Exception\ProxyException( 'Error fetching remote content empty' );
			}
		} catch ( \Exception $ex ) {
			throw new \SMSApi\Exception\ProxyException( $ex->getMessage() );
		}

		return $this->response[ 'output' ];
	}

	private function getStatusCode( $meta_data ) {
		$status_code = null;

		if ( isset( $meta_data[ 'wrapper_data' ] ) AND is_array( $meta_data[ 'wrapper_data' ] ) ) {
			foreach ( $meta_data[ 'wrapper_data' ] as $_ ) {

				if ( preg_match( '/^[\s]*HTTP\/1\.[01]\s([\d]+)\sOK[\s]*$/i', $_, $_code ) ) {
					$status_code = next( $_code );
				}
			}
		}

		return $status_code;
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

		switch ( $this->connGateway ) {
			case self::CONNECT_FOPEN:
				$this->doFopen( $body );
				break;

			case self::CONNECT_SOCKET:
				if ( $this->getPort() == 433 || $this->getProtocol() == "https" ) {
					throw new \SMSApi\Exception\ProxyException( 'Connect socket not supported to https' );
				}
				$this->doSocket( $body );
				break;
		}
	}

	private function doFopen( $body ) {
		if ( isset( $this->uri ) ) {
			$url = $this->uri->getSchema() . "://" . $this->uri->getHost() . $this->uri->getPath();

			$heders = "";
			foreach ( $this->headers as $k => $v ) {
				if ( is_string( $k ) )
					$v = ucfirst( $k ) . ": $v";
				$heders .= "$v\r\n";
			}

			$opts = array(
				'http' => array(
					'method'	 => $this->method,
					'header'	 => $heders,
					'content'	 => empty( $body ) ? $this->uri->getQuery() : $body,
				)
			);

			$context = stream_context_create( $opts );

			if ( !empty( $body ) ) {
				$url .= '?' . $this->uri->getQuery();
			}

			$fp = fopen( $url, 'r', false, $context );

			$this->response[ 'meta' ] = stream_get_meta_data( $fp );
			$this->response[ 'output' ] = stream_get_contents( $fp );

			if ( $fp ) {
				fclose( $fp );
			}
		}
	}

	private function doSocket( $body ) {
		if ( isset( $this->uri ) ) {

			$flags = STREAM_CLIENT_CONNECT;
			$contextTest = stream_context_create();

			$socket = stream_socket_client(
				$this->uri->getHost() . ':' . $this->getPort(), $errno, $errstr, (int) $this->timeout, $flags, $contextTest
			);

			if ( !is_resource( $socket ) ) {
				throw new \SMSApi\Exception\ProxyException( 'Unable to connect' );
			}

			//------------------------------------------------------

			$request = "{$this->method} {$this->uri->getPath()} HTTP/1.1\r\n";

			$body = $this->renderQueryByBody( $this->uri->getQuery(), $body );

			foreach ( $this->headers as $k1 => $v1 ) {
				if ( is_string( $k1 ) )
					$v1 = ucfirst( $k1 ) . ": $v1";
				$request .= "$v1\r\n";
			}

			if ( !in_array( 'Content-Length', $this->headers ) ) {
				$request .= "Content-Length: " . strlen( $body ) . "\r\n";
			}

			if ( !empty( $body ) ) {
				$request .= "\r\n" . $body;
			}

			//-------------------------------------------------------

			if ( fwrite( $socket, $request ) ) {

				$gotStatus = false;
				$meta = "";

				while ( ($line = fgets( $socket )) !== false ) {
					$gotStatus = $gotStatus || (strpos( $line, 'HTTP' ) !== false);
					if ( $gotStatus ) {
						$meta .= $line;
						if ( rtrim( $line ) === '' )
							break;
					}
				}

				$this->response[ 'meta' ] = $meta;

				$info = stream_get_meta_data( $socket );
				if ( $info[ 'timed_out' ] ) {
					fclose( $socket );
					throw new \SMSApi\Exception\ProxyException( "Read timed out after {$this->timeout} seconds" );
				}

				$this->response[ 'output' ] = stream_get_contents( $socket );
			}

			fclose( $socket );
		}
	}

}