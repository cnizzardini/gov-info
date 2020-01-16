#!/usr/bin/env php
<?php

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Cnizzardini\GovInfo\Console\CollectionIndexConsole;

$application = new Application();
$application->add(new CollectionIndexConsole());
$application->run();