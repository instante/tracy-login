<?php

namespace Instante\Tracy\Login\Tests;

use Instante\Tracy\Login\DebugLogin;
use Instante\Tracy\Login\Tests\Mocks\UserDao;
use Nette\Application\Responses\RedirectResponse;
use Nette\Http\Request;
use Nette\Http\Response;
use Nette\Http\Session;
use Nette\Http\UrlScript;
use Nette\Http\UserStorage;
use Nette\Security\User;
use Tester\Assert;

require_once '../bootstrap.php';
require_once '../mocks/loader.php';

const TEST_USER_ID = 123;

$userDao = new UserDao();
$url = new UrlScript('localhost');
$url->setQuery(['id' => TEST_USER_ID]);
$request = new Request($url, null, null, null, null, ['referer' => 'test']);
$response = new Response();

$session = new Session($request, $response);
$userStorage = new UserStorage($session);
$user = new User($userStorage);

$params = [
    'enabled' => true,
    'identifier' => 'email',
];

$debugLogin = new DebugLogin($userDao, $request, $user);
$debugLogin->setConfig($params);


// panel test
Assert::contains('<h1>Sign in as...</h1>', $debugLogin->getPanel());
Assert::contains('<span title="Users">', $debugLogin->getTab());


// login test
$webUser = new \Instante\Tracy\Login\Tests\Mocks\User(TEST_USER_ID, [], ['email' => 'webuser@test.test']);

$loginMethod = DebugLogin::login();

/** @var RedirectResponse $result */
$result = $loginMethod($userDao, $user, $request);

Assert::type(RedirectResponse::class, $result);
Assert::equal($result->getUrl(), 'test');
Assert::equal($result->getCode(), 302);
Assert::true($user->isLoggedIn());
Assert::equal($user->getId(), $webUser->getId());


// logout test
$logoutMethod = DebugLogin::logout();
$logoutMethod($user, $request);

Assert::type(RedirectResponse::class, $result);
Assert::equal($result->getUrl(), 'test');
Assert::equal($result->getCode(), 302);
Assert::false($user->isLoggedIn());
