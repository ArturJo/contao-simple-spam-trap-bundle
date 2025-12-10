<?php

namespace SolidWork\ContaoSimpleSpamTrapBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use SolidWork\ContaoSimpleSpamTrapBundle\ContaoSimpleSpamTrapBundle;

class Plugin implements BundlePluginInterface
{
    public function getBundles(BundleConfig $config)
    {
        return [
            BundleConfig::create(ContaoSimpleSpamTrapBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class])
        ];
    }
}
