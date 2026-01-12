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
 * DataHandler processCmdmap hooks
 */
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass']['DeleteAction'] =
    \Passionweb\DataHandler\Hooks\DataHandler\ProcessCmdmap\DeleteActionHook::class;