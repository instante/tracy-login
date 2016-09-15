<?php

namespace Instante\Tracy\Login\Tests;

use Instante\Tracy\Login\DI\DebugLoginExtension;
use Tester\Assert;

require_once '../bootstrap.php';

/** Environment test */
$params = [
    'environment' => 'development',
    'debugMode' => false
];
Assert::true(DebugLoginExtension::isDebugEnvironment($params));

$params = [
    'environment' => 'production',
    'debugMode' => false
];
Assert::false(DebugLoginExtension::isDebugEnvironment($params));

$params = [
    'debugMode' => false
];
Assert::false(DebugLoginExtension::isDebugEnvironment($params));

$params = [
    'debugMode' => true
];
Assert::true(DebugLoginExtension::isDebugEnvironment($params));
