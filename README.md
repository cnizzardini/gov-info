# PHP Library for api.govinfo.gov

This alpha stage package provides a very simple way to access api.govinfo.gov

## Install

You can install this package via composer.

```bash
composer require cnizzardini/gov-info
```

## Usage

```php
use Cnizzardini\GovInfo\Api;
use Cnizzardini\GovInfo\Collections;

$api = new Api(new \GuzzleHttp\Client(), 'DEMO_KEY');
$collection = new Collection($api);
$collection->get();
```

## Testing

```bash
vendor/bin/phpunit
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.