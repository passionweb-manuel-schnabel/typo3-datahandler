<?php

declare(strict_types=1);

namespace Passionweb\DataHandler\Hooks\DataHandler\ProcessCmdmap;

use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageQueue;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class AfterFinishHook
{
    /**
     * The hook "processCmdmap_afterFinish" will be called in vendor/typo3/cms-core/Classes/DataHandling/DataHandler.php
     * line 3346 (TYPO3 13.4.20), search for "processCmdmap_afterFinish"
     */
    public function processCmdmap_afterFinish(DataHandler $dataHandler): void
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getQueryBuilderForTable('pages');
        $queryBuilder->getRestrictions()->removeAll();

        $table = array_key_first($dataHandler->cmdmap);
        if($table == "pages"){
            foreach($dataHandler->cmdmap[$table] as $key => $entry) {
                $newId = $dataHandler->copyMappingArray_merged['pages'][$key];
                $newSlug = "/TODO".$newId;

                $queryBuilder
                    ->update('pages')
                    ->where(
                        $queryBuilder->expr()->eq(
                            'uid',
                            $queryBuilder->createNamedParameter($newId, Connection::PARAM_INT)
                        )
                    )
                    ->set('slug', $newSlug)
                    ->executeStatement();
            }
        }
        $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
        $messageQueue = $flashMessageService->getMessageQueueByIdentifier(FlashMessageQueue::NOTIFICATION_QUEUE);
        $message = $this->generateDebugMessage("Automatically setup custom slug");
        $messageQueue->addMessage($message);
    }

    private function generateDebugMessage(string $message)
    {
        return GeneralUtility::makeInstance(FlashMessage::class,
            $message, "", ContextualFeedbackSeverity::OK, true
        );
    }
}
