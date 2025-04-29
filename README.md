# Curl printer

**curl-printer** is a library which allows you print request as curl command line string. It is useful for logging and debugging.
Useful for PSR-7, Guzzle and custom Requests.

## Installation
```
composer require sergey-bel/curl-printer
```


## Usage

### Request data
```php
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
// curl -X POST https://someapi.com/user -H 'Accept: application/json' -d 'id=12345'
```


### PSR-7 Request
```php
// $psr7Request implements RequestInterface 

$extractor = new PsrRequestExtractor();
$printer = new CurlPrinter();

$request = $extractor->extract($psr7Request)
$printer->print($request);
```

### Guzzle middleware

```php
$logger = // some LoggerInterface
$stack = new HandlerStack();
$stack->push(new CurlPrinterMiddleware($logger));
$client = new Client(['handler' => $stack]);
$client->send(...);
```

### Settings
Formatting settings are available in the `FormatterSettings` class

```php
$settings = (new FormatterSettings())
            ->setQuotes('"');
$request = new RequestData(
    HttpMethod::POST,
    'https://someapi.com/user',
     [
       'Accept' => 'application/json',
     ],
     'id=12345'
);
$printer = (new CurlPrinter())->setSettings($settings);
echo $printer->print($request); 
// curl -X POST https://someapi.com/user -H "Accept: application/json" -d "id=12345" 
```
