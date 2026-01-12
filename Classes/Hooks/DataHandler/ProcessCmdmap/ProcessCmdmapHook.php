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

class ProcessCmdmapHook
{
    /**
     * The hook "ProcessCmdmap_preProcess" will be called in vendor/typo3/cms-core/Classes/DataHandling/DataHandler.php
     * line 3346 (TYPO3 13.4.20), search for "ProcessCmdmap_preProcess"
     */
    public function processCmdmap($command, $table, $id, $value, &$commandIsProcessed, DataHandler $dataHandler): void
    {
        if ($command == 'delete') {
            $table = array_key_first($dataHandler->cmdmap);
            $elements = $dataHandler->cmdmap[$table];
            foreach ($elements as $key => $element) {
                $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
                $messageQueue = $flashMessageService->getMessageQueueByIdentifier(FlashMessageQueue::NOTIFICATION_QUEUE);
                $message = $this->generateDebugMessage("Prevented deletion of record from table " . $table . " with uid " . $key);
                $messageQueue->addMessage($message);
            }
            $commandIsProcessed = true;
        }
    }

    private function generateDebugMessage(string $message)
    {
        return GeneralUtility::makeInstance(FlashMessage::class,
            $message, "", ContextualFeedbackSeverity::WARNING, true
        );
    }
}
