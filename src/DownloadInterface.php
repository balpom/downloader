<?php

namespace Balpom\Downloader;

interface DownloadInterface
{

    /**
     * Set max number of request attempts.
     */
    public function attempts(int $attempts): DownloadInterface;

    /**
     * Set pause time between request attempts.
     */
    public function pause(int $seconds): DownloadInterface;

    /**
     * Set the header that will be added to each request.
     */
    public function withHeader(string $header): DownloadInterface;

    /**
     * Get content of web-resource with GET method.
     */
    public function get(string $uri): DownloadInterface;

    /**
     * Get content of web-resource with HEAD method.
     */
    public function head(string $uri): DownloadInterface;

    /**
     * Get content of web-resource with POST method.
     */
    public function post(string $uri, array $data = []): DownloadInterface;

    /**
     * Get HTTP code of last request result.
     */
    public function code(): int;

    /**
     * Get content of last request result.
     */
    public function content(): string|false;
}
