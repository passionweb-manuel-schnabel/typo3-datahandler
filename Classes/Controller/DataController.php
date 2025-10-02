<?php

declare(strict_types=1);

namespace Passionweb\DataHandler\Controller;

use Passionweb\DataHandler\Domain\Model\Codebreak;
use Passionweb\DataHandler\DataHandling\BasicDataHandler;
use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Cache\CacheTag;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

final class DataController extends ActionController
{
    public function cacheAction(?Codebreak $codebreak = null): ResponseInterface
    {
        //Usage of functionality from Codebreak 1 + 2
        $basicDataHandler = new BasicDataHandler();
        $basicDataHandler->basicUsage();

        if($codebreak == null) {
            $codebreak = new Codebreak();
            $codebreak->setTitle('New Codebreak');
            $codebreak->setDescription('Description of new Codebreak');
            $codebreak->setLink('https://passionweb.de');
        }

        $cacheDataCollector = $this->request->getAttribute('frontend.cache.collector');
        $cacheDataCollector->addCacheTags(
            new CacheTag(sprintf('tx_data_handler_domain_model_codebreak', $codebreak->getUid())),
        );

        return $this->htmlResponse();
    }
}
