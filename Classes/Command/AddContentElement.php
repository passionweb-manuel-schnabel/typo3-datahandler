<?php

declare(strict_types=1);

namespace Passionweb\DataHandler\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use TYPO3\CMS\Core\Core\Bootstrap;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;

#[AsCommand(
    name: 'datahandler:contentelement',
)]
final class AddContentElement extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        Bootstrap::initializeBackendAuthentication();

        $dataHandler = GeneralUtility::makeInstance(DataHandler::class);
        $data['pages']['NEW125689'] = [
            'title' => 'Page through Console Command',
            'pid' => '1',
        ];
        $dataHandler->start($data, []);
        $dataHandler->process_datamap();

        $dataHandler->clear_cacheCmd('pages');

        return Command::SUCCESS;
    }
}
