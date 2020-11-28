<?php
require_once("models/archivo.php");
require_once("libreriaPDOCLA.php");

class archivosDAO extends ConBase
{
    /*     private $con; */

    public $Archivos;

    /*     public function __construct()
    {
        $this->con = new ConBase("ejemplo");
    }
 */
    public function Insertar($Archivo)
    {
        $consulta = "INSERT into ficheros values(:id,:peso,:tipo,:propietario)";
        $param = array(":id" => $Archivo->__GET("Id"), ":peso" => $Archivo->__GET("Peso"),  ":tipo" => $Archivo->__GET("Tipo"), ":propietario" => $Archivo->__GET("Propietario"));
        /*         foreach ($param as $key => $value) {
            echo "clave: ". $key . " valor: " . $value;
        } */
        $this->ConsultaSimple($consulta, $param);
    }

    public function Actualizar($Archivo)
    {
        $consulta = "UPDATE ficheros SET Peso = :peso, Tipo = :tipo, Propietario = :propietario WHERE Id = :id";
        $param = array(":id" => $Archivo->__GET("Id"), ":peso" => $Archivo->__GET("Peso"),  ":tipo" => $Archivo->__GET("Tipo"), ":propietario" => $Archivo->__GET("Propietario"));
        $this->ConsultaSimple($consulta, $param);
    }

    public function Buscar($id, $propietario)
    {
        $consulta = "SELECT * FROM ficheros WHERE Id = :id AND Propietario = :propietario";
        $Archivo = new Archivo();

        $param = array(":id" => $id, ":propietario" => $propietario);
        $this->ConsultaDatos($consulta, $param);

        if (!empty($this->filas)) {
            $fila = $this->filas[0];
            $Archivo->__set("Id", $fila['Id']);
            $Archivo->__set("Peso", $fila['Peso']);
            $Archivo->__set("Tipo", $fila['Tipo']);
            $Archivo->__set("Propietario", $fila['Propietario']);
        }

        return $Archivo;
    }

    public function Eliminar($id, $propietario)
    {

        $consulta = "DELETE from ficheros where Id=:id AND Propietario = :propietario";
        $consulta = "DELETE FROM `ficheros` WHERE `ficheros`.`Id` = :id AND `ficheros`.`Propietario` = :propietario ";

        $param = array(
            ":id" => $id, ":propietario" => $propietario
        );
        /* echo $consulta; */

        $this->ConsultaSimple($consulta, $param);
    }

    public function Listar()
    {
        $this->Archivos = array();

        $consulta = "SELECT * from ficheros";

        $param = array();

        $this->ConsultaDatos($consulta, $param);

        foreach ($this->filas as $fila) {
            $Archivo = new Archivo();

            $Archivo->__set("Id", $fila['Id']);
            $Archivo->__set("Peso", $fila['Peso']);
            $Archivo->__set("Tipo", $fila['Tipo']);
            $Archivo->__set("Propietario", $fila['Propietario']);
            $this->Archivos[] = $Archivo;
        }
        /* return $Archivos; */
    }
}
