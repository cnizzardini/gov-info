<?php

namespace GovInfo\Console;

use GovInfo\Requestor\Requestor;
use GovInfo\RunTimeException;
use GuzzleHttp\Client;
use GovInfo\Api;
use GovInfo\Collection;
use GovInfo\Requestor\CollectionRequestor;
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
        $apiKey = $this->getApiKey($input);

        $api = new Api(new Client(), $apiKey);
        $collection = new Collection($api);

        $io = new SymfonyStyle($input, $output);

        $this->collectionCode = $this->askUserForCollectionCode($collection, $io);
        $dateTime = $this->askUserForStartDate(new DateTime('first day of last month'), $io);

        $requestor = new CollectionRequestor();
        $requestor
            ->setStrCollectionCode($this->collectionCode)
            ->setObjStartDate($dateTime);

        if ($input->getOption('file')) {
            $file = $this->downloadResultsToCsv($collection, $requestor, $input);
            if (!$file) {
                $io->error('Unable to write file');
                return 0;
            }
            $io->success('File downloaded to ' . $file);
            return 0;
        }

        $this->displayResultsInTable($collection, $requestor, $io);

        return 0;
    }

    private function displayResultsInTable(Collection $collection, Requestor $requestor, SymfonyStyle $io)
    {
        $results = $this->formatResults($collection, $requestor);
        $io->table($results['header'], $results['rows']);
    }

    private function downloadResultsToCsv(Collection $collection, Requestor $requestor, InputInterface $input) : string
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
        $fp = fopen($file, 'w');

        fputcsv($fp, $results['header']);
        foreach ($results['rows'] as $row) {
            fputcsv($fp, $row);
        }

        if (!fclose($fp)) {
            throw new RunTimeException('Error writing file');
        }

        return $file;
    }

    private function formatResults(Collection $collection, Requestor $requestor) : array
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

    private function askUserForCollectionCode(Collection $collection, SymfonyStyle $io) : string
    {
        $result = $collection->index();

        if (!isset($result['collections'])) {
            throw new RunTimeException('Error retrieving collections');
        }

        $collectionCodes = array_column($result['collections'], 'collectionName','collectionCode');

        return strtoupper(
            $io->choice(
                'Retrieve packages from what collectionCode?',
                $collectionCodes
            )
        );
    }

    private function askUserForStartDate(DateTime $dateTime, SymfonyStyle $io) : DateTime
    {
        $startDate = strtoupper(
            $io->ask(
                'Enter a start date as YYYY-MM-DD',
                $dateTime->format('Y-m-d')
            )
        );

        return new DateTime($startDate);
    }
}