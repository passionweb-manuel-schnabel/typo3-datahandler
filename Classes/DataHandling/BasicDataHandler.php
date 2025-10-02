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
        $this->dataHandler = GeneralUtility::makeInstance(DataHandler::class);
    }

    public function basicUsage(): void
    {
        $cmd = [];
        $data = [];
        $this->dataHandler->start($data, $cmd);

        $this->dataHandler->process_datamap();
        $this->dataHandler->process_cmdmap();

        $cmd['tt_content'][34]['delete'] = 1; //Delete record with uid 34
        $cmd['tt_content'][25]['copy'] = -36; //Copy record with uid 25 directly after record with uid 36
        $cmd['tt_content'][27]['copy'] = 1; //Copy record with uid 26 to first position of page with uid 1
        $cmd['tt_content'][35]['move'] = 1; //Move record with uid 35 to first position of page with uid 1

        $this->dataHandler->start([], $cmd);
        $this->dataHandler->process_cmdmap();

        $uid = $this->dataHandler->copyMappingArray_merged['tt_content'][27];

        $errors = $this->dataHandler->errorLog;

        $data['pages']['NEW12345'] = [
            'title' => 'New Codebreak Page',
            'pid' => '1',
        ];
        $data['pages']['NEW54321'] = [
            'title' => 'Subpage',
            'pid' => '-16',
        ];
        $data['pages']['NEW11111'] = [
            'title' => 'Another Subpage after Codebreak Page',
            'pid' => '-NEW54321',
        ];

        $this->dataHandler->start($data, []);
        $this->dataHandler->process_datamap();

        $data['sys_category']['NEW99999'] = [
            'title' => 'New Category',
            'pid' => 1
        ];
        $data['tt_content']['NEWab9999'] = [
            'header' => 'Working with Categories',
            'pid' => 1,
            'categories' => 'NEW99999'
        ];

        $newId = $this->dataHandler->substNEWwithIDs['NEW12345'];
        $data['pages'][$newId] = [
            'title' => 'Edited Title',
            'no_cache' => 1
        ];

        $this->dataHandler->start($data, []);
        $this->dataHandler->process_datamap();
        $this->dataHandler->clear_cacheCmd("all");
    }
}
