<?php

namespace Classes;

use Model\ActiveRecord;
use Model\CategoriesModel;
use Model\FeedsModel;
use Model\NewsModel;
use SimplePie\SimplePie;

class RSS {
    public function guardarFeeds($feedsTextArea){
        $feedsURL = $this->instanciarSimplePie($feedsTextArea);
        $feedsValidos = [];

        CategoriesModel::eliminarTodo();
        NewsModel::eliminarTodo();
        FeedsModel::eliminarTodo();
        $alertas = [];
        $respuestaGuardarFeeds = [];

        foreach($feedsURL as $feedURL){
            $feedsModel = new FeedsModel();
            $feedsModel->feedName = $feedURL->get_title();
            $feedsModel->feedUrl = $feedURL->get_permalink();
            if ($feedURL->get_image_url()) {
                $feedsModel->feedIcon = $feedURL->get_image_url();
            } else {
                $feedsModel->feedIcon = '';
            }

            $exists = FeedsModel::where('feedUrl', $feedURL->get_permalink());  
            if ($exists || $feedsModel->validar()) {
                $alertas['error'][] = 'Oops no se pudo agregar el feed: ' . $feedsModel->feedUrl;
                continue;
            } else {
                $feedsValidos[] = $feedURL->get_permalink();
            }

            $resultadoFeed = $feedsModel->guardar();
            foreach ($feedURL->get_items() as $item) {
                $newsModel = new NewsModel();
                $categoriesModel = new CategoriesModel();

                // Título de la noticia
                $newsModel->newsTitle = $item->get_title();

                //Fecha de la noticia
                $newsModel->newsDate = $item->get_date('j F Y, g:i a');
                
                // URL de la noticia
                $newsModel->newsUrl = $item->get_permalink();
                
                // Descripción de la noticia
                $newsModel->newsDescription = $item->get_description();

                // Cateogrías de la noticia
                $categoriesModel->allCategories = $item->get_categories();

                $newsModel->feedId = $resultadoFeed['id'];
                $resultadoNews = $newsModel->guardar();
                if(!is_null($categoriesModel->allCategories)){
                    $categoriesModel->newId = $resultadoNews['id'];
                    $categoriesModel->crearMultiplesCategorias();
                }
            }
        }

        $respuestaGuardarFeeds["feeds"] = $feedsValidos;
        $respuestaGuardarFeeds["alertas"] = $alertas;
        
        return $respuestaGuardarFeeds;
    }

    public function instanciarSimplePie($feedsTextArea){
        $feedsURL = [];
        foreach($feedsTextArea as $feedURL){
            $feed = new SimplePie();
            $feed->set_feed_url($feedURL); // URL del feed RSS
            $feed->set_curl_options(array(
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_CAINFO => $_ENV["PEM_ARCHIVE"],
            ));
            $feed->enable_cache(false);
            $feed->init();
            $feed->handle_content_type();
            $feedsURL[] = $feed;
        }
        return $feedsURL;
    }

    public function obtenerFeeds($orden){
        $datos = ActiveRecord::consultarDatos($orden);
        $datosFormateados = [];
        foreach($datos as $dato){
            $newId = $dato['newId'];
            
            if (!isset($datosFormateados[$newId])) {
                $dato['allCategories'][] = $dato['categoryName'];
                $datosFormateados[$newId] = $dato;
            }else{
                $datosFormateados[$newId]['allCategories'][] = $dato['categoryName'];
            }
        }

        return $datosFormateados;
    }

    public function buscarEnFeeds($datos, $busqueda){
        $feedsFiltrados = [];
        foreach ($datos as $dato) {
            foreach($dato as $llave => $valor){
                if($llave == 'allCategories'){
                    $valor = implode(", ", $valor);
                }

                if(stripos($valor, $busqueda)){
                    $feedsFiltrados[] = $dato;
                    break;
                }
            }
        }
        return $feedsFiltrados;
    }
}