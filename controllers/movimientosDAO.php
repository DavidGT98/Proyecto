<?php
require_once("models/movimiento.php");
require_once("libreriaPDOCLA.php");

class movimientosDAO extends ConBase
{
    /*     private $con; */

    public $Movimientos;

    /*     public function __construct()
    {
        $this->con = new ConBase("ejemplo");
    }
 */
    public function Insertar($Movimiento)
    {
        $consulta = "INSERT into movimientos values(:usuario,:fecha,:tipo,:cantidad,:fichero)";
        $param = array(":usuario" => $Movimiento->__GET("Usuario"), ":fecha" => $Movimiento->__GET("Fecha"),  ":tipo" => $Movimiento->__GET("Tipo"), ":cantidad" => $Movimiento->__GET("Cantidad"), ":fichero" => $Movimiento->__GET("Fichero"));
        /*         foreach ($param as $key => $value) {
            echo "clave: ". $key . " valor: " . $value;
        } */
        $this->ConsultaSimple($consulta, $param);
    }

    public function Actualizar($Movimiento)
    {
        $consulta = "UPDATE movimientos SET Tipo = :tipo, Cantidad = :cantidad, Fichero = :fichero WHERE Id = :usuario AND Fecha = :fecha";
        $param = array(":usuario" => $Movimiento->__GET("Usuario"), ":fecha" => $Movimiento->__GET("Fecha"),  ":tipo" => $Movimiento->__GET("Tipo"), ":cantidad" => $Movimiento->__GET("Cantidad"), ":fichero" => $Movimiento->__GET("Fichero"));
        $this->ConsultaSimple($consulta, $param);
    }

    public function Buscar($usuario, $fecha)
    {
        $consulta = "SELECT * FROM movimientos WHERE Usuario = :usuario, Fecha = :fecha";
        $Movimiento = new Movimiento();

        $param = array(":usuario" => $usuario, ":fecha" => $fecha);
        $this->ConsultaDatos($consulta, $param);

        if (!empty($this->filas)) {
            $fila = $this->filas[0];
            $Movimiento->__set("Usuario", $fila['Usuario']);
            $Movimiento->__set("Fecha", $fila['Fecha']);
            $Movimiento->__set("Tipo", $fila['Tipo']);
            $Movimiento->__set("Cantidad", $fila['Cantidad']);
            $Movimiento->__set("Fichero", $fila['Fichero']);
        }

        return $Movimiento;
    }

    public function Eliminar($usuario, $fecha)
    {

        $consulta = "DELETE from movimientos WHERE Usuario = :usuario, Fecha = :fecha";

        $param = array(
            ":usuario" => $usuario,
            ":fecha" => $fecha
        );

        /* echo $consulta; */

        $this->ConsultaSimple($consulta, $param);
    }

    public function Listar()
    {
        $this->Archivos = array();

        $consulta = "SELECT * from movimientos";

        $param = array();

        $this->ConsultaDatos($consulta, $param);

        foreach ($this->filas as $fila) {
            $Movimiento = new Movimiento();

            $Movimiento->__set("Usuario", $fila['Usuario']);
            $Movimiento->__set("Fecha", $fila['Fecha']);
            $Movimiento->__set("Tipo", $fila['Tipo']);
            $Movimiento->__set("Cantidad", $fila['Cantidad']);
            $Movimiento->__set("Fichero", $fila['Fichero']);

            $this->Movimientos[] = $Movimiento;
        }
        /* return $Movimientos; */
    }

    public function ListarDeUsuario($usuario)
    {
        $this->Archivos = array();

        $consulta = "SELECT * from movimientos WHERE Usuario = :usuario";

        $param = array(":usuario" => $usuario);

        $this->ConsultaDatos($consulta, $param);

        foreach ($this->filas as $fila) {
            $Movimiento = new Movimiento();

            $Movimiento->__set("Usuario", $fila['Usuario']);
            $Movimiento->__set("Fecha", $fila['Fecha']);
            $Movimiento->__set("Tipo", $fila['Tipo']);
            $Movimiento->__set("Cantidad", $fila['Cantidad']);
            $Movimiento->__set("Fichero", $fila['Fichero']);

            $this->Movimientos[] = $Movimiento;
        }
        /* return $Movimientos; */
    }
}
