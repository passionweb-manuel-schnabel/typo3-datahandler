<?php


declare(strict_types=1);

namespace Passionweb\DataHandler\Hooks\DataHandler\ProcessDatamap;

use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class AfterDatabaseOperationsHook
{
    /**
     * The hook "processDatamap_afterDatabaseOperations" will be called in vendor/typo3/cms-core/Classes/DataHandling/DataHandler.php
     * line 629 (TYPO3 13.4.20), look at processDatamap_afterDatabaseOperations
     */
    public function processDatamap_afterDatabaseOperations(string $status, string $table, string $id, array $fieldArray): void
    {
        if ($table === 'tx_data_handler_domain_model_codebreak') {
            if($status === "update"){
                $method = "Updating codebreak record with ID " . $id . ".";
            }
            else if ($status === "new"){
                $method = "Inserting new codebreak record with ID " . $id . ".";
            }
            else {
                $method = "Using ". $status ." to process codebreak record with ID " . $id . ".";
            }
            $message = $this->generateInfoMessage($method);
            $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
            $messageQueue = $flashMessageService->getMessageQueueByIdentifier();
            $messageQueue->addMessage($message);
        }
    }

    private function generateInfoMessage(string $message)
    {
        return GeneralUtility::makeInstance(FlashMessage::class,
            $message, "", ContextualFeedbackSeverity::WARNING, true
        );
    }
}
