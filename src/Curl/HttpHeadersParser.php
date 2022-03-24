<?php

declare(strict_types=1);

namespace Smsapi\Client\Curl;

class HttpHeadersParser
{
    public static function parse(string $rawHeaders): array
    {
        $headers = array_filter(array_map('trim', explode("\n", $rawHeaders)));
        $headersAssociative = [];
        foreach ($headers as $header) {
            if (!strpos($header, ':')) {
                continue;
            }
            list($headerName, $headerValue) = explode(':', $header, 2);
            $headersAssociative[$headerName] = trim($headerValue);
        }

        return $headersAssociative;
    }
}