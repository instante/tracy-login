<?php

namespace Instante\Tracy\Login\Tests;

use Instante\Tracy\Login\DebugLogin;
use Nette\Application\Routers\RouteList;
use Tester\Assert;

require_once '../bootstrap.php';

$router = new RouteList();
DebugLogin::addRoutes($router);
Assert::equal($router[0]->getMask(), DebugLogin::ROUTE_LOGIN);
Assert::equal($router[1]->getMask(), DebugLogin::ROUTE_LOGOUT);
