<?php

namespace GovInfo\Console;

use \DOMDocument;
use GovInfo\Requestor\Requestor;
use GovInfo\RunTimeException;
use GuzzleHttp\Client;
use GovInfo\Api;
use GovInfo\Package;
use GovInfo\Requestor\PackageRequestor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Console application for pulling a packages summary
 */
class PackageSummaryConsole extends Command
{
    use ApiKeyTrait;

    private $apiKey;
    private $packageId;
    private $contentType;
    private $api;

    public function __construct(string $name = null, Api $api)
    {
        parent::__construct($name);
        $this->api = $api;
    }

    public function configure()
    {
        $this
            ->setName('package:summary')
            ->setDescription('Shows all packages for a collection')
            ->defineApiKeyFromFile();

        if (empty($this->apiKey)) {
            $this->addArgument('apiKey', InputArgument::REQUIRED, 'Your API Key');
        }

        $this->addOption(
            'file',
            'file',
            InputOption::VALUE_NONE,
            'Downloads results to a file'
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
        $this->api->setStrApiKey(
            $this->getApiKey($input)
        );
        $package = new Package($this->api);
        $requestor = new PackageRequestor();

        $symfonyStyle = new SymfonyStyle($input, $output);
        $this->packageId = $symfonyStyle->ask('Enter a PackageId', 'BILLS-116hr5629ih');
        $this->contentType = $symfonyStyle->ask('Enter a Content Type (i.e. xml)', 'xml');

        $requestor
            ->setStrPackageId($this->packageId)
            ->setStrContentType($this->contentType);

        if ($input->getOption('file')) {
            $file = $this->downloadResultsToFile($requestor, $package, $input);
            if (!$file) {
                $symfonyStyle->error('Unable to write file');
                return 0;
            }
            $symfonyStyle->success('File downloaded to ' . $file);
            return 0;
        }

        $response = $package->contentType($requestor);
        print_r($response);

        return 0;
    }

    private function downloadResultsToFile(Requestor $requestor, Package $package, InputInterface $input) : string
    {
        $response = $package->contentType($requestor);

        $contentType = strtolower($this->contentType);

        $string = $response->getBody()->getContents();

        if ($contentType == 'xml') {
            $string = $this->formatXml($string);
        }

        $file = $this->resolveDownloadPath($input);
        $file.= DIRECTORY_SEPARATOR . $this->packageId . '-' . strtotime('now');
        $file.= '.' . $contentType;

        if (!file_put_contents($file, $string)) {
            throw new RunTimeException('Error writing file');
        }

        return $file;
    }

    private function resolveDownloadPath(InputInterface $input)
    {
        $downloadPath = $input->getOption('path');

        if (empty($input->getOption('path'))) {
            return getenv('HOME') . DIRECTORY_SEPARATOR . 'Downloads';
        }

        if (substr($downloadPath,-1,1) != DIRECTORY_SEPARATOR) {
            return substr($downloadPath, 0, strlen($downloadPath) - 1);
        }

        return $downloadPath;
    }

    private function formatXml(string $xmlString) : string
    {
        $xml = simplexml_load_string($xmlString);
        $xmlDocument = new DOMDocument('1.0');
        $xmlDocument->preserveWhiteSpace = false;
        $xmlDocument->formatOutput = true;
        $xmlDocument->loadXML($xml->asXML());

        return $xmlDocument->saveXML();
    }
}