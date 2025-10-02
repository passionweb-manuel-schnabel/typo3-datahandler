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

        $this->dataHandler->start([], $cmd);
        $this->dataHandler->process_cmdmap();

        $uid = $this->dataHandler->copyMappingArray_merged['tt_content'][1000];

        $errors = $this->dataHandler->errorLog;

        //Codebreak 2
        $data['pages']['NEW12345'] = [
            'title' => 'New Codebreak Page',
            'pid' => '123',
        ];
        $data['pages']['NEW54321'] = [
            'title' => 'Subpage after Codebreak Page',
            'pid' => '-123',
        ];
        $data['pages']['NEW11111'] = [
            'title' => 'Another Subpage after Codebreak Page',
            'pid' => -'NEW54321',
        ];

        $this->dataHandler->start($data, []);
        $this->dataHandler->process_datamap();

        $data['sys_categories']['NEW99999'] = [
            'title' => 'New Category',
            'pid' => 100
        ];
        $data['pages']['NEW12345'] = [
            'title' => 'New Codebreak Page',
            'pid' => '123',
            'categories' => [
                'NEW99999'
            ]
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
