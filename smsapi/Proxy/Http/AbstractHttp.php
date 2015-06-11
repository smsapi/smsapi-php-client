<?php

namespace SMSApi\Proxy\Http;

use SMSApi\Api\Action\AbstractAction;
use SMSApi\Api\Action\Contacts\ContactsAction;
use SMSApi\Exception\ProxyException;
use SMSApi\Proxy\Proxy;
use SMSApi\Proxy\Uri;

abstract class AbstractHttp implements Proxy
{
	protected $protocol;
	protected $host;
	protected $port;
    protected $boundary = '**RGRG87VFSGF86796GSD**';
    protected $method = 'POST';
	protected $timeout = 5;
	protected $maxRedirects = 1;

    /**
     * @deprecated - no usages
     */
    protected $uri;

    /**
     * @deprecated - no usages
     */
    protected $file;

    /**
     * @deprecated - no usages
     */
    protected $userAgent = "SMSAPI";

    /**
     * @deprecated - no usages
     */
    protected $headers = [];

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

    public function getHost()
    {
        return $this->host;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function getProtocol()
    {
        return $this->protocol;
    }

    public function execute(AbstractAction $action)
    {
        try {
            $uri = $action->uri();
            $file = $action->file();

            if ($uri == null) {
                throw new ProxyException("Invalid URI");
            }

            $url = $this->prepareRequestUrl($uri);

            $query = $uri->getQuery();

            if ($action instanceof ContactsAction) {
                $method = $action->getMethod();
            } else {
                $method = $this->method;
            }

            $response = $this->makeRequest($method, $url, $query, $file);

            if (!($action instanceof ContactsAction)) {
                $this->checkCode($response['code']);
            }

            if (empty($response['output'])) {
                throw new ProxyException('Error fetching remote content empty');
            }
        } catch (\Exception $e) {
            throw new ProxyException($e->getMessage());
        }

        if ($action instanceof ContactsAction) {
            return $response;
        } else {
            return $response['output'];
        }
    }

    abstract protected function makeRequest($method, $url, $query, $file);

    protected function checkCode($code)
    {
        if ($code AND $code < 200 OR $code > 299) {
            throw new ProxyException('Error fetching remote');
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

	protected function encodeFormData( $boundary, $name, $value, $filename = null, $headers = [ ] ) {
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
		$fhead = [ 'Content-Type' => $file[ 'ctype' ] ];

		$body = $this->encodeFormData( $this->boundary, $file[ 'formname' ], $file[ 'data' ], $file[ 'filename' ], $fhead );

		$body .= "--{$this->boundary}--\r\n";

		return $body;
	}

	protected function renderQueryByBody( $query, $body ) {

		$tmpBody = "";

		if ( !empty( $query ) && !empty( $body ) ) {
			$params = [ ];
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

    /**
     * @param Uri $uri
     * @return string
     */
    protected function prepareRequestUrl(Uri $uri)
    {
        $url = $uri->getSchema() . "://" . $uri->getHost() . $uri->getPath();
        return $url;
    }

    /**
     * @param $file
     * @return string
     */
    protected function prepareRequestBody($file)
    {
        $body = "";

        if ($this->isFileValid($file)) {
            $body = $this->prepareFileContent($file);
        }

        return $body;
    }

    private function isFileValid($file)
    {
        return !empty($file) && file_exists($file);
    }

    /**
     * @param $file
     * @return array
     */
    protected function prepareRequestHeaders($file)
    {
        $headers = [];

        $headers['User-Agent'] = 'smsapi-php-client';
        $headers['Accept'] = '';

        if ($this->isFileValid($file)) {
            $headers['Content-Type'] = 'multipart/form-data; boundary=' . $this->boundary;
        } else {
            $headers['Content-Type'] = 'application/x-www-form-urlencoded';
        }

        return $headers;
    }
}
