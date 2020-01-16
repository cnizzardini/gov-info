<?php

namespace Cnizzardini\GovInfo\Console;

use GuzzleHttp\Client;
use Cnizzardini\GovInfo\Api;
use Cnizzardini\GovInfo\Package;
use Cnizzardini\GovInfo\Requestor\PackageRequestor;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Console application for pulling a packages summary
 */
class PackageSummaryConsole extends Command
{
    use ApiKeyTrait;

    private $apiKey;

    public function configure()
    {
        $this
            ->setName('package:summary')
            ->setDescription('Shows all packages for a collection');

        $this->defineApiKeyFromFile();

        if (empty($this->apiKey)) {
            $this->addArgument('apiKey', InputArgument::REQUIRED, 'Your API Key');
        }
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $apiKey = $this->getApiKey($input);

        $api = new Api(new Client(), $apiKey);
        $package = new Package($api);
        $requestor = new PackageRequestor();

        $helper = $this->getHelper('question');

        $packageId = $helper->ask(
            $input,
            $output,
            new Question('Enter a PackageId: ')
        );

        $contentType = $helper->ask(
            $input,
            $output,
            new Question('Enter a Content Type (i.e. xml): ', 'xml')
        );

        $requestor
            ->setStrPackageId($packageId)
            ->setStrContentType($contentType);

        $result = $package->contentType($requestor);

        print_r($result);

        return 0;
    }
}