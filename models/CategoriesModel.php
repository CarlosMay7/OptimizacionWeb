<?php

namespace Model;

class CategoriesModel extends ActiveRecord{

    protected static $tabla = 'categories';

    protected static $columnasDB = ['id', "categoryName", "newId"];

    public $id;
    public $categoryName;
    public $newId;
    public $allCategories;
    

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->categoryName = $args['categoryName'] ?? '';
        $this->newId = $args['newId'] ?? null;
    }

    public function crearMultiplesCategorias(){
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES "; 

        foreach ($this->allCategories as $category) {
            $valores[] = "('" . $category->get_label() . "', " . $this->newId . ")";
        }

        $query .= implode(", ", $valores);

        $resultado = self::$db->query($query);
        return [
           'resultado' =>  $resultado,
           'id' => self::$db->insert_id
        ];
    }

    public function validar() {
        if ($this->categoryName == '') {
            self::$alertas['error'][] = 'El nombre de la categoria es obligatorio';
        }
        return self::$alertas;
    }
}