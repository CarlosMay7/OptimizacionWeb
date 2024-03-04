<?php 

namespace Model;

class FeedsModel extends ActiveRecord{

    protected static $tabla = 'feeds';

    protected static $columnasDB = ['id', 'feedName', 'feedUrl', 'feedIcon'];

    public $id;
    public $feedName;
    public $feedUrl;
    public $feedIcon;


    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->feedName = $args['feedName'] ?? '';
        $this->feedUrl = $args['feedUrl'] ?? '';
        $this->feedIcon = $args['feedIcon'] ?? '';
    }

    public function validar() {
        if ($this->feedName == '') {
            self::$alertas['error'][] = 'El nombre del feed no puede estar vacio';
        }
        if ($this->feedUrl == '') {
               self::$alertas['error'][] = 'La url del feed no puede estar vacio';
        }
        return self::$alertas;
    }
}