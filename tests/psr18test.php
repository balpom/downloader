<?php

namespace Balpom\Downloader;

require __DIR__ . "/../vendor/autoload.php";

use Nyholm\Psr7\Factory\Psr17Factory;
use Webclient\Http\Webclient;
use Balpom\Downloader\Factory\Psr18Factories;

$factory = new Psr17Factory();
//$http = new Webclient($responseFactory, $streamFactory);
$client = new Webclient($factory, $factory);
$factory = new Psr18Factories($factory, $factory, $factory);
$downloader = new Psr18Downloader($client, $factory);

$url = 'http://ipmy.ru';
$downloader = $downloader->get($url);
echo $downloader->code();
echo PHP_EOL;
echo empty($downloader->content()) ? 'EMPTY CONTENT' : 'Content lenght: ' . mb_strlen($downloader->content());
echo PHP_EOL . PHP_EOL;

// No redirect following!
$downloader = $downloader->redirects(0)->get($url);
echo $downloader->code();
echo PHP_EOL;
echo empty($downloader->content()) ? 'EMPTY CONTENT' : 'Content lenght: ' . mb_strlen($downloader->content());
echo PHP_EOL . PHP_EOL;

$url = 'http://ipmy.ru/headers';
$downloader = $downloader->get($url);
echo $downloader->code();
echo PHP_EOL;
echo empty($downloader->content()) ? 'EMPTY CONTENT' : 'Content lenght: ' . mb_strlen($downloader->content());
echo PHP_EOL . PHP_EOL;

$url = 'http://ipmy.ru/ip';
$downloader = $downloader->get($url);
echo $downloader->content();
echo PHP_EOL;

$url = 'http://ipmy.ru/host';
$downloader = $downloader->get($url);
echo $downloader->content();
echo PHP_EOL . PHP_EOL;

$url = 'http://ipmy.ru/ip';
$downloader = $downloader->post($url, ['xxx' => 'yyy']);
echo $downloader->content();
echo PHP_EOL;

$url = 'http://ipmy.ru/host';
$downloader = $downloader->post($url, ['xxx' => 'yyy']);
echo $downloader->content();
echo PHP_EOL . PHP_EOL;
