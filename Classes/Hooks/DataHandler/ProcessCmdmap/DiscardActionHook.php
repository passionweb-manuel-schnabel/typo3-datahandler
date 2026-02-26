<?php

declare(strict_types=1);

namespace Passionweb\DataHandler\Hooks\DataHandler\ProcessCmdmap;

use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageQueue;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class DiscardActionHook
{
    /**
     * The hook "ProcessCmdmap_discardAction" will be called in vendor/typo3/cms-core/Classes/DataHandling/DataHandler.php
     * line 6116 (TYPO3 13.4.20), search for "ProcessCmdmap_discardAction"
     */
    public function processCmdmap_discardAction($table, $uid, $record, &$recordWasDiscarded): void
    {
        if($record['frame_layout'] == "101"){
            $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
            $messageQueue = $flashMessageService->getMessageQueueByIdentifier(FlashMessageQueue::NOTIFICATION_QUEUE);
            $message = $this->generateDebugMessage("Elements with Special Frame cannot be discarded");
            $messageQueue->addMessage($message);

            $recordWasDiscarded = true;
        }
    }

    private function generateDebugMessage(string $message)
    {
        return GeneralUtility::makeInstance(FlashMessage::class,
            $message, "", ContextualFeedbackSeverity::WARNING, true
        );
    }
}
