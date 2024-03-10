<?php

namespace Model;

class NewsModel extends ActiveRecord{

    protected static $tabla = 'news';

    protected static $columnasDB = ['id', 'newsTitle', 'newsUrl', 'newsDescription', 'newsDate', 'feedId'];

    public $id;
    public $newsTitle;
    public $newsUrl;
    public $newsDescription;
    public $newsDate;
    public $feedId;

    public function __construct($args = [])
    {
        $this->id= $args['id'] ?? null;
        $this->newsTitle = $args['newsTitle'] ?? '';
        $this->newsUrl = $args['newsUrl'] ?? '';
        $this->newsDescription = $args['newsDescription'] ?? '';
        $this->newsDate = $args['newsDate'] ?? '';
        $this->feedId = $args['feedId'] ?? null;
              
    }

    public function validar() {
        if ($this->newsTitle == '') {
           self::$alertas['error'][] = 'El titulo no puede estar vacio';
        }
        if ($this->newsUrl == '') {
            self::$alertas['error'][] = 'El link de la noticia es obligatorio';
        }
        if ($this->newsDescription == '') {
            self::$alertas['error'][] = 'La descripcion no puede estar vacio';
        }
        if ($this->newsDate == '') {
            self::$alertas['error'][] = 'La fecha no puede estar vacio';
        }  
        if (!$this->feedId || !filter_var($this->feedId, FILTER_VALIDATE_INT)) {
            self::$alertas['error'][] = 'El feed de la noticia es obligatorio';
        }

        return self::$alertas;
    }
}