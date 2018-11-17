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
$result = $collection->index();
```

After running this code `$result` will contain a non-truncated version of collections:

```
stdClass Object
(
    [collections] => Array
        (
            [0] => stdClass Object
                (
                    [collectionCode] => USCOURTS
                    [collectionName] => United States Courts Opinions
                    [packageCount] => 1134933
                    [granuleCount] => 2525240
                )

            [1] => stdClass Object
                (
                    [collectionCode] => BILLS
                    [collectionName] => Congressional Bills
                    [packageCount] => 202767
                    [granuleCount] => 
                )
)

```

## Testing

```bash
vendor/bin/phpunit
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.