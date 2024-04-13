# downloader
## Simple interface for content downloading on the specified URI and it's trivial realisation.

This downloader will be useful for websites parsing, working with the REST API and other work with WEB resources via the HTTP protocol.
This version of the package contains an interface implementation based on PSR-18.
It is planned to make an implementation that works through [Selenium WebDriver](https://github.com/php-webdriver/php-webdriver).

### Requirements 
- **PHP >= 8.0.3**

### Installation
#### Using composer (recommended)
```bash
composer require balpom/downloader
```

### Usage sample
This downloader requires objects that implement the ResponseFactoryInterface, StreamFactoryInterface and UriFactoryInterface interfaces which defined in the [PSR-17 specification](https://www.php-fig.org/psr/psr-17/).
An excellent library that implements all these interfaces at once (all-in-one) is [Nyholm/psr7](https://github.com/Nyholm/psr7) - will use it.

This downloader also requires an HTTP client that implements the ClientInterface which defined in the [PSR-18 specification](https://www.php-fig.org/psr/psr-18/). For example, will use [phpwebclient/webclient](https://github.com/phpwebclient/webclient).

#### Installing third-party packages
```bash
composer require nyholm/psr7
```
```bash
composer require webclient/webclient
```

#### Downloader creation
```php
$factory = new \Nyholm\Psr7\Factory\Psr17Factory();
$client = new \Webclient\Http\Webclient($factory, $factory);
// Psr18Factories(RequestFactoryInterface $request, StreamFactoryInterface $stream, UriFactoryInterface $uri)
$factory = new \Balpom\Downloader\Factory\Psr18Factories($factory, $factory, $factory);
$downloader = new \Balpom\Downloader\Psr18Downloader($client, $factory);
```

#### Download URI
For test purpose will make request to site [https://ipmy.ru](https://ipmy.ru).
```php
$downloader = $downloader->get('http://ipmy.ru/ip');
echo $downloader->code(); echo PHP_EOL; // Must be 200.
echo $downloader->content(); echo PHP_EOL; // Must be your IP.
```

Extended sample you may find in "tests/psr18test.php" file - just run it:
```bash
php tests/psr18test.php
```

### License
MIT License See [LICENSE.MD](LICENSE.MD)
