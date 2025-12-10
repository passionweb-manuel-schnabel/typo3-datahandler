<?php

declare(strict_types=1);

namespace Passionweb\DataHandler\Hooks\DataHandler\ProcessDatamap;

use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class PostProcessFieldArrayHook
{
    /**
     * The hook "processDatamap_postProcessFieldArray" will be called in vendor/typo3/cms-core/Classes/DataHandling/DataHandler.php
     * line 832 (TYPO3 13.4.20), look at processDatamap_postProcessFieldArray
     */
    public function processDatamap_postProcessFieldArray(string $status, string $table, string $id, array &$fieldArray, DataHandler $dataHandler): void
    {
        if ($table === 'tx_data_handler_domain_model_codebreak') {

            if ($status === 'update') {
                $this->generateInfoMessage("Updating Content with uid " . $id);

            } else if ($status === 'new') {
                $mstring = "Inserting new Codebreak.";
                foreach ($fieldArray as $field)
                    if (str_contains($field['description'], "Codebreak") || strlen($field['description']) < 20) {
                        $this->generateInfoMessage($mstring);
                    } else {
                        $this->generateInfoMessage($mstring . " Please provide a informative, Codebreak related description");
                    }
            } else {
                $this->generateInfoMessage("Element with unknown status provided");
            }
        }
    }

    private function generateInfoMessage(string $message)
    {
        return GeneralUtility::makeInstance(FlashMessage::class,
            $message, "", ContextualFeedbackSeverity::WARNING, true
        );
    }
}
