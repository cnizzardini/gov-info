#!/usr/bin/env php
<?php

require __DIR__.'/vendor/autoload.php';

use GovInfo\Api;
use GuzzleHttp\Client;
use Symfony\Component\Console\Application;
use GovInfo\Console\CollectionIndexConsole;
use GovInfo\Console\CollectionPackagesConsole;
use GovInfo\Console\PackageSummaryConsole;

$api = new Api(
    new Client()
);

$application = new Application();
$application->add(new CollectionIndexConsole(null, $api));
$application->add(new CollectionPackagesConsole(null, $api));
$application->add(new PackageSummaryConsole(null, $api));
$application->run();