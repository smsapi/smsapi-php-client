<?php

namespace SMSApi\Proxy\Http;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Exception\ProxyException;

class Curl extends AbstractHttp
{
    protected function makeRequest($method, $url, $query, $file, $isContacts)
    {
        $body = $this->prepareRequestBody($file);

        $headers = $this->prepareRequestHeaders($file);

        $curl = curl_init();

        curl_setopt( $curl, CURL_HTTP_VERSION_1_1, true );

        curl_setopt($curl, CURLOPT_HEADER, true);

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

        $data = $this->renderQueryByBody($query, $body);

        $curlHeaders = array( );
        foreach ( $headers as $key => $value ) {
            $curlHeaders[ ] = $key . ': ' . $value;
        }

        curl_setopt( $curl, CURLOPT_HTTPHEADER, $curlHeaders );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );

        switch ($method) {
            case AbstractAction::METHOD_GET:
                curl_setopt($curl, CURLOPT_URL, $url . ($query ? '?' . $query : ''));
                break;
            case AbstractAction::METHOD_POST:
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case AbstractAction::METHOD_HEAD:
                curl_setopt($curl, CURLOPT_URL, $url . ($query ? '?' . $query : ''));
                curl_setopt($curl, CURLOPT_NOBODY, true);
                //curl_setopt($curl, CURLOPT_CUSTOMREQUEST, AbstractAction::METHOD_HEAD);
                //curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case AbstractAction::METHOD_DELETE:
                curl_setopt($curl, CURLOPT_URL, $url . ($query ? '?' . $query : ''));
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
                break;
            case AbstractAction::METHOD_PUT:
                curl_setopt($curl, CURLOPT_URL, $url);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }

        list($headers, $body) = explode(
            "\r\n\r\n",
            preg_replace('#HTTP/1\.1 100 Continue\s+#', '', curl_exec($curl)),
            2
        );

        $response = array(
            'output' => $body,
            'code' => curl_getinfo($curl, CURLINFO_HTTP_CODE),
            'size' => $this->getResultCount($headers),
        );

        curl_close( $curl );

        return $response;
	}

    protected function getResultCount($headers)
    {
        foreach (explode("\n", $headers) as $header) {
            if (preg_match('#X-Result-Count:\s+(\d+)#i', $header, $code)) {
                return (int)next($code);
            }
        }

        return null;
    }
}
