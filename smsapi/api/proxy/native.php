<?php

namespace SMSApi\Api\Proxy;

class Native implements \SMSApi\Api\Proxy {

	private $base;

	public function __construct($base) {
		$this->base = $base;
	}

	public function execute($uri, array $data, array $files = array()) {

		$options = $this->options($data);

		$context = stream_context_create($options);

		$url = $this->base.$uri;

		$stream = @fopen($url, 'r', false, $context);

		if( !$stream ) {
			throw new \SMSApi\Api\ProxyException(strtr('Failed to open stream ":url"', array(':url' => $url)), -2);
		}

		$meta_data = stream_get_meta_data($stream);

		$code = $this->getStatusCode($meta_data);

		if ($code AND $code < 200 OR $code > 299) {
			throw new \SMSApi\Api\ProxyException(strtr('Error fetching remote :url[:status]', array(':url' => $url, ':status' => $code)), $code);
		}

		$content = stream_get_contents($stream);

		fclose($stream);

		if( !$content ) {
			throw new \SMSApi\Api\ProxyException(strtr('Error fetching remote :url[:status] content empty', array(':url' => $url, ':status' => $code)), $code);
		}

		return $content;
	}

	private function options($data = null) {
		$options = array(
			'http' => array(
				'method' => 'GET',
				'header' => 'user-agent: SMSAPI' . "\r\n",
				'max_redirects' => 1,
				'timeout' => 5
			)
		);

		if( is_array($data) ) {

			$post_data = http_build_query($data);

			$options['http']['method'] = 'POST';
			$options['http']['content'] = $post_data;
			$options['http']['header'] .= "Content-type: application/x-www-form-urlencoded\r\n"
				. 'Content-Length: ' . strlen($post_data) . "\r\n";
		}

		return $options;
	}

	private function getStatusCode($meta_data) {
		$status_code = null;

		if (isset($meta_data['wrapper_data']) AND is_array($meta_data['wrapper_data'])) {
			foreach ($meta_data['wrapper_data'] as $_) {

				if(preg_match('/^[\s]*HTTP\/1\.[01]\s([\d]+)\sOK[\s]*$/i', $_, $_code)) {
					$status_code = next($_code);
				}
			}
		}

		return $status_code;
	}
}