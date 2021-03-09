<?php
class View
{
    public static function make($view, $model = null, $controller = null)
    {
        if (Router::isRouteValid()) {
            if ($model) {
                require_once(__DIR__ . "/../models/$model.php");
            }
            if ($controller) {
                require_once(__DIR__ . "/../controllers/$controller.php");
            }
            require_once(__DIR__ . "/../views/$view.php");
            return 1;
        }
    }
}
