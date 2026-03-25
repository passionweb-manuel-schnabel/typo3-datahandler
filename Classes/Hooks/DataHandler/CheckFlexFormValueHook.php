<?php

declare(strict_types=1);

namespace Passionweb\DataHandler\Hooks\DataHandler;

use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Exception;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class CheckFlexFormValueHook
{
    /**
     * Hook "checkFlexFormValue_beforeMerge" is called in DataHandler.php
     * line ~2440 (TYPO3 13.4) before new FlexForm values are merged
     * with existing values via ArrayUtility::mergeRecursiveWithOverrule().
     *
     * Use case: Enforce that "Enable Feature" can only be activated
     * when category "A" is selected. If the rule is violated, the
     * checkbox value is reset to 0 and a backend flash message is shown.
     *
     * @param DataHandler $dataHandler The DataHandler instance
     * @param array &$currentValueArray Current FlexForm values from the database
     * @param array &$newValueArray Newly submitted FlexForm values (will be merged on top)
     * @throws Exception
     */
    public function checkFlexFormValue_beforeMerge(
        DataHandler $dataHandler,
        array &$currentValueArray,
        array &$newValueArray,
    ): void {
        // The new values contain the submitted FlexForm data in the structure:
        // data > sDEF > lDEF > settings.fieldName > vDEF
        $fields = $newValueArray['data']['sDEF']['lDEF'] ?? [];

        $category = $fields['settings.category']['vDEF'] ?? '';
        $enableFeature = (bool)($fields['settings.enableFeature']['vDEF'] ?? false);

        // "Enable Feature" is only allowed when category is "A"
        if ($enableFeature && $category !== 'A') {
            // Reset the checkbox in the new values before the merge happens
            $newValueArray['data']['sDEF']['lDEF']['settings.enableFeature']['vDEF'] = '0';

            // Notify the editor in the backend
            $flashMessage = GeneralUtility::makeInstance(
                FlashMessage::class,
                '"Enable Feature" can only be activated when category "A" is selected. The value has been reset.',
                'Invalid FlexForm configuration',
                ContextualFeedbackSeverity::WARNING,
                true,
            );

            GeneralUtility::makeInstance(FlashMessageService::class)
                ->getMessageQueueByIdentifier()
                ->enqueue($flashMessage);
        }
    }
}
