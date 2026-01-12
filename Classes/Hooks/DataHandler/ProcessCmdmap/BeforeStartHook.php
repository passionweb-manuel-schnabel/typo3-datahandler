<?php

declare(strict_types=1);

namespace Passionweb\DataHandler\Hooks\DataHandler\ProcessCmdmap;

use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageQueue;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class BeforeStartHook
{
    /**
     * The hook "ProcessCmdmap_beforeStart" will be called in vendor/typo3/cms-core/Classes/DataHandling/DataHandler.php
     * line 3280 (TYPO3 13.4.20), search for "ProcessCmdmap_beforeStart"
     */
    public function ProcessCmdmap_beforeStart(DataHandler $dataHandler): void
    {
        if (!$dataHandler->cmdmap) {
            return;
        }
        if (count($dataHandler->cmdmap) === 0) {
            return;
        }
        $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
        $messageQueue = $flashMessageService->getMessageQueueByIdentifier(FlashMessageQueue::NOTIFICATION_QUEUE);
        if (array_key_exists('tt_content', $dataHandler->cmdmap)) {
            foreach ($dataHandler->cmdmap['tt_content'] as $uid => $elem) {
                $action = array_key_first($elem);
                $message = $this->generateDebugMessage('Executing action *' . $action . '* on page with uid ' . $uid);
                $messageQueue->addMessage($message);
            }
        } else if (array_key_exists('pages', $dataHandler->cmdmap)) {
            foreach ($dataHandler->cmdmap['pages'] as $uid => $elem) {
                $action = array_key_first($elem);
                $message = $this->generateDebugMessage('Executing action *' . $action . '* for page with uid ' . $uid);
                $messageQueue->addMessage($message);
            }
        } else {
            $message = $this->generateDebugMessage('Executing action for other entry');
            $messageQueue->addMessage($message);
        }
    }

    private function generateDebugMessage(string $message)
    {
        return GeneralUtility::makeInstance(FlashMessage::class,
            $message, "", ContextualFeedbackSeverity::WARNING, true
        );
    }
}
