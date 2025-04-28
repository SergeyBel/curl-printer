<?php

declare(strict_types=1);

namespace CurlPrinter\Tests\Formatter;

use CurlPrinter\Formatter\CurlFormatter;
use CurlPrinter\Formatter\FormatterSettings;
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

    public function testHeaders()
    {
        $request = $this->createRequest(
            HttpMethod::POST,
            'http://test.com',
            [
                'Accept' => 'html',
                'Multi' => ['one', 'two']
            ],
            ''
        );
        $expected = "curl -X POST http://test.com -H 'Accept: html' -H 'Multi: one,two'";
        $this->assertSame($expected, $this->formatter->format($request));
    }


    public function testReplaces()
    {
        $options = (new FormatterSettings())
            ->addReplaced('api_key', '******');

        $this->formatter->setOptions($options);
        $request = $this->createRequest(
            HttpMethod::GET,
            'http://test.com',
            ['Authorization' => 'api_key'],
            ''
        );
        $expected = "curl http://test.com -H 'Authorization: ******'";
        $this->assertSame($expected, $this->formatter->format($request));
    }

    public function testMultiline()
    {
        $options = (new FormatterSettings())
            ->setMultiline();

        $this->formatter->setOptions($options);
        $request = $this->createRequest(
            HttpMethod::POST,
            'http://test.com',
            [
                'Accept' => 'json',
                'Agent' => 'chrome'
            ],
            'key=value'
        );
        $expected =
        <<<EOD
        curl -X POST http://test.com \
        -H 'Accept: json' \
        -H 'Agent: chrome' \
        -d 'key=value'
        EOD;

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
