<?php

namespace SMSApi\Proxy\Http;

class AbstractHttp {

	protected $protocol;
	protected $host;
	protected $port;
	protected $uri;
	protected $file;
	protected $boundary = '**RGRG87VFSGF86796GSD**';
	protected $method = "POST";
	protected $timeout = 5;
	protected $maxRedirects = 1;
	protected $userAgent = "SMSAPI";
	protected $headers = array( );

	public function __construct( $host ) {

		$tmp = explode( "://", $host );

		if ( isset( $tmp[ 0 ] ) ) {
			$this->protocol = $tmp[ 0 ];
			if ( $this->protocol == "http" ) {
				$this->port = 80;
			} else if ( $this->protocol == "https" ) {
				$this->port = 443;
			}
		}

		if ( isset( $tmp[ 1 ] ) ) {
			$this->host = $tmp[ 1 ];
		}
	}

	public function getHost() {
		return $this->host;
	}

	public function getPort() {
		return $this->port;
	}

	public function getProtocol() {
		return $this->protocol;
	}

	protected function checkCode( $code ) {
		if ( $code AND $code < 200 OR $code > 299 ) {
			throw new \SMSApi\Exception\ProxyException( 'Error fetching remote' );
		}
	}

	protected function detectFileMimeType( $file ) {
		$type = null;

		if ( function_exists( 'finfo_open' ) ) {
			$fo = finfo_open( FILEINFO_MIME );
			if ( $fo ) {
				$type = finfo_file( $fo, $file );
			}
		} elseif ( function_exists( 'mime_content_type' ) ) {
			$type = mime_content_type( $file );
		}

		if ( !$type ) {
			$type = 'application/octet-stream';
		}

		return $type;
	}

	protected function encodeFormData( $boundary, $name, $value, $filename = null, $headers = array( ) ) {
		$ret = "--{$boundary}\r\n" .
			'Content-Disposition: form-data; name="' . $name . '"';

		if ( $filename ) {
			$ret .= '; filename="' . $filename . '"';
		}
		$ret .= "\r\n";

		foreach ( $headers as $hname => $hvalue ) {
			$ret .= "{$hname}: {$hvalue}\r\n";
		}
		$ret .= "\r\n";
		$ret .= "{$value}\r\n";

		return $ret;
	}

	protected function prepareFileContent( $filename ) {

		$file[ 'formname' ] = 'file';
		$file[ 'data' ] = file_get_contents( $filename );
		$file[ 'filename' ] = basename( $filename );
		$file[ 'ctype' ] = $this->detectFileMimeType( $filename );
		$fhead = array( 'Content-Type' => $file[ 'ctype' ] );

		$body = $this->encodeFormData( $this->boundary, $file[ 'formname' ], $file[ 'data' ], $file[ 'filename' ], $fhead );

		$body .= "--{$this->boundary}--\r\n";

		return $body;
	}

	protected function renderQueryByBody( $query, $body ) {

		$tmpBody = "";

		if ( !empty( $query ) && !empty( $body ) ) {
			$params = array( );
			parse_str( $query, $params );
			foreach ( $params as $k2 => $v2 ) {
				$tmpBody .= $this->encodeFormData( $this->boundary, $k2, $v2 );
			}
		} else {
			$tmpBody = $query;
		}

		if ( !empty( $body ) ) {
			$tmpBody .= $body;
		}

		return $tmpBody;
	}

}

