<?php

namespace GovInfo\Console;

use GovInfo\Requestor\AbstractRequestor;
use GovInfo\RunTimeException;
use GuzzleHttp\Client;
use GovInfo\Api;
use GovInfo\Collection;
use GovInfo\Requestor\CollectionAbstractRequestor;
use \DateTime;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Console application for pulling a collections packages
 */
class CollectionPackagesConsole extends Command
{
    use ApiKeyTrait;

    private $apiKey;
    private $collectionCode;
    private $api;

    public function __construct(string $name = null, Api $api)
    {
        parent::__construct($name);
        $this->api = $api;
    }

    public function configure()
    {
        $this
            ->setName('collection:packages')
            ->setDescription('Shows all packages for a collection')
            ->defineApiKeyFromFile();

        if (empty($this->apiKey)) {
            $this->addArgument('apiKey', InputArgument::REQUIRED, 'Your API Key');
        }

        $this->addOption(
            'file',
            'file',
            InputOption::VALUE_NONE,
            'Downloads results as CSV'
        );
        $this->addOption(
            'path',
            'path',
            InputOption::VALUE_OPTIONAL,
            'Path to downloads folder (only required if console cannot find your home directory)',
            false
        );
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $symfonyStyle = new SymfonyStyle($input, $output);
        $symfonyStyle->comment('Loading collections...');

        $this->api->setStrApiKey(
            $this->getApiKey($input)
        );
        $collection = new Collection($this->api);

        $this->collectionCode = $this->askUserForCollectionCode($collection, $symfonyStyle);
        $dateTime = $this->askUserForStartDate(new DateTime('first day of last month'), $symfonyStyle);

        $requestor = new CollectionAbstractRequestor();
        $requestor
            ->setStrCollectionCode($this->collectionCode)
            ->setObjStartDate($dateTime);

        $symfonyStyle->comment('Retrieving packages...');

        if ($input->getOption('file')) {
            $file = $this->downloadResultsToCsv($collection, $requestor, $input);
            if (!$file) {
                $symfonyStyle->error('Unable to write file');
                return 0;
            }
            $this->printSuccess($symfonyStyle, $collection, ['File downloaded to ' . $file]);
            return 0;
        }

        $this->displayResultsInTable($collection, $requestor, $symfonyStyle);

        $this->printSuccess($symfonyStyle, $collection);

        return 0;
    }

    private function displayResultsInTable(Collection $collection, AbstractRequestor $requestor, SymfonyStyle $symfonyStyle)
    {
        $results = $this->formatResults($collection, $requestor);
        $symfonyStyle->table($results['header'], $results['rows']);
    }

    private function downloadResultsToCsv(Collection $collection, AbstractRequestor $requestor, InputInterface $input) : string
    {
        $downloadPath = getenv('HOME') . DIRECTORY_SEPARATOR . 'Downloads';

        if (!empty($input->getOption('path'))) {
            $downloadPath = $input->getOption('path');
            if (substr($downloadPath,-1,1) == DIRECTORY_SEPARATOR) {
                $downloadPath = substr($downloadPath, 0, strlen($downloadPath) - 1);
            }
        }

        $collectionCode = strtolower($this->collectionCode);
        $file = $downloadPath . DIRECTORY_SEPARATOR . 'govinfo-' . $collectionCode . '-' . strtotime('now') . '.csv';

        $results = $this->formatResults($collection, $requestor);
        $fileResource = fopen($file, 'w');

        fputcsv($fileResource, $results['header']);
        foreach ($results['rows'] as $row) {
            fputcsv($fileResource, $row);
        }

        if (!fclose($fileResource)) {
            throw new RunTimeException('Error writing file');
        }

        return $file;
    }

    private function formatResults(Collection $collection, AbstractRequestor $requestor) : array
    {
        $result = $collection->item($requestor);

        if (!isset($result['packages'])) {
            throw new RunTimeException('Error retrieving packages');
        }

        $rows = array_map('array_values', $result['packages']);
        $keys = array_keys(reset($result['packages']));

        return [
            'header' => $keys,
            'rows' => $rows
        ];
    }

    private function askUserForCollectionCode(Collection $collection, SymfonyStyle $symfonyStyle) : string
    {
        $result = $collection->index();

        if (!isset($result['collections'])) {
            throw new RunTimeException('Error retrieving collections');
        }

        $collectionCodes = array_column($result['collections'], 'collectionName','collectionCode');

        return strtoupper(
            $symfonyStyle->choice(
                'Retrieve packages from what collectionCode?',
                $collectionCodes
            )
        );
    }

    private function askUserForStartDate(DateTime $dateTime, SymfonyStyle $symfonyStyle) : DateTime
    {
        $startDate = strtoupper(
            $symfonyStyle->ask(
                'Enter a start date as YYYY-MM-DD',
                $dateTime->format('Y-m-d')
            )
        );

        return new DateTime($startDate);
    }

    private function printSuccess(SymfonyStyle $symfonyStyle, Collection $collection, array $output = []) : void
    {
        $api = $collection->getObjApi();
        $arrayOut = array_merge(['Request completed'], $output);
        $symfonyStyle->success($arrayOut);
        $symfonyStyle->writeln('From: ' . $api->getObjUri());
        $symfonyStyle->writeln('');
    }
}