<?php

namespace SMSApi\Proxy\Http;

use SMSApi\Proxy\Proxy;

class Native extends AbstractHttp implements Proxy
{
    /**
     * @deprecated
     */
	const CONNECT_FOPEN = 1;

    /**
     * @deprecated
     */
	const CONNECT_SOCKET = 2;

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

        $this->doFopen( $body );
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
}
