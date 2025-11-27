<?php

declare(strict_types=1);

namespace Passionweb\DataHandler\Hooks\DataHandler\ProcessDatamap;

use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class PreProcessFieldArrayHook
{
    /**
     * The hook "processDatamap_preProcessFieldArray" will be called in vendor/typo3/cms-core/Classes/DataHandling/DataHandler.php
     * line 715 (TYPO3 13.4.20), look at processDatamap_preProcessFieldArray
     */
    public function processDatamap_preProcessFieldArray(array &$incomingFieldArray, string $table, string $id, DataHandler $dataHandler): void
    {
        $badWords = ['damn', 'shit', 'stupid', 'idiot', 'dumb', 'hate'];
        if ($table === 'tx_data_handler_domain_model_codebreak') {
            if (isset($incomingFieldArray['description'])) {

                $originalContent = $incomingFieldArray['description'];
                $filteredContent = $originalContent;

                foreach ($badWords as $word) {
                    $filteredContent = str_ireplace($word, '****', $filteredContent);
                }

                if ($originalContent !== $filteredContent) {
                    $incomingFieldArray['description'] = $filteredContent;
                    $message = $this->generateInfoMessage('Potentially bad content was detected and removed from the description.');
                    $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
                    $messageQueue = $flashMessageService->getMessageQueueByIdentifier();
                    $messageQueue->addMessage($message);
                }
            }
        }
    }

    private function generateInfoMessage(string $message) {
        return GeneralUtility::makeInstance(FlashMessage::class,
            $message, "",ContextualFeedbackSeverity::WARNING, true
        );
    }
}
