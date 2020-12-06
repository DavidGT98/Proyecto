<?php

require_once("libreriaPDOCLA.php");
require_once("controllers/archivosDAO.php");
require_once("controllers/usuariosDAO.php");
require_once("controllers/movimientosDAO.php");

session_start();
if (!isset($_SESSION['usuario'])) {
/*     echo "<script >
    window.location.href = 'http://localhost/_____PROYECTO/dashboard.php';
    </script>"; */
    echo "<script >
    window.location.href = 'https://cloudisk.000webhostapp.com/dashboard.php';
    </script>";
}

if (isset($_GET['Eliminar'])) {
    $file = $_GET['Eliminar'];
    $dir = './uploads/' . $_SESSION['usuario'];
    $url = $dir . '/' . $file;
    $file_pointer = "test.txt";

        $dao1 = new archivosDAO("id15495097_proyecto");

    $dao2 = new usuariosDAO("id15495097_proyecto");

    $dao3 = new movimientosDAO("id15495097_proyecto");

/*     $dao1 = new archivosDAO("proyecto");

    $dao2 = new usuariosDAO("proyecto");

    $dao3 = new movimientosDAO("proyecto");
 */
    $usuario = new Usuario;
    $usuario = $dao2->Buscar($_SESSION['usuario']);

    $archivo = new Archivo;
    $archivo = $dao1->Buscar($file, $_SESSION['usuario']);
    // se actualiza la base de datos, borrando el fichero
    if ($archivo->__get("Id") != null && $archivo->__get("Id") != "") {
        $dao1->Eliminar($archivo->__get("Id"), $_SESSION['usuario']);
        $usado = $usuario->__get("Usado") - $archivo->__get("Peso");
        $usuario->__set("Usado", $usado);
        $movimiento1 = new Movimiento();
        $movimiento1->__set("Usuario", $_SESSION['usuario']);
        $movimiento1->__set("Fecha", time());
        $movimiento1->__set("Tipo", "borrado");
        $movimiento1->__set("Cantidad", $archivo->__get("Peso"));
        $movimiento1->__set("Fichero", $archivo->__get("Id"));
        $dao3->Insertar($movimiento1);
        $dao2->Actualizar($usuario);
    }
    // se borra el fichero del almacenamiento
    if (!unlink($url)) {
/*         echo "<script >
        window.location.href = 'http://localhost/_____PROYECTO/dashboard.php';
        </script>"; */
        echo "<script >
    window.location.href = 'https://cloudisk.000webhostapp.com/dashboard.php';
    </script>";
    } else {
/*         echo "<script >
        window.location.href = 'http://localhost/_____PROYECTO/dashboard.php';
        </script>"; */
        echo "<script >
    window.location.href = 'https://cloudisk.000webhostapp.com/dashboard.php';
    </script>";
    }
}
