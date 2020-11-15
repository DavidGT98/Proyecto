<?php

class Archivo
{
    private $Id;
    private $Peso;
    private $Tipo;
    private $Propietario;

    public function __get($name)
    {
        return $this->$name;
    }
    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __toString()
    {
        return $this->Id . " " . $this->Marca . " " . $this->Modelo . " " . $this->Precio . " " . $this->Alta . "<br>";
    }
}
