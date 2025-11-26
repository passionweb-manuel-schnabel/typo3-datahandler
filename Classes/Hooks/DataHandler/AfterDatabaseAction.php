<?php

declare(strict_types=1);

namespace Passionweb\DataHandler\Hooks\DataHandler;

use TYPO3\CMS\Core\DataHandling\DataHandler;

class AfterDatabaseAction
{
    public function processDatamap_afterDatabaseOperations(string $status, string $table, string $id, array $fieldArray, DataHandler $dataHandler): void
    {
        if ($status == 'new' && $table == 'pages') {
            $pageId = $dataHandler->substNEWwithIDs[$id];

            $data['tt_content'][$id] = [
                'header' => 'This is an automatic header',
                'pid' => $pageId,
            ]; //Set automatic header for new page

            $dataHandler->start($data, []);
            $dataHandler->process_datamap();
        }
    }
}