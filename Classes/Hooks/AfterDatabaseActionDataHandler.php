<?php

declare(strict_types=1);

namespace Passionweb\DataHandler\Hooks;

use TYPO3\CMS\Core\DataHandling\DataHandler;

class AfterDatabaseActionDataHandler
{
    public function processDatamap_afterDatabaseOperations(string $status, string $table, string $id, array $fieldArray, DataHandler $dataHandler): void
    {
        if ($status == 'new' && $table == 'pages') {
            $pageId = $dataHandler->substNEWwithIDs[$id];

            $data['tt_content'][$id] = [
                'header' => 'This is an automatic header',
                'pid' => $pageId,
            ]; //Set automatic header for new page

            $cmd['tt_content'][27]['copy'] = $pageId; //Copy record with uid 27 to first position of page with uid

            $dataHandler->start($data, $cmd);
            $dataHandler->process_datamap();
        }
    }
}