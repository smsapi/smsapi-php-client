<?php

namespace SMSApi\Proxy\Http;

use SMSApi\Exception\ProxyException;
use SMSApi\Proxy\Proxy;

class Curl extends AbstractHttp implements Proxy
{
    protected function makeRequest($url, $query, $file)
    {
        $body = $this->prepareRequestBody($file);

        $headers = $this->prepareRequestHeaders($file);

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
            throw new ProxyException( 'Unable to connect' );
        }

        if ( $this->method == "POST" ) {

            $body = $this->renderQueryByBody($query, $body);

            curl_setopt( $curl, CURLOPT_URL, $url );

            curl_setopt( $curl, CURLOPT_POST, true );

            curl_setopt( $curl, CURLOPT_POSTFIELDS, $body );
        } else {
            curl_setopt( $curl, CURLOPT_URL, $url . '?' . $query);
        }

        $curlHeaders = array( );
        foreach ( $headers as $key => $value ) {
            $curlHeaders[ ] = $key . ': ' . $value;
        }

        curl_setopt( $curl, CURLOPT_HTTPHEADER, $curlHeaders );

        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );

        $response = array(
            'output' => curl_exec( $curl ),
            'code' => curl_getinfo( $curl, CURLINFO_HTTP_CODE )
        );

        curl_close( $curl );

        return $response;
	}
}
