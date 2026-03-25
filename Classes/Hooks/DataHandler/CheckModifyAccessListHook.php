<?php

declare(strict_types=1);

namespace Passionweb\DataHandler\Hooks\DataHandler;

use TYPO3\CMS\Core\DataHandling\DataHandler;
use TYPO3\CMS\Core\DataHandling\DataHandlerCheckModifyAccessListHookInterface;

class CheckModifyAccessListHook implements DataHandlerCheckModifyAccessListHookInterface
{
    /**
     * The hook "recordEditAccessInternals" will be called in vendor/typo3/cms-core/Classes/DataHandling/DataHandler.php
     * line 7349 (TYPO3 13.4.20), look at recordEditAccessInternals
     * @param &$accessAllowed
     * @param $table
     * @param DataHandler $parent
     */
    public function checkModifyAccessList(&$accessAllowed, $table, DataHandler $parent): void
    {
        if ($table === "tx_data_handler_domain_model_codebreak") {
            //enable access for only codebreak_editors or admins
            $accessAllowed = false;
            foreach ($parent->BE_USER->userGroups as $userGroup) {
                if($userGroup['uid'] == 1) {
                    $accessAllowed = true;
                }
            }
            if ($parent->BE_USER->isAdmin()) {
                $accessAllowed = true;
            }
        }
    }
}
