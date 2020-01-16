<?php

namespace Cnizzardini\GovInfo\Console;

use GuzzleHttp\Client;
use Cnizzardini\GovInfo\Api;
use Cnizzardini\GovInfo\Collection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Console application for pulling collections
 */
trait TraitApiKey
{
    use TraitApiKey;

    private $apiKey;

    private function defineApiKeyFromFile()
    {
        $file = getcwd() . DIRECTORY_SEPARATOR . 'apiKey.txt';
        if (file_exists($file)) {
            $this->apiKey = trim(
                file_get_contents($file)
            );
        }
    }

    private function getApiKey(InputInterface $input)
    {
        if (!empty($this->apiKey)) {
            return $this->apiKey;
        }

        return $input->getArgument('apiKey');
    }
}