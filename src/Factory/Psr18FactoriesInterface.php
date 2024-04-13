<?php

namespace Balpom\Downloader\Factory;

use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;

interface Psr18FactoriesInterface
{

    public function request(): RequestFactoryInterface;

    public function stream(): StreamFactoryInterface;

    public function uri(): UriFactoryInterface;
}
