<?php

declare(strict_types=1);

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

ExtensionUtility::configurePlugin(
    'DataHandler',
    'DataHandler',
    [
        \Passionweb\DataHandler\Controller\DataController::class => 'cache'
    ],
    [
        \Passionweb\DataHandler\Controller\DataController::class => 'cache'
    ]
);

/**
 * DataHandler processDatamap hooks
 */
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['BeforeStart'] =
    \Passionweb\DataHandler\Hooks\DataHandler\ProcessDatamap\BeforeStartHook::class;

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['PreProcessFieldArray'] =
    \Passionweb\DataHandler\Hooks\DataHandler\ProcessDatamap\PreProcessFieldArrayHook::class;

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['PostProcessFieldArray'] =
    \Passionweb\DataHandler\Hooks\DataHandler\ProcessDatamap\PostProcessFieldArrayHook::class;

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['AfterDatabaseOperations'] =
    \Passionweb\DataHandler\Hooks\DataHandler\ProcessDatamap\AfterDatabaseOperationsHook::class;

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['CheckRecordUpdateAccess'] =
    \Passionweb\DataHandler\Hooks\DataHandler\ProcessDatamap\CheckRecordUpdateAccess::class;
