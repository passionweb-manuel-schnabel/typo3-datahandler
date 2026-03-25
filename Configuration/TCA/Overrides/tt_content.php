<?php

use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

$pluginKey = ExtensionUtility::registerPlugin(
    'DataHandler',
    'DataHandler',
    'LLL:EXT:data_handler/Resources/Private/Language/locallang_db.xlf:plugin.dataHandler',
    'tx-passionweb'
);

// Add FlexForm to a CType (example: "text")
$GLOBALS['TCA']['tt_content']['types']['text']['showitem'] .= '
    ,pi_flexform
';

// Register the FlexForm XML file
ExtensionManagementUtility::addPiFlexFormValue(
    '*',
    'FILE:EXT:data_handler/Configuration/FlexForms/ExampleFlexForm.xml',
    'text'
);