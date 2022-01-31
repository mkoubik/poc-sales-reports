<?php

declare(strict_types=1);

namespace App;

use Nette\Bootstrap\Configurator;

class Bootstrap
{
    public static function boot(): Configurator
    {
        $configurator = new Configurator();
        $configurator->addConfig(__DIR__ . '/../config.neon');

        $configurator->setDebugMode(true);
        $configurator->enableTracy(__DIR__ . '/../var/log');

        $configurator->setTempDirectory(__DIR__ . '/../var/temp');

        return $configurator;
    }
}
