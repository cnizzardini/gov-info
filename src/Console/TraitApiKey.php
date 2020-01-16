<?php

namespace Cnizzardini\GovInfo\Console;

use Symfony\Component\Console\Input\InputInterface;

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