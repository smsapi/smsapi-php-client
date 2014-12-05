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
			$file = $action->file();

			if ( $this->uri == null ) {
				throw new \SMSApi\Exception\ProxyException( "Invalid URI" );
			}

            $this->doFopen($file);

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
            if (isset($meta_data['wrapper_data']['headers']) and is_array($meta_data['wrapper_data']['headers'])) {
                $headers = $meta_data['wrapper_data']['headers'];
            } else {
                $headers = $meta_data['wrapper_data'];
            }

            foreach ($headers as $_) {
                if ( preg_match( '/^[\s]*HTTP\/1\.[01]\s([\d]+)\sOK[\s]*$/i', $_, $_code ) ) {
                    $status_code = next( $_code );
                }
            }
        }

        return $status_code;
    }

	private function doFopen( $file )
    {
        $body = $this->prepareRequestBody($file);

        $headers = $this->prepareRequestHeaders($file);

        $url = $this->uri->getSchema() . "://" . $this->uri->getHost() . $this->uri->getPath();

        $headersString = "";
        foreach ( $headers as $k => $v ) {
            if ( is_string( $k ) )
                $v = ucfirst( $k ) . ": $v";
            $headersString .= "$v\r\n";
        }

        $opts = array(
            'http' => array(
                'method'	 => $this->method,
                'header'	 => $headersString,
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

    /**
     * @param $file
     * @return string
     */
    private function prepareRequestBody($file)
    {
        $body = "";

        if ($this->isFileValid($file)) {
            $body = $this->prepareFileContent($file);
        }

        return $body;
    }

    /**
     * @param $file
     * @return array
     */
    private function prepareRequestHeaders($file)
    {
        $headers = array();

        $headers['User-Agent'] = 'SMSApi';
        $headers['Accept'] = '';

        if ($this->isFileValid($file)) {
            $headers['Content-Type'] = 'multipart/form-data; boundary=' . $this->boundary;
        } else {
            $headers['Content-Type'] = 'application/x-www-form-urlencoded';
        }

        return $headers;
    }

    private function isFileValid($file)
    {
        return !empty($file) && file_exists($file);
    }
}
