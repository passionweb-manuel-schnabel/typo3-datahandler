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

class PostProcessCmdmapHook
{
    /**
     * The hook "processCmdmap_postProcess" will be called in vendor/typo3/cms-core/Classes/DataHandling/DataHandler.php
     * line 3346 (TYPO3 13.4.20), search for "processCmdmap_postProcess"
     */
    public function processCmdmap_postProcess(string $command, string &$table, string $id, string $value, DataHandler $dataHandler, $pasteDatamap): void
    {
        if ($command == 'copy') {
            $message = "";
            $action = $value < 0 ? ' after ' : ' into ';
            $message .= "Copied " . $table . " element with uid " . $id . $action . $table . " element with uid " . $value;
            $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
            $messageQueue = $flashMessageService->getMessageQueueByIdentifier(FlashMessageQueue::NOTIFICATION_QUEUE);
            $message = $this->generateDebugMessage($message);
            $messageQueue->addMessage($message);
        }
    }

    private function generateDebugMessage(string $message)
    {
        return GeneralUtility::makeInstance(FlashMessage::class,
            $message, "", ContextualFeedbackSeverity::OK, true
        );
    }
}
