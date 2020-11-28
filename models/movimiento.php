<?php

class Movimiento
{
    private $Usuario;
    private $Fecha;
    private $Tipo;
    private $Cantidad;
    private $Fichero;

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
        return $this->Usuario . " " . $this->Fecha . " " . $this->Tipo . " " . $this->Cantidad . " " . $this->Fichero . "<br>";
    }
}
