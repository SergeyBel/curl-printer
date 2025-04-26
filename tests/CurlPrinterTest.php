<?php

declare(strict_types=1);

namespace CurlPrinter\Tests;

use CurlPrinter\CurlPrinter;
use CurlPrinter\HttpMethod;
use CurlPrinter\RequestData;
use PHPUnit\Framework\TestCase;

class CurlPrinterTest extends TestCase
{
    private $printer;

    protected function setUp(): void
    {
        $this->printer = new CurlPrinter();
    }

    public function testSimple()
    {
        $request = new RequestData(
            HttpMethod::GET,
            'http://test.com',
        );
        $expected = 'curl http://test.com';
        $this->assertSame($expected, $this->printer->print($request));
    }
}
