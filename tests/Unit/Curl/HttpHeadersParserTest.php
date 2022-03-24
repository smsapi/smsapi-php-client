<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Unit\Curl;

use PHPUnit\Framework\TestCase;
use Smsapi\Client\Curl\HttpHeadersParser;

class HttpHeadersParserTest extends TestCase
{
    /**
     * @test
     */
    public function bypass_http_status_line()
    {
        $rawHeaders = "HTTP/1.1 202 OK\r\nHeader1: any\r\nHeader2: any, other\r\n";

        $headers = HttpHeadersParser::parse($rawHeaders);

        $this->assertArrayNotHasKey('HTTP/1.1 202 OK', $headers);
        $this->assertNotContains('HTTP/1.1 202 OK', $headers);
    }

    /**
     * @test
     */
    public function not_bypass_non_http_status_line_first_line()
    {
        $rawHeaders = "Header1: any\r\nHeader2: any, other\r\n";

        $headers = HttpHeadersParser::parse($rawHeaders);

        $this->assertArrayHasKey('Header1', $headers);
    }

    /**
     * @test
     */
    public function bypass_empty_line()
    {
        $rawHeaders = "HTTP/1.1 202 OK\r\nHeader1: any\r\nHeader2: any, other\r\n\r\n";

        $headers = HttpHeadersParser::parse($rawHeaders);

        $this->assertCount(2, array_keys($headers));
    }

    /**
     * @test
     */
    public function add_all_headers()
    {
        $rawHeaders = "HTTP/1.1 202 OK\r\nHeader1: any\r\nHeader2: any, other\r\n";

        $headers = HttpHeadersParser::parse($rawHeaders);

        $this->assertArrayHasKey('Header1', $headers);
        $this->assertArrayHasKey('Header2', $headers);
    }

    /**
     * @test
     */
    public function add_single_value_headers()
    {
        $rawHeaders = "HTTP/1.1 202 OK\r\nHeader1: any\r\nHeader2: any, other\r\n";

        $headers = HttpHeadersParser::parse($rawHeaders);

        $this->assertEquals('any', $headers['Header1']);
    }

    /**
     * @test
     */
    public function add_multi_value_headers()
    {
        $rawHeaders = "HTTP/1.1 202 OK\r\nHeader1: any\r\nHeader2: any, other\r\n";

        $headers = HttpHeadersParser::parse($rawHeaders);

        $this->assertEquals('any, other', $headers['Header2']);
    }
}