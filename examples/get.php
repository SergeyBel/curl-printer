<?php

use CurlPrinter\CurlPrinterMiddleware;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\CurlHandler;
use \Monolog\Logger;
use \Monolog\Handler\StreamHandler;
use \GuzzleHttp\HandlerStack;


require_once '../vendor/autoload.php';


$logger = new Logger('example.logger');
$logger->pushHandler(new StreamHandler('php://stdout'));


$stack = HandlerStack::create();
$stack->setHandler(new CurlHandler());
$stack->push(new CurlPrinterMiddleware($logger));
$client = new Client(['handler' => $stack]);
$client->get('https://www.google.com/');

