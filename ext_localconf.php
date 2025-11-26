<?php

declare(strict_types=1);

use Passionweb\DataHandler\Hooks\DataHandler\AfterAllOperations;
use Passionweb\DataHandler\Hooks\DataHandler\AfterDatabaseAction;
use Passionweb\DataHandler\Hooks\DataHandler\AfterFinish;
use Passionweb\DataHandler\Hooks\DataHandler\BeforeStart;
use Passionweb\DataHandler\Hooks\DataHandler\PostProcess;
use Passionweb\DataHandler\Hooks\DataHandler\PreProcess;
use Passionweb\DataHandler\Hooks\DataHandler\ProcessCmdmap;
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

$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['AfterAllOperations'] =
    AfterAllOperations::class;
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['AfterDatabaseAction'] =
    AfterDatabaseAction::class;