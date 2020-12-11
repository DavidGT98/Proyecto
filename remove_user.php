<?php
session_start();

require_once("libreriaPDOCLA.php");
require_once("controllers/archivosDAO.php");
require_once("controllers/usuariosDAO.php");

if (!isset($_SESSION['usuario'])) {
    /* echo "<script >
    window.location.href = 'http://localhost/_____PROYECTO/dashboard.php';
    </script>"; */
    echo "<script >
    window.location.href = 'https://cloudisk.000webhostapp.com/dashboard.php';
    </script>";
}

if (!isset($_SESSION['admin'])) {
   /*  echo "<script >
    window.location.href = 'http://localhost/_____PROYECTO/dashboard.php';
    </script>"; */
    echo "<script >
    window.location.href = 'https://cloudisk.000webhostapp.com/dashboard.php';
    </script>";
}


if (isset($_GET['Nombre'])) {
    $usu = $_GET['Nombre'];
    $dir = './uploads/' . $usu;

    $dao1 = new archivosDAO("id15495097_proyecto");

    $dao2 = new usuariosDAO("id15495097_proyecto");

    $dao3 = new movimientosDAO("id15495097_proyecto");


/*     $dao1 = new archivosDAO("proyecto");
    $dao2 = new usuariosDAO("proyecto"); */

    $usuario = new Usuario;
    $usuario = $dao2->Buscar($usu);
    
    if ($usuario->__get("Nombre") != null && $usuario->__get("Nombre") != "") {
        $dao1->EliminarDePropietario($usu);
        $dao2->Eliminar($usu);
        $dao3->EliminarDeUsuario($usu);
        eliminarArchivos("./uploads/" . $usu);
    }

/*     echo "<script >
    window.location.href = 'http://localhost/_____PROYECTO/admin_users.php';
    </script>"; */
    echo "<script >
    window.location.href = 'https://cloudisk.000webhostapp.com/admin_users.php';
    </script>";
}


function eliminarArchivos($carpeta)
{
    if (is_dir($carpeta))
        echo "existe la carpeta" . $carpeta;
    $carpetaActual = opendir($carpeta);

    if (!$carpetaActual)

        return false;

    while ($archivo = readdir($carpetaActual)) {

        if ($archivo != "." && $archivo != "..") {

            if (!is_dir($carpeta . "/" . $archivo))
                unlink($carpeta . "/" . $archivo);
            else
            eliminarArchivos($carpeta . '/' . $archivo);
        }
    }

    closedir($carpetaActual);

    rmdir($carpeta);

    return true;
}