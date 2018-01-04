<?php

namespace Instante\Tracy\Login;

use Latte\Engine;
use Nette\Application\IRouter;
use Nette\Application\Responses\RedirectResponse;
use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;
use Nette\Http\Request;
use Nette\InvalidArgumentException;
use Nette\Security\User;
use Tracy\IBarPanel;

class DebugLogin implements IBarPanel
{
    const ROUTE_LOGIN = 'debugExtensionLogin';
    const ROUTE_LOGOUT = 'debugExtensionLogout';

    /** @var IUserDao */
    private $userDao;

    /** @var Request */
    private $request;

    /** @var User */
    private $user;

    /** @var array */
    private $identifiers;

    /**
     * @param IUserDao $userDao
     * @param Request $request
     * @param User $user
     */
    public function __construct(IUserDao $userDao, Request $request, User $user)
    {
        $this->userDao = $userDao;
        $this->request = $request;
        $this->user = $user;
    }

    public static function login()
    {
        return function (
            IUserDao $userDao,
            User $user,
            Request $request
        ) {
            $id = $request->getQuery('id');

            $userEntity = $userDao->find($id);

            if ($userEntity) {
                $user->logout();
                $user->login($userEntity);
            }

            return new RedirectResponse($request->getReferer()->path);
        };
    }

    public static function logout()
    {
        return function (
            User $user,
            Request $request
        ) {
            $user->logout(TRUE);
            return new RedirectResponse($request->getReferer()->path);
        };
    }

    /**
     * Renders HTML code for custom tab.
     * @return string
     */
    function getTab()
    {
        $engine = new Engine();
        ob_start();
        $engine->render(__DIR__ . '/templates/tab.latte', []);
        return ob_get_clean();
    }

    /**
     * Renders HTML code for custom panel.
     * @return string
     */
    function getPanel()
    {
        $users = $this->userDao->findAll();

        $engine = new Engine();
        ob_start();
        $engine->render(__DIR__ . '/templates/panel.latte', [
            'users' => $users,
            'identifiers' => $this->getIdentifiersMethodName(),
            'currentId' => $this->user->getId(),
            'basePath' => $this->request->getUrl()->getBasePath(),
            'loginRoute' => self::ROUTE_LOGIN,
            'logoutRoute' => self::ROUTE_LOGOUT,
        ]);
        return ob_get_clean();
    }

    public function setConfig($params)
    {
        $this->identifiers = is_array($params['identifier']) ? $params['identifier'] : [$params['identifier']];
    }

    private function getIdentifiersMethodName()
    {
        return array_map(function ($identifier) {
            return 'get' . ucfirst($identifier);
        }, $this->identifiers);
    }

    /**
     * @param IRouter $router
     *
     * @throws \Exception
     */
    public static function addRoutes(IRouter &$router)
    {
        if (!$router instanceof RouteList || $router->getModule()) {
            throw new InvalidArgumentException(
                'If you want to use Instante\DebugLogin then your main router ' .
                'must be an instance of Nette\Application\Routers\RouteList without module'
            );
        }

        $router[] = new Route('tmp'); // need to increase the array size by 2
        $router[] = new Route('tmp');

        $lastKey = count($router) - 2;
        foreach ($router as $i => $route) {
            if ($i === $lastKey) {
                break;
            }
            $router[$i + 2] = $route;
        }

        $router[0] = new Route(self::ROUTE_LOGIN, self::login());
        $router[1] = new Route(self::ROUTE_LOGOUT, self::logout());
    }
}
