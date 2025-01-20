<?php

namespace app\classes;

class Tag {
    public $id;
    private $name;
    
    public function __construct($id=null, $name) {
            $this->id = $id;
            $this->name = $name;
    }

    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }


    public function setNom($name) {
        $this->name = $name;
    }

}