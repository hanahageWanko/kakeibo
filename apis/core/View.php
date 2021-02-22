<?php
class View
{
    public static function make($view, $model, $controller)
    {
        if (Route::isRouteValid()) {
            if(!$model) {
              $model = $view;
            }
            if(!$controller) {
              $controller = $view;
            }
            require_once(__DIR__ . "/../controllers/$controller.php");
            require_once(__DIR__ . "/../models/$model.php");
            require_once(__DIR__ . "/../views/$view.php");
            return 1;
        }
    }
}
