<?php
session_start();

require_once("libreriaPDOCLA.php");
require_once("controllers/movimientosDAO.php");
require_once("controllers/archivosDAO.php");

if (!isset($_SESSION['usuario'])) {
    echo "<script type='text/javascript'>
    window.location.href = 'http://localhost/_____PROYECTO/dashboard.php';
    </script>";
    /* echo "<script type='text/javascript'>
    window.location.href = 'https://cloudisk.000webhostapp.com/dashboard.php';
    </script>"; */
}

if (isset($_GET['Bajar'])) {
    $file = $_GET['Bajar'];
    $dir = './uploads/' . $_SESSION['usuario'];
    $url = $dir . '/' . $file;

        /*     $dao1 = new archivosDAO("id15495097_proyecto");

    $dao3 = new movimientosDAO("id15495097_proyecto"); */

    $dao1 = new archivosDAO("proyecto");
    $dao3 = new movimientosDAO("proyecto");


    $archivo = new Archivo;
    $archivo = $dao1->Buscar($file, $_SESSION['usuario']);
    // se actualiza la base de datos, borrando el fichero
    if ($archivo->__get("Id") != null && $archivo->__get("Id") != "") {
        $movimiento1 = new Movimiento();
        $movimiento1->__set("Usuario", $_SESSION['usuario']);
        $movimiento1->__set("Fecha", time());
        $movimiento1->__set("Tipo", "bajado");
        $movimiento1->__set("Cantidad", $archivo->__get("Peso"));
        $movimiento1->__set("Fichero", $archivo->__get("Id"));
        $dao3->Insertar($movimiento1);
    }

    if (file_exists($url)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/force-download');
        header("Content-Disposition: attachment; filename=\"" . basename($file) . "\";");
        /*  header('Content-Transfer-Encoding: binary'); */
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($url));
        ob_clean();
        flush();
        readfile($url); //showing the path to the server where the file is to be download
        exit;
    }
}
