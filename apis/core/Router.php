<?php
class Router
{
    public static function isRouteValid()
    {
        global $Routes;
        $uri = $_SERVER['REQUEST_URI'];
        if (!in_array(explode('?', $uri)[0], $Routes, true)) {
            return false;
        } else {
            return true;
        }
    }

    // Register the route in a global variable.
    private static function registerRoute($route)
    {
        global $Routes;
        $Routes[] = "/".$route;
    }
    // Dynamic routing
    public static function dyn($dyn_routes)
    {
        $route_components = explode('/', $dyn_routes);
        $uri_components = explode('/', substr($_SERVER['REQUEST_URI'], strlen(__DIR__)-1));
        for ($i = 0; $i < count($route_components); $i++) {
            if ($i+1 <= count($uri_components)-1) {
                $route_components[$i] = str_replace("<$i>", $uri_components[$i+1], $route_components[$i]);
            }
        }
        $route = implode($route_components, array('/'));
        return $route;
    }

    public static function set($route, $closure)
    {
        // TODO: 例外処理

        if (!$_GET) {
            self::registerRoute($route);
            $closure->__invoke();
            return;
        }
        if ($_SERVER['REQUEST_URI'] == "/".$route) {
            self::registerRoute($route);
            $closure->__invoke();
            return;
        }
        if (explode('?', $_SERVER['REQUEST_URI'])[0] == "/".$route) {
            self::registerRoute($route);
            $closure->__invoke();
            return;
        }
        if ($_GET['url'] == explode('/', $route)[0]) {
            self::registerRoute(self::dyn($route));
            $closure->__invoke();
            return;
        }
    }

    public static function get()
    {
        global $Routes;
        $uri = $_SERVER['REQUEST_URI'];
        if (!in_array(explode('?', $uri)[0], $Routes, true)) {
            die('Invalid route.');
        }
        return $uri;
    }

    public function run()
    {
        $this->get();
    }
}
