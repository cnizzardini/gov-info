<?php

namespace GovInfo\Console;

use GovInfo\RunTimeException;
use GuzzleHttp\Client;
use GovInfo\Api;
use GovInfo\Collection;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Console application for pulling collections
 */
class CollectionIndexConsole extends Command
{
    use ApiKeyTrait;

    private $apiKey;

    public function configure()
    {
        $this
            ->setName('collection:index')
            ->setDescription('Shows all collections')
            ->defineApiKeyFromFile();

        if (empty($this->apiKey)) {
            $this->addArgument('apiKey', InputArgument::REQUIRED, 'Your API Key');
        }
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->comment('Loading collections...');

        $apiKey = $this->getApiKey($input);
        $api = new Api(new Client(), $apiKey);
        $collection = new Collection($api);
        $result = $collection->index();

        if (!isset($result['collections'])) {
            throw new RunTimeException('Error retrieving collections');
        }

        $rows = array_map('array_values', $result['collections']);
        $keys = array_keys(reset($result['collections']));

        $io->table($keys, $rows);

        return 0;
    }
}