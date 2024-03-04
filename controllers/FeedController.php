<?php

namespace Controllers;

use Classes\RSS;
use MVC\Router;

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
            $errores = $_SESSION["respuesta"]["errores"] ?? [];
            $urlsValidas = $_SESSION["respuesta"]["feeds"] ?? [];
            unset($_SESSION["respuesta"]["errores"]);
        }

        $router->render("feed/index", [ 
            "titulo" => "Feed",
            "orden" => $orden,
            "busqueda" => $busqueda,
            "urls" => $urlsValidas ?? [],
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
                "errores" => ['error' => ['Llene el campo con una url válida.']]
            ];
        }else{
            $rss = new RSS();
            $respuesta = $rss->guardarFeeds($urls);
            $errores = $respuesta["alertas"];
            $_SESSION["respuesta"] = [
                "feeds" => $respuesta["feeds"]
            ];

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