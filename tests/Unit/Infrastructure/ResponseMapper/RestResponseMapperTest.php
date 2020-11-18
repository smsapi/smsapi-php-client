<?php

declare(strict_types=1);

namespace Smsapi\Client\Tests\Unit\Infrastructure\ResponseMapper;

use GuzzleHttp\Psr7\Response;
use Smsapi\Client\Infrastructure\ResponseHttpCode;
use Smsapi\Client\Infrastructure\ResponseMapper\ApiErrorException;
use Smsapi\Client\Infrastructure\ResponseMapper\JsonDecode;
use Smsapi\Client\Infrastructure\ResponseMapper\RestResponseMapper;
use Smsapi\Client\Tests\SmsapiClientUnitTestCase;
use stdClass;

class RestResponseMapperTest extends SmsapiClientUnitTestCase
{
    /** @var RestResponseMapper */
    private $restResponseMapper;

    /**
     * @before
     */
    public function given_rest_response_mapper()
    {
        $this->restResponseMapper = new RestResponseMapper(new JsonDecode());
    }

    /**
     * @test
     */
    public function it_should_return_decoded_body_on_ok()
    {
        $key = 'any key';
        $value = 'any value';
        $responseWithOkAndBody = $this->createResponse(ResponseHttpCode::OK, $this->createJson($key, $value));

        $result = $this->restResponseMapper->map($responseWithOkAndBody);

        $this->assertResult($key, $value, $result);
    }

    /**
     * @test
     */
    public function it_should_return_body_on_created()
    {
        $key = 'any key';
        $value = 'any value';
        $responseWithCreatedAndBody = $this->createResponse(
            ResponseHttpCode::CREATED,
            $this->createJson($key, $value)
        );

        $result = $this->restResponseMapper->map($responseWithCreatedAndBody);

        $this->assertResult($key, $value, $result);
    }

    /**
     * @test
     */
    public function it_should_return_empty_object_on_accepted()
    {
        $responseWithAccepted = new Response(ResponseHttpCode::ACCEPTED);

        $result = $this->restResponseMapper->map($responseWithAccepted);

        $this->assertEquals(new stdClass(), $result);
    }

    /**
     * @test
     */
    public function it_should_return_empty_object_on_no_content()
    {
        $responseWithBody = new Response(ResponseHttpCode::NO_CONTENT);

        $result = $this->restResponseMapper->map($responseWithBody);

        $this->assertEquals(new stdClass(), $result);
    }

    /**
     * @test
     */
    public function it_should_throw_exception_on_service_unavailable()
    {
        $responseWithServiceUnavailable = new Response(ResponseHttpCode::SERVICE_UNAVAILABLE);

        $this->expectException(ApiErrorException::class);
        $this->expectExceptionMessage("Service unavailable");
        $this->restResponseMapper->map($responseWithServiceUnavailable);
    }

    /**
     * @test
     */
    public function it_should_throw_exception_on_unrecognized_status()
    {
        $responseWithUnrecognizedStatus = new Response(400);

        $this->expectException(ApiErrorException::class);
        $this->restResponseMapper->map($responseWithUnrecognizedStatus);
    }

    private function createJson(string $key, string $value)
    {
        return "{\"{$key}\":\"{$value}\"}";
    }

    private function createResponse(int $code, string $body)
    {
        return new Response($code, [], $body);
    }

    private function assertResult(string $key, string $value, stdClass $result)
    {
        $expected = new stdClass();
        $expected->$key = $value;
        $this->assertEquals($expected, $result);
    }
}
