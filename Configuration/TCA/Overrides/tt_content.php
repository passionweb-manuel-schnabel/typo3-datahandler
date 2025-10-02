<?php

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

$pluginKey = ExtensionUtility::registerPlugin(
    'DataHandler',
    'DataHandler',
    'LLL:EXT:data_handler/Resources/Private/Language/locallang_db.xlf:plugin.dataHandler',
    'tx-passionweb'
);