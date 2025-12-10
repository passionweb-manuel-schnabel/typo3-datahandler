<?php


declare(strict_types=1);

namespace Passionweb\DataHandler\Hooks\DataHandler\ProcessDatamap;

use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class CheckRecordUpdateAccess
{
    /**
     * The hook "processDatamap_afterAllOperations" will be called in vendor/typo3/cms-core/Classes/DataHandling/DataHandler.php
     * line 993 (TYPO3 13.4.20), look at processDatamap_afterAllOperations
     */
    public function checkRecordUpdateAccess(string $table, string $id, array &$incomingFieldArray, &$recordAccess, DataHandler $dataHandler): null | \Exception
    {
        $user = $dataHandler->userid;
        $allowedUsers = [3, 4, 6, 12, 13]; //list of allowed users
        if(in_array($user, $allowedUsers)) {
            return null;
        }
        else {
            $m = $this->generateErrorMessage();
            $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
            $messageQueue = $flashMessageService->getMessageQueueByIdentifier();
            $messageQueue->addMessage($m);
            return new \Exception("Denied access.");
        }
    }

    private function generateErrorMessage()
    {
        return GeneralUtility::makeInstance(FlashMessage::class,
            "You are not allowed to edit this record. Please contact an admin.", "", ContextualFeedbackSeverity::ERROR, true
        );
    }
}
