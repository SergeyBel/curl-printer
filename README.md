# curl-printer [![Build Status](https://travis-ci.com/SergeyBel/curl-printer.svg?branch=main)](https://travis-ci.com/SergeyBel/curl-printer)

**curl-printer** is a library which allows you print php PSR-7 request as curl command line string. It is useful for logging and debugging

## Installation
```
composer require sergey-bel/curl-printer
```


## Usage

```php
use CurlPrinter\CurlPrinter;
use GuzzleHttp\Psr7\Request;

$request = new Request(
    'POST',
    'https://someapi.com/v2/user/create',
     [
       'Accept' => 'application/json',
     ],
     'user_id=12345'
);
$printer = new CurlPrinter();
echo $printer->printRequest($request); 
// curl -X POST https://someapi.com/v2/user/create -d 'user_id=12345' -H 'Accept: application/json'
```

## Guzzle middleware
You can use **CurlPrinterMiddleware** for comfortable work with Guzzle (see [examples](https://github.com/SergeyBel/curl-printer/tree/main/examples)) 

```php
$logger = // some LoggerInterface

$stack = // Guzzle handler stack
$stack->push(new CurlPrinterMiddleware($logger));
$client = new Client(['handler' => $stack]);
$client->post(...);
```
