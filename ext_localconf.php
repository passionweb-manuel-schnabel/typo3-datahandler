<?php

declare(strict_types=1);

use Passionweb\DataHandler\Hooks\AfterDatabaseActionDataHandler;
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

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['data-handler'] =
    AfterDatabaseActionDataHandler::class;