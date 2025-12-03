<?php


declare(strict_types=1);

namespace Passionweb\DataHandler\Hooks\DataHandler\ProcessDatamap;

use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class AfterAllOperationsHook
{
    /**
     * The hook "processDatamap_afterAllOperations" will be called in vendor/typo3/cms-core/Classes/DataHandling/DataHandler.php
     * line 993 (TYPO3 13.4.20), look at processDatamap_afterAllOperations
     */
    public function processDatamap_afterAllOperations(DataHandler $dataHandler): void
    {
        if (isset($dataHandler->datamap)) {
            if(array_key_exists('tx_data_handler_domain_model_codebreak', $dataHandler->datamap)) {
                // Do something with the codebreak records if needed

                foreach ($dataHandler->datamap['tx_data_handler_domain_model_codebreak'] as $uid => $record) {
                    if($record['link'] == ""){
                        $dataHandler->datamap['tx_data_handler_domain_model_codebreak'][$uid]['link'] = "https://passionweb.de";
                        $dataHandler->start($dataHandler->datamap, []);
                        $dataHandler->process_datamap();

                        $str = "Default link set for codebreak record with title: " . $record['title'] . "and uid: " . $uid;
                        $message = $this->generateInfoMessage($str);
                        $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
                        $messageQueue = $flashMessageService->getMessageQueueByIdentifier();
                        $messageQueue->addMessage($message);
                    }
                }
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
