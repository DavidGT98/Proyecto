<?php

class Usuario
{
    private $Nombre;
    private $Clave;
    private $Email;
    private $Administrador;
    private $Usado;

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
        return $this->Nombre . " " . $this->Clave . " " . $this->Email . " " . $this->Administrador . " " . $this->Usado . "<br>";
    }
}
