<?php

namespace CurlPrinter\Tests;

use CurlPrinter\CurlPrinter;
use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;

class CurlPrinterTest extends TestCase
{
    private $printer;

    protected function setUp(): void
    {
        $this->printer = new CurlPrinter();
    }

    public function testSimpleGet()
    {
        $request = $this->createRequest('GET');
        $answer = 'curl http://test.tst';
        $this->assertSame($answer, $this->printer->printRequest($request));
    }

    public function testGetWithParams()
    {
        $request = $this->createRequest('GET', [], '', 'http://test.tst?param1=value1');
        $answer = 'curl http://test.tst?param1=value1';
        $this->assertSame($answer, $this->printer->printRequest($request));
    }

    public function testSimplePost()
    {
        $request = $this->createRequest('Post');
        $answer = 'curl -X POST http://test.tst';
        $this->assertSame($answer, $this->printer->printRequest($request));
    }

    public function testPostWithBody()
    {
        $request = $this->createRequest('POST', [], 'param1=value1&param2=value2');
        $answer = 'curl -X POST http://test.tst -d "param1=value1&param2=value2"';
        $this->assertSame($answer, $this->printer->printRequest($request));
    }

    public function testGetWithHeaders()
    {
        $request = $this->createRequest(
            'GET',
            [
                'Accept' => 'application/json',
                'Content-Type' => 'application/xml'
            ]);
        $answer = 'curl http://test.tst -H "Accept: application/json" -H "Content-Type: application/xml"';
        $this->assertSame($answer, $this->printer->printRequest($request));
    }

    private function createRequest(
        string $method = 'GET',
        array $headers = [],
        string $body = '',
        string $url = 'http://test.tst'
    )
    {
        return new Request($method, $url, $headers, $body);
    }

}
