<?php

namespace Controllers;

use Classes\RSS;
use MVC\Router;
use SimplePie\SimplePie;

class FeedController {
    public static function index(Router $router){
        $orden = $_GET['filtros'] ?? 'newsDate';
        $busqueda =  $_GET['filtrado'] ?? '';
        $rss = new RSS();

        switch ($orden) {
            case 'newsTitle':
                $datos = $rss->obtenerFeeds($orden);
                break;
            
            case 'categoryName':
                $datos = $rss->obtenerFeeds($orden);
                break;
            
            default:
                $datos = $rss->obtenerFeeds($orden);
                break;
        }


        if(!empty($busqueda)){
            $datos = $rss->buscarEnFeeds($datos, $busqueda);
        }
        
        if(isset($_SESSION["respuesta"])){
            $errores = $_SESSION["respuesta"]["errores"];
            unset($_SESSION["respuesta"]);
        }

        $router->render("feed/index", [ 
            "titulo" => "Feed",
            "errores" => $errores ?? [],
            "datos" => $datos
        ]);
    }

    public static function agregarFeeds(){
        $texto = $_POST["feeds"];
        
        $regex = '/https?:\/\/\S+/i'; 
        $urls = [];

        if (preg_match_all($regex, $texto, $matches)) {
            $urls = $matches[0];
        }

        if(empty($urls)){
            $_SESSION["respuesta"] = [
                "errores" => ['error' => ['El campo no puede ir vacio.']]
            ];
        }else{
            $rss = new RSS();
            $errores = $rss->guardarFeeds($urls);
            if(!empty($errores)){
                $_SESSION["respuesta"] = [
                    "errores" => $errores
                ];
            }
        }

        header("Location: /");
        exit;
    }
}