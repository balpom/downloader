<?php

declare(strict_types=1);

namespace Balpom\Downloader;

use Psr\Http\Message\ResponseInterface;
use \Exception;

abstract class AbstractDownloader implements DownloadInterface
{

    protected ResponseInterface $response; // Last response.
    protected int $attempts = 1; // Number of request attempts.
    protected int $pause = 10; // Pause (in seconds) between request attempts.
    protected int $redirects = 5; // Number of redirects following.
    protected array $headers = [];

    public function response()
    {
        return $this->response;
    }

    abstract public function get(string $uri): DownloadInterface;

    abstract public function head(string $uri): DownloadInterface;

    abstract public function post(string $uri, array $data = []): DownloadInterface;

    public function attempts(int $attempts): DownloadInterface
    {
        if (0 > $attempts) {
            throw new DownloaderException("Number of request attempts must be positive.");
        }
        if (10 < $attempts) {
            throw new DownloaderException("Number of request attempts must be less than or equal 10.");
        }
        $this->attempts = $attempts;

        return $this;
    }

    public function pause(int $seconds): DownloadInterface
    {
        if (0 > $seconds) {
            $seconds = 0;
        }
        $this->pause = $seconds;

        return $this;
    }

    public function withHeader(string $header): DownloadInterface
    {
        if (!empty($header) && false !== strpos($header, ':')) {
            $this->headers[$header] = $header;
        }

        return $this;
    }

    public function redirects(int $redirects): DownloadInterface
    {
        if (0 > $redirects) {
            throw new DownloaderException("Number of request attempts must be positive.");
        }
        if (10 < $redirects) {
            throw new DownloaderException("Number of request attempts must be less than or equal 10.");
        }
        $this->redirects = $redirects;

        return $this;
    }

    public function code(): int
    {
        try {
            $code = $this->response->getStatusCode();
        } catch (Exception $e) {
            //throw new DownloaderException("Error: status code not defined.");
            return 0;
        }

        return $code;
    }

    public function content(): string|false
    {

        if (200 !== $this->code()) {
            //throw new DownloaderException("Error: status code is not 200 OK.");
            return false;
        }

        try {
            $content = $this->response->getBody()->__toString();
        } catch (Exception $e) {
            //throw new DownloaderException("Error: content not defined.");
            return false;
        }

        return $content;
    }

    protected function getLocation()
    {
        try {
            $location = $this->response->getHeader('Location');
        } catch (Exception $e) {
            throw new DownloaderException("Error: unable to get redirect location.");
        }

        return isset($location[0]) ? $location[0] : false;
    }

    protected function getHeaderName(string $header)
    {
        $pos = strpos($header, ':');

        return trim(substr($header, 0, $pos));
    }

    protected function getHeaderValue(string $header)
    {
        $pos = strpos($header, ':') + 1;

        return trim(substr($header, $pos));
    }
}
