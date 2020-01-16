<?php

namespace Cnizzardini\GovInfo\Console;

use GuzzleHttp\Client;
use Cnizzardini\GovInfo\Api;
use Cnizzardini\GovInfo\Collection;
use Cnizzardini\GovInfo\Requestor\CollectionRequestor;
use \DateTime;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Console application for pulling a collections packages
 */
class CollectionPackagesConsole extends Command
{
    use ApiKeyTrait;

    private $apiKey;

    public function configure()
    {
        $this
            ->setName('collection:packages')
            ->setDescription('Shows all packages for a collection')
            ->defineApiKeyFromFile();

        if (empty($this->apiKey)) {
            $this->addArgument('apiKey', InputArgument::REQUIRED, 'Your API Key');
        }
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $apiKey = $this->getApiKey($input);

        $api = new Api(new Client(), $apiKey);
        $collection = new Collection($api);
        $requestor = new CollectionRequestor();

        $helper = $this->getHelper('question');

        $collectionCode = strtoupper(
            $helper->ask(
                $input,
                $output,
                new Question('Retrieve packages from what collectionCode?', 'BILLS')
            )
        );

        $startDate = strtoupper(
            $helper->ask(
                $input,
                $output,
                new Question('Enter a start date as YYYY-MM-DD', '')
            )
        );

        $requestor
            ->setStrCollectionCode($collectionCode)
            ->setObjStartDate(new DateTime($startDate));

        $result = $collection->item($requestor);

        $table = new Table($output);
        $table->setHeaders(['packageId', 'lastModified', 'packageLink', 'docClass', 'title']);

        foreach ($result['packages'] as $row) {
            $table->addRow(
                array_values($row)
            );
        }

        $table->render();

        return 0;
    }
}