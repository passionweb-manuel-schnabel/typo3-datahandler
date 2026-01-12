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

class PreProcessHook
{
    /**
     * The hook "ProcessCmdmap_preProcess" will be called in vendor/typo3/cms-core/Classes/DataHandling/DataHandler.php
     * line 3333 (TYPO3 13.4.20), search for "ProcessCmdmap_preProcess"
     */
    public function processCmdmap_preProcess(string $command, string &$table, string $id, string $value, DataHandler $dataHandler, $pasteUpdate): void
    {
        if (!$dataHandler->cmdmap) {
            return;
        }
        if (count($dataHandler->cmdmap) === 0) {
            return;
        }
        if ($table = 'tx_data_handler_domain_model_codebreak' && !$this->getBackendUser()->isAdmin()){
            $message = $this->generateDebugMessage('Only admins can access/copy codebreak elements');
            $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
            $messageQueue = $flashMessageService->getMessageQueueByIdentifier(FlashMessageQueue::NOTIFICATION_QUEUE);
            $messageQueue->addMessage($message);
            $table = '';
        }
    }

    private function generateDebugMessage(string $message)
    {
        return GeneralUtility::makeInstance(FlashMessage::class,
            $message, "", ContextualFeedbackSeverity::WARNING, true
        );
    }

    /**
     * Returns the current BE user.
     */
    private function getBackendUser(): BackendUserAuthentication
    {
        return $GLOBALS['BE_USER'];
    }
}
