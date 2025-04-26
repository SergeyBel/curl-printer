<?php

declare(strict_types=1);

namespace CurlPrinter\Tests\Printer;

use CurlPrinter\Formatter\CurlFormatter;
use CurlPrinter\HttpMethod;
use CurlPrinter\RequestData;
use PHPUnit\Framework\TestCase;

class CurlFormatterTest extends TestCase
{
    private $formatter;

    protected function setUp(): void
    {
        $this->formatter = new CurlFormatter();
    }

    public function testGet()
    {
        $request = $this->createRequest(HttpMethod::GET, 'http://test.com');
        $expected = 'curl http://test.com';
        $this->assertSame($expected, $this->formatter->format($request));
    }

    public function testGetWithParams()
    {
        $request = $this->createRequest(HttpMethod::GET, 'http://test.com?key=value');
        $expected = 'curl http://test.com?key=value';
        $this->assertSame($expected, $this->formatter->format($request));
    }

    public function testPost()
    {
        $request = $this->createRequest(HttpMethod::POST, 'http://test.com');
        $expected = 'curl -X POST http://test.com';
        $this->assertSame($expected, $this->formatter->format($request));
    }

    public function testPostFormBody()
    {
        $request = $this->createRequest(HttpMethod::POST, 'http://test.com', body: 'key=value');
        $expected = "curl -X POST http://test.com -d 'key=value'";
        $this->assertSame($expected, $this->formatter->format($request));
    }

    public function testPostJsonBody()
    {
        $request = $this->createRequest(
            HttpMethod::POST,
            'http://test.com',
            body: json_encode(['key' => 'value'])
        );
        $expected = "curl -X POST http://test.com -d '{\"key\":\"value\"}'";
        $this->assertSame($expected, $this->formatter->format($request));
    }

    public function testPut()
    {
        $request = $this->createRequest(HttpMethod::PUT, 'http://test.com');
        $expected = 'curl -X PUT http://test.com';
        $this->assertSame($expected, $this->formatter->format($request));
    }

    public function testDelete()
    {
        $request = $this->createRequest(HttpMethod::DELETE, 'http://test.com');
        $expected = 'curl -X DELETE http://test.com';
        $this->assertSame($expected, $this->formatter->format($request));
    }

    private function createRequest(
        HttpMethod $method,
        string $url,
        array $headers = [],
        string $body = '',
    ) {
        return new RequestData($method, $url, $headers, $body);
    }
}
