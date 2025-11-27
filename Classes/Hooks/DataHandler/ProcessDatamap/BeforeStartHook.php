<?php

declare(strict_types=1);

namespace Passionweb\DataHandler\Hooks\DataHandler\ProcessDatamap;

use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class BeforeStartHook
{
    /**
     * The hook "processDatamap_beforeStart" will be called in vendor/typo3/cms-core/Classes/DataHandling/DataHandler.php
     * line 667 (TYPO3 13.4.20), search for "processDatamap_beforeStart"
     */
    public function processDatamap_beforeStart(DataHandler $dataHandler): void
    {
        if(count($dataHandler->datamap) === 0) {
            return;
        }
        if( array_key_exists('tt_content', $dataHandler->datamap)){
            $message = $this->generateDebugMessage('Doing some DataHandler stuff with ContentElements');
        } else {
            $message = $this->generateDebugMessage('Doing some DataHandler stuff with other data');
        }
        $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
        $messageQueue = $flashMessageService->getMessageQueueByIdentifier();
        $messageQueue->addMessage($message);
    }

    private function generateDebugMessage(string $message) {
        return GeneralUtility::makeInstance(FlashMessage::class,
            $message, "",ContextualFeedbackSeverity::WARNING, true
        );
    }
}
