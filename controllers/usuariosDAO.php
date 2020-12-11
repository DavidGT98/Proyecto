<?php
require_once("models/usuario.php");
require_once("libreriaPDOCLA.php");

class usuariosDAO extends ConBase
{
    /*     private $con; */

    public $Usuarios;

    /*     public function __construct()
    {
        $this->con = new ConBase("ejemplo");
    }
 */
    public function Insertar($Usuario)
    {
        $consulta = "INSERT into usuarios values(:nombre,:clave,:email,:administrador,:usado)";
        $param = array(":nombre" => $Usuario->__GET("Nombre"), ":clave" => $Usuario->__GET("Clave"),  ":email" => $Usuario->__GET("Email"), ":administrador" => $Usuario->__GET("Administrador"), ":usado" => $Usuario->__GET("Usado"));
/*         foreach ($param as $key => $value) {
            echo "clave: ". $key . " valor: " . $value;
        } */
        $this->ConsultaSimple($consulta, $param);
    }

    public function Actualizar($Usuario)
    {
        $consulta = "UPDATE usuarios SET Clave = :clave, Email = :email, Administrador = :administrador, Usado = :usado WHERE Nombre = :nombre";
        $param = array(":nombre" => $Usuario->__GET("Nombre"), ":clave" => $Usuario->__GET("Clave"),  ":email" => $Usuario->__GET("Email"), ":administrador" => $Usuario->__GET("Administrador"), ":usado" => $Usuario->__GET("Usado") );
        $this->ConsultaSimple($consulta, $param);
    }

    public function Buscar($nombre)
    {
        $consulta = "SELECT * FROM usuarios WHERE Nombre = :nombre";
        $Usuario = new Usuario();

        $param = array(":nombre" => $nombre);
        $this->ConsultaDatos($consulta, $param);

        if (!empty($this->filas)) {
            $fila = $this->filas[0];
            $Usuario->__set("Nombre", $fila['Nombre']);
            $Usuario->__set("Clave", $fila['Clave']);
            $Usuario->__set("Email", $fila['Email']);
            $Usuario->__set("Administrador", $fila['Administrador']);
            $Usuario->__set("Usado", $fila['Usado']);
        }

        return $Usuario;
    }

    public function BuscarEmail($email)
    {
        $consulta = "SELECT * FROM usuarios WHERE Email = :email";
        $Usuario = new Usuario();

        $param = array(":email" => $email);
        $this->ConsultaDatos($consulta, $param);

        if (!empty($this->filas)) {
            $fila = $this->filas[0];
            $Usuario->__set("Nombre", $fila['Nombre']);
            $Usuario->__set("Clave", $fila['Clave']);
            $Usuario->__set("Email", $fila['Email']);
            $Usuario->__set("Administrador", $fila['Administrador']);
            $Usuario->__set("Usado", $fila['Usado']);
        }

        return $Usuario;
    }

    public function Eliminar($id)
    {

        $consulta = "DELETE from usuarios where Nombre=:nombre";

        $param = array(
            ":nombre" => $id
        );

        /* echo $consulta; */

        $this->ConsultaSimple($consulta, $param);
    }

    public function Listar()
    {
        $this->Usuarios = array();

        $consulta = "SELECT * from usuarios";

        $param = array();

        $this->ConsultaDatos($consulta, $param);

        foreach ($this->filas as $fila) {
            $Usuario = new Usuario();

            $Usuario->__set("Nombre", $fila['Nombre']);
            $Usuario->__set("Clave", $fila['Clave']);
            $Usuario->__set("Email", $fila['Email']);
            $Usuario->__set("Administrador", $fila['Administrador']);
            $Usuario->__set("Usado", $fila['Usado']);
            $this->Usuarios[] = $Usuario;
        }
        /* return $Usuarios; */
    }
}