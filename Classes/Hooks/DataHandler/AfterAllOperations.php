<?php

declare(strict_types=1);

namespace Passionweb\DataHandler\Hooks\DataHandler;

use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageQueue;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class AfterAllOperations
{
    public function processDatamap_afterAllOperations(DataHandler $dataHandler): void
    {
        $message = "";
        if(array_key_exists('tt_content', $dataHandler->datamap)){
            $message = GeneralUtility::makeInstance(
                FlashMessage::class,
                "Working with Content Element...",
                "Debug Info",
                ContextualFeedbackSeverity::WARNING,
                true
            );
        }
        else if(array_key_exists('recordPidsForDeletedRecords', $dataHandler->datamap)){
            $message = GeneralUtility::makeInstance(
                FlashMessage::class,
                "Deleting Records...",
                "Debug Info",
                ContextualFeedbackSeverity::WARNING,
                true
            );
        }
        else if(!empty($dataHandler->cmdmap)){
            $message = GeneralUtility::makeInstance(
                FlashMessage::class,
                "Processing cmdmap...",
                "Debug Info",
                ContextualFeedbackSeverity::WARNING,
                true
            );
        }

        $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
        $messageQueue = $flashMessageService->getMessageQueueByIdentifier();
        $messageQueue->addMessage($message);

    }
}