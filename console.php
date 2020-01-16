#!/usr/bin/env php
<?php

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Cnizzardini\GovInfo\Console\CollectionIndexConsole;
use Cnizzardini\GovInfo\Console\CollectionPackagesConsole;

$application = new Application();
$application->add(new CollectionIndexConsole());
$application->add(new CollectionPackagesConsole());
$application->run();