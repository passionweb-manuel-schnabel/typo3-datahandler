<?php

declare(strict_types=1);

namespace Passionweb\DataHandler\Hooks\DataHandler;

use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageQueue;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class AfterFinish
{
    public function processDatamap_afterFinish(array $fieldArray, string $table, string $id, DataHandler $dataHandler): void
    {
        $output = null;
        $result_code = null;
        $cmd = getcwd();
        exec("../bin/typo3 cache:flush", $output, $result_code);

        $message = GeneralUtility::makeInstance(
            FlashMessage::class,
            "Operations finished",
            "Cache flushed with Status ".$result_code.".\n",
            ContextualFeedbackSeverity::INFO,
            true
        );

        $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
        $messageQueue = $flashMessageService->getMessageQueueByIdentifier(FlashMessageQueue::NOTIFICATION_QUEUE);
        $messageQueue->enqueue($message);
    }
}