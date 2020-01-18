#!/usr/bin/env php
<?php

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use GovInfo\Console\CollectionIndexConsole;
use GovInfo\Console\CollectionPackagesConsole;
use GovInfo\Console\PackageSummaryConsole;

$application = new Application();
$application->add(new CollectionIndexConsole());
$application->add(new CollectionPackagesConsole());
$application->add(new PackageSummaryConsole());
$application->run();