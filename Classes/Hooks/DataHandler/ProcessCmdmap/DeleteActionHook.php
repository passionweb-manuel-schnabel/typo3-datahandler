<?php

declare(strict_types=1);

namespace Passionweb\DataHandler\Hooks\DataHandler\ProcessCmdmap;

use TYPO3\CMS\Core\Authentication\BackendUserAuthentication;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageQueue;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class DeleteActionHook
{
    /**
     * The hook "ProcessCmdmap_deleteAction" will be called in vendor/typo3/cms-core/Classes/DataHandling/DataHandler.php
     * line 5235 (TYPO3 13.4.20), search for "ProcessCmdmap_deleteAction"
     */
    public function processCmdmap_deleteAction($table, $uid, $recordToDelete, &$recordWasDeleted, DataHandler $dataHandler): void
    {
        if ($table == "tx_data_handler_domain_model_codebreak") {
            if($recordToDelete['title'] != "" && $recordToDelete['description'] != "" && $recordToDelete['link'] != "" && $recordToDelete['hidden'] == 0){
                //fully filled entries can not be deleted if they are not hidden first
                $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
                $messageQueue = $flashMessageService->getMessageQueueByIdentifier(FlashMessageQueue::NOTIFICATION_QUEUE);
                $message = $this->generateDebugMessage("Do you really want to delete this record? Set it to hidden before deleting it completely.");
                $messageQueue->addMessage($message);
                $recordWasDeleted = true;
            }
        }
    }

    private function generateDebugMessage(string $message)
    {
        return GeneralUtility::makeInstance(FlashMessage::class,
            $message, "", ContextualFeedbackSeverity::WARNING, true
        );
    }
}
