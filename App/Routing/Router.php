<?php

declare(strict_types=1);

namespace App\Routing;

use App\Controller\Controller;
use App\Controller\Error404;
use App\Controller\Game;
use App\Controller\Motus;

class Router
{
    private array $routes = [
        '/' => Motus::class,
        '/404' => Error404::class,
        '/game' => Game::class,
    ];

    private static string $path;

    private static ?Router $router = null;
    // private static ?array $user = null;

    private function __construct()
    {
        self::$path = $_SERVER['PATH_INFO'] ?? '/';
        // self::$user = $_SESSION['user'] ?? null;
    }

    public static function getFromGlobals(): self
    {
        if (null === self::$router) {
            self::$router = new self();
        }

        return self::$router;
    }

    public function getController(): Controller
    {
        $controllerClass = $this->routes[self::$path] ?? $this->routes['/404'];
        $controller = new $controllerClass();

        if (!$controller instanceof Controller) {
            throw new \LogicException("controller $controllerClass should implement ".Controller::class);
        }

        return $controller;
    }

    /*public static function getUser(): ?array
    {
        return self::$user;
    }*/
}
