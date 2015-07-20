<?php

namespace SMSApi\Proxy;

class Uri {

	private $schema;
	private $host;
	private $port;
	private $path;
	private $query;

	function __construct( $schema, $host, $port, $path, $query ) {

		$this->schema = $schema;
		$this->host = rtrim($host, '/');
		$this->port = $port;
		$this->path = '/' . ltrim($path, '/');
		$this->query = $query;
	}

	public function getSchema() {
		return $this->schema;
	}

	public function getHost() {
		return $this->host;
	}

	public function getPort() {
		return $this->port;
	}

	public function getPath() {
		return $this->path;
	}

	public function getQuery() {
		return $this->query;
	}

}

