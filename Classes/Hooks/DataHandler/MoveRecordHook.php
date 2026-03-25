<?php

declare(strict_types=1);

namespace Passionweb\DataHandler\Hooks\DataHandler;

use Psr\Log\LoggerInterface;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class MoveRecordHook
{

    /**
     * Called BEFORE the record is moved (line ~4652 in TYPO3 13.4).
     * Allows intercepting or fully replacing the move operation.
     * If $recordWasMoved is set to true, the DataHandler skips its default move logic.
     *
     * @param string $table Table name of the record being moved
     * @param int $uid UID of the record being moved
     * @param int $destPid Destination (>=0 = target page ID, <0 = "after record with this UID")
     * @param array $propArr Properties of the record (header, pid, event_pid, t3ver_state)
     * @param array $moveRec Move placeholder record properties
     * @param int $resolvedPid The resolved target page ID
     * @param bool &$recordWasMoved Set to true to prevent the default move logic
     * @param DataHandler $dataHandler The DataHandler instance
     */
    public function moveRecord(
        string $table,
        int $uid,
        int $destPid,
        array $propArr,
        array $moveRec,
        int $resolvedPid,
        bool &$recordWasMoved,
        DataHandler $dataHandler,
    ): void {
        $this->generateInfoMessage('Record move initiated! ', [
            'table' => $table,
            'uid' => $uid,
            'sourcePid' => $propArr['pid'] ?? 0,
            'destinationPid' => $destPid,
            'resolvedPid' => $resolvedPid,
        ]);
    }

    /**
     * Called AFTER the record was moved as the first element on a page
     * (destination >= 0, line ~4716 in TYPO3 13.4).
     *
     * @param string $table Table name
     * @param int $uid UID of the moved record
     * @param int $destinationPid Target page ID
     * @param array $moveRec Move record properties
     * @param array $updateFields Fields that were updated (pid, sorting, tstamp)
     * @param DataHandler $dataHandler The DataHandler instance
     */
    public function moveRecord_firstElementPostProcess(
        string $table,
        int $uid,
        int $destinationPid,
        array $moveRec,
        array $updateFields,
        DataHandler $dataHandler,
    ): void {
        $this->generateInfoMessage('Record moved as first element on page! ', [
            'table' => $table,
            'uid' => $uid,
            'targetPid' => $destinationPid,
            'updatedFields' => implode(", ", $updateFields),
        ]);
    }

    private function generateInfoMessage(string $message, array $params = [])
    {
        $symbol = ": ";
        $info = implode(", ", array_map(
                function($k, $v) use($symbol) {
                    return $k . $symbol . $v;
                },
                array_keys($params),
                array_values($params)
            )
        );

        $infoMessage = GeneralUtility::makeInstance(FlashMessage::class,
            $message . $info, "", ContextualFeedbackSeverity::INFO, true
        );

        $flashMessageService = GeneralUtility::makeInstance(FlashMessageService::class);
        $messageQueue = $flashMessageService->getMessageQueueByIdentifier();
        $messageQueue->addMessage($infoMessage);
    }
}
