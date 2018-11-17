# PHP Library for api.govinfo.gov

This alpha stage package provides a very simple way to access api.govinfo.gov

## Install

You can install this package via composer.

```bash
composer require cnizzardini/gov-info
```

## Usage

Retrieve an index of all collections available

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
        ...
)

```

Retrieve all packages in a collection

```php
use Cnizzardini\GovInfo\Requestor\CollectionRequestor;

$requestor = new CollectionRequestor();

$result = $collection->item($requestor->setStrCollectionCode('BILLS'));

```

After running this code `$result` will contain a non-truncated version of packages:

```
stdClass Object
(
    [count] => 202767
    [message] => 
    [nextPage] => https://api.govinfo.gov/collections/BILLS/2018-01-01T00:00:00Z/?offset=100&pageSize=100
    [previousPage] => 
    [packages] => Array
        (
            [0] => stdClass Object
                (
                    [packageId] => BILLS-115hr2740rfs
                    [lastModified] => 2018-11-16T00:33:17Z
                    [packageLink] => https://api.govinfo.gov/packages/BILLS-115hr2740rfs/summary
                    [docClass] => hr
                    [title] => Rabbi Michoel Ber Weissmandl Congressional Gold Medal Act of 2017
                )
        ...
```

Retrieve a specific packages in a collection. 

```php
$requestor->setStrCollectionCode('BILLS')->setObjStartDate(new \DateTime('2018-01-01 12:00:00'))
    ->setObjEndDate(new \DateTime('2018-02-01 12:00:00'))->setStrDocClass('hr')
    ->setStrPackageId('BILLS-115hr4033rfs')->setStrTitle('Geologic Mapping Act');

$result = $collection->item($requestor);
```

After running this code `$result` will contain the requested package

```
stdClass Object
(
    [count] => 202767
    [message] => 
    [nextPage] => https://api.govinfo.gov/collections/BILLS/2018-01-01T00:00:00Z/?offset=100&pageSize=100
    [previousPage] => 
    [packages] => Array
        (
            [2] => stdClass Object
                (
                    [packageId] => BILLS-115hr4033rfs
                    [lastModified] => 2018-11-16T00:33:00Z
                    [packageLink] => https://api.govinfo.gov/packages/BILLS-115hr4033rfs/summary
                    [docClass] => hr
                    [title] => National Geologic Mapping Act Reauthorization Act
                )
        )
)
```

Retrieve a summary of a package.

```php
use Cnizzardini\GovInfo\Package;
use Cnizzardini\GovInfo\Requestor\PackageRequestor;

$package = new Package($api);

$requestor = new PackageRequestor();
$requestor->setStrPackageId('BILLS-115hr4033rfs');

$result = $package->summary();
```

After running this code `$result` will contain a non-truncated version of the package summary

```
stdClass Object
(
    [title] => An Act To reauthorize the National Geologic Mapping Act of 1992.
    [shortTitle] => Array
        (
            [0] => stdClass Object
                (
                    [type] => measure
                    [title] => National Geologic Mapping Act Reauthorization Act
                )

        )
    ...
```

Retrieve a package as a specified content-type

```php
$package = new Package($api);

$requestor = new PackageRequestor();
$requestor->setStrPackageId('BILLS-115hr4033rfs')->setStrContentType('xml');

$result = $package->contentType();
```

After running this code `$result` will be an instance of GuzzleHttp\Psr7\Response

## Testing

```bash
vendor/bin/phpunit
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.