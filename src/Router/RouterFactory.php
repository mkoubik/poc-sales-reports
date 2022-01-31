<?php

declare(strict_types=1);

namespace App\Router;

use Nette\Application\Routers\Route;

final class RouterFactory
{
    public static function create(): Route
    {
        return new Route('<presenter>/<action>[/<id>]', 'Homepage:default');
    }
}
