<?php

namespace Controllers;

use MVC\Router;

class FeedController {
    public static function index(Router $router){

        $router->render("feed/index", [ 
            "titulo" => "Feed",
        ]);
    }
}