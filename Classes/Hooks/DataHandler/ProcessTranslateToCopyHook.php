<?php

declare(strict_types=1);

namespace Passionweb\DataHandler\Hooks\DataHandler;

use phpDocumentor\Reflection\PseudoTypes\ShapeItem;
use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Messaging\FlashMessageService;
use TYPO3\CMS\Core\Type\ContextualFeedbackSeverity;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ProcessTranslateToCopyHook
{
    /**
     * The hook "processTranslateTo_copyAction" will be called in vendor/typo3/cms-core/Classes/DataHandling/DataHandler.php
     * line 715 (TYPO3 13.4.20), look at processTranslateTo_copyAction
     */
    public function processTranslateTo_copyAction(string &$localizedField, array $siteLanguage, DataHandler $dataHandler, string $fieldToTranslate): void
    {
        //prefix fields with their language identifier
        $suffix = "\nThis text is generated automatically for " . $siteLanguage['title'] . " (" . $siteLanguage['uid'] . "). Please note there might be inconsistencies in translation.";
        if($fieldToTranslate == "bodytext") {
            $localizedField = substr($localizedField, 0, strlen($localizedField) - 4) . $suffix . "</p>";
        }
    }
}
