<?php

declare(strict_types=1);

use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:data_handler/Configuration/TsConfig/TCEFORM.tsconfig">');

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
 * DataHandler processCmdmap hooks
 */
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass']['DiscardAction'] =
    \Passionweb\DataHandler\Hooks\DataHandler\ProcessCmdmap\DiscardActionHook::class;