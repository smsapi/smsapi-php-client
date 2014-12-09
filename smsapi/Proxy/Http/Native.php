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

	protected function makeRequest($url, $query, $file)
    {
        $body = $this->prepareRequestBody($file);

        $headers = $this->prepareRequestHeaders($file);

        if (!empty($body)) {
            $url .= '?' . $query;
        }

        $headersString = $this->preparePlainTextHeaders($headers);

        $options = array(
            'http' => array(
                'method'	 => $this->method,
                'header'	 => $headersString,
                'content'	 => empty($body) ? $query : $body,
            )
        );

        $context = stream_context_create($options);

        $fp = fopen($url, 'r', false, $context);

        $response['code'] = $this->getStatusCode(stream_get_meta_data($fp));
        $response['output'] = stream_get_contents($fp);

        if ($fp) {
            fclose($fp);
        }

        return $response;
	}

    private function getStatusCode($metaData)
    {
        $statusCode = null;

        if ( isset( $metaData[ 'wrapper_data' ] ) AND is_array( $metaData[ 'wrapper_data' ] ) ) {
            if (isset($metaData['wrapper_data']['headers']) and is_array($metaData['wrapper_data']['headers'])) {
                $headers = $metaData['wrapper_data']['headers'];
            } else {
                $headers = $metaData['wrapper_data'];
            }

            foreach ($headers as $wrapperRow) {
                if (preg_match( '/^[\s]*HTTP\/1\.[01]\s([\d]+)\sOK[\s]*$/i', $wrapperRow, $code)) {
                    $statusCode = next($code);
                }
            }
        }

        return $statusCode;
    }

    /**
     * @param $headers
     * @return string
     */
    private function preparePlainTextHeaders($headers)
    {
        $headersString = "";

        foreach ($headers as $k => $v) {
            if (is_string($k)) {
                $v = ucfirst($k) . ": " . $v;
            }

            $headersString .= $v . "\r\n";
        }

        return $headersString;
    }
}
