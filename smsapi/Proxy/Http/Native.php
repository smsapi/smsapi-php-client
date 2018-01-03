<?php

namespace SMSApi\Proxy\Http;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Exception\ProxyException;

class Native extends AbstractHttp
{
    /**
     * @deprecated
     */
	const CONNECT_FOPEN = 1;

    /**
     * @deprecated
     */
	const CONNECT_SOCKET = 2;

    protected function getProxyName()
    {
        return 'native';
    }

    protected function makeRequest($method, $url, $query, $file, $isContacts)
    {
        $body = $this->prepareRequestBody($file);
        $postOrPut = in_array($method, array(AbstractAction::METHOD_POST, AbstractAction::METHOD_PUT));
        $contentType='';
        if ($this->isFileValid($file)) {
            $contentType = 'multipart/form-data; boundary=' . $this->boundary;
        } elseif ($postOrPut) {
            $contentType = 'application/x-www-form-urlencoded';
        }
        $headers = $this->prepareRequestHeaders($contentType);

        $headersString = $this->preparePlainTextHeaders($headers);

        $options = array(
            'http' => array(
                'method'	 => $method,
                'header'	 => $headersString,
                'ignore_errors' => $isContacts,
            )
        );

        if ($postOrPut) {
            if ($body) {
                $options['http']['content'] = $body;
                $url .= '?' . trim($query, '&');
            } else {
                $options['http']['content'] = $query;
            }
        } elseif ($query) {
            $url .= '?' . trim($query, '&');
        }

        $context = stream_context_create($options);

        $fp = fopen($url, 'r', false, $context);

        if (!$fp) {
            throw new ProxyException('Unable to connect');
        }

        $metaData = stream_get_meta_data($fp);

        $response['code'] = $this->getStatusCode($metaData);
        $response['output'] = stream_get_contents($fp);
        $response['size'] = $this->getResultCount($metaData);

        fclose($fp);

        return $response;
	}

    private function getHeaders(array $metaData)
    {
        if (isset($metaData['wrapper_data']) and is_array($metaData['wrapper_data'])) {
            if (isset($metaData['wrapper_data']['headers']) and is_array($metaData['wrapper_data']['headers'])) {
                return $metaData['wrapper_data']['headers'];
            } else {
                return $metaData['wrapper_data'];
            }
        }

        return array();
    }

    private function getStatusCode(array $metaData)
    {
        foreach ($this->getHeaders($metaData) as $wrapperRow) {
            if (preg_match('#HTTP/1\.[01]\s+([\d]+)#i', $wrapperRow, $code)) {
                return next($code);
            }
        }

        return null;
    }

    private function getResultCount(array $metaData)
    {
        foreach ($this->getHeaders($metaData) as $wrapperRow) {
            if (preg_match('#X-Result-Count:\s+(\d+)#i', $wrapperRow, $code)) {
                return (int)next($code);
            }
        }

        return null;
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
