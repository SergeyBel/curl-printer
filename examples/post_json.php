<?php

use CurlPrinter\CurlPrinterMiddleware;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\CurlHandler;
use \Monolog\Logger;
use \Monolog\Handler\StreamHandler;
use \GuzzleHttp\HandlerStack;


require_once __DIR__ .  '/../vendor/autoload.php';


$logger = new Logger('example.logger');
$logger->pushHandler(new StreamHandler('php://stdout'));


$stack = HandlerStack::create();
$stack->setHandler(new CurlHandler());
$stack->push(new CurlPrinterMiddleware($logger));
$client = new Client(['handler' => $stack]);
$client->post('https://www.google.com/',
    [
        'json' => [
            "key" => "value",
        ],
        'headers' => [
            'Content-type' => 'application/json; charset=utf-8',
            'Accept' => 'application/json',
        ],
    ]
);

