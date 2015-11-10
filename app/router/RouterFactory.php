<?php
namespace App;

use Nette;
use Nette\Application\Routers\RouteList;
use Nette\Application\Routers\Route;

/**
 * Router factory.
 */
class RouterFactory
{
    /**
    * @return \Nette\Application\IRouter
    */
    public static function createRouter()
    {
        $router = new RouteList();
        $router[] = new Route('<presenter>/<action>[/<id>]', 'Task:default');
        return $router;
    }
}
