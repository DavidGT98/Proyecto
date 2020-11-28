<?php

class ConBase
{
    private $host = 'localhost';
    private $usuario = 'root';
    private $clave = '';
    /*     private $usuario = 'id15495097_localhost';
    private $clave = 'ykpw{0/<+?t7Jwg)'; */

    protected $db;
    protected $dbname;


    function __construct($base)
    {
        $this->dbname = $base;
    }

    public $filas = array();



    private function conectaDb()
    {

        try {
            $this->db = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->usuario);
            /* $this->db = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->usuario, $this->clave); */
            $this->db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
            $this->db->exec("set names utf8mb4");
            return ($this->db);
        } catch (PDOException $e) {

            print " <p>Error: No puede conectarse con la base de datos.</p>\n\n";
            print " <p>Error: " . $e->getMessage() . "</p>\n";

            exit();
        }
    }

    private function cerrarDb()
    {
        $this->db = null;
    }

    public function ConsultaSimple($consulta, $param)
    {
        $this->conectaDb();

        $resul = $this->db->prepare($consulta);

        /*         echo $consulta."<br>";
        foreach ($param as $key => $value) {
            echo $value;
        }
        echo "<br>"; */

        if (!$resul->execute($param)) {
            echo $consulta . "<br>";
            foreach ($param as $key => $value) {
                echo $value;
            }
            echo "<br>";
            echo "Error al ejecutar la consulta";
        }

        $this->cerrarDb();
    }

    public function ConsultaDatos($consulta, $param)
    {
        $filas = array();

        $this->conectaDb();

        $resul = $this->db->prepare($consulta);

        if (!$resul->execute($param)) {
            echo "Error al ejecutar la consulta";
        } else {
            /*             fetch(PDO::FETCH_ASSOC) */
            while ($fila = $resul->fetch()) {
                $filas[] = $fila;
            }
        }
        $this->filas = $filas;
        $this->cerrarDb();
    }
}
