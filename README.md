# Curl printer

**curl-printer** is a library which allows you print request as curl command line string. It is useful for logging and debugging.
Useful for PSR-7, Guzzle and custom Requests.

## Installation
```
composer require sergey-bel/curl-printer
```


## Usage

```php
use CurlPrinter\CurlPrinter;
use GuzzleHttp\Psr7\Request;

$request = new RequestData(
    HttpMethod::POST,
    'https://someapi.com/user',
     [
       'Accept' => 'application/json',
     ],
     'id=12345'
);

$printer = new CurlPrinter();
echo $printer->print($request); 
// curl -X POST https://someapi.com/user -d 'id=12345' -H 'Accept: application/json'
```

## Guzzle middleware

```php
$logger = // some LoggerInterface
$stack = new HandlerStack();
$stack->push(new CurlPrinterMiddleware($logger));
$client = new Client(['handler' => $stack]);
$client->post(...);
```
