<?php

declare(strict_types=1);

use TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider;

return [
    'tx-passionweb' => [
        'provider' => SvgIconProvider::class,
        'source' => 'EXT:data_handler/Resources/Public/Icons/Extension.svg',
    ]
];
