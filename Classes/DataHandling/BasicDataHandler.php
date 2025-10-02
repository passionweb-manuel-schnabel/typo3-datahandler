<?php

declare(strict_types=1);

namespace Passionweb\DataHandler\DataHandling;

use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;

final class BasicDataHandler
{
    protected DataHandler $dataHandler;
    public function __construct()
    {
        $dataHandler = GeneralUtility::makeInstance(DataHandler::class);
    }

    public function basicUsage(): void
    {
        $cmd = [];
        $data = [];
        $this->dataHandler->start($data, $cmd);

        $this->dataHandler->process_datamap();
        $this->dataHandler->process_cmdmap();

        $cmd['tt_content'][21]['delete'] = 1; //Delete record with uid 21
        $cmd['tt_content'][999]['copy'] = -303; //Copy record with uid 999 directly after record with uid 303
        $cmd['tt_content'][1000]['copy'] = 400; //Copy record with uid 1000 to first position of page with uid 400
        $cmd['tt_content'][1000]['move'] = 400; //Move record with uid 1000 to first position of page with uid 400
    }
}
