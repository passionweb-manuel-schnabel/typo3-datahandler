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
