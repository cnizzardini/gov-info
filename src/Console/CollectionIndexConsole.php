<?php

namespace GovInfo\Console;

use GovInfo\RunTimeException;
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
    private $api;

    public function __construct(string $name = null, Api $api)
    {
        parent::__construct($name);
        $this->api = $api;
    }

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
        $symfonyStyle = new SymfonyStyle($input, $output);
        $symfonyStyle->comment('Loading collections...');

        $this->api->setStrApiKey(
            $this->getApiKey($input)
        );
        $collection = new Collection($this->api);
        $result = $collection->index();

        if (!isset($result['collections'])) {
            throw new RunTimeException('Error retrieving collections');
        }

        $rows = array_map('array_values', $result['collections']);
        $keys = array_keys(reset($result['collections']));

        $symfonyStyle->table($keys, $rows);

        $api = $collection->getObjApi();
        $symfonyStyle->success('Request completed');
        $symfonyStyle->writeln($api->getObjUri());

        return 0;
    }
}