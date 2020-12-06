<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("location:index.php");
    echo "<script type='text/javascript'>
    window.location.href = 'http://localhost/_____PROYECTO/index.php';
    </script>";
    /* echo "<script type='text/javascript'>
      window.location.href = 'https://cloudisk.000webhostapp.com/index.php';
      </script>"; */
}

require_once("controllers/usuariosDAO.php");
require_once("libreriaPDOCLA.php");

$dao = new usuariosDAO("proyecto");
/* $dao = new usuariosDAO("id15495097_proyecto"); */
$usuario = new Usuario;
$usuario = $dao->Buscar($_SESSION['usuario']);
$usado = $usuario->__get("Usado");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">
    <!-- JQuery -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" />
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js" />
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/5.4.1/bootbox.min.js"></script>


    <link rel="stylesheet" type="text/css" href="src/css/register.css">
    <link rel="stylesheet" type="text/css" href="src/css/main.css">


    <title>Detalles de la cuenta</title>
</head>

<body>
    <!--Navbar -->
    <nav class="mb-1 navbar navbar-expand-lg navbar-light default-color lighten-1">
        <a class="navbar-brand" href="dashboard.php">ClouDisk</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-555" aria-controls="navbarSupportedContent-555" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent-555">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Inicio
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="movements.php">Movimientos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="upload.php">Subir</a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user"></i> Perfil </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-info" aria-labelledby="navbarDropdownMenuLink-4">
                        <a class="dropdown-item active" href="account.php">Cuenta<span class="sr-only">(current)</span></a>
                        <a class="dropdown-item" href="logout.php">Cerrar sesión</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <!--/.Navbar -->
    <!-- Collapsible content -->


    <div class="form card text-center" style="z-index: -1">

        <h3 class="mt-4 d-flex justify-content-center">Detalles de <?php echo  $usuario->__get("Nombre") ?></h3>

        <form class="text-center p-5" name=f1 method=post action=#>
            <!-- User -->
            <div class="input-group mb-4">
                <span class="input-group-prepend">
                    <div class="input-group-text border-right-0"><i class="fa fa-envelope-open-text"></i></div>
                </span>
                <input type="text" name="email" id="email" class="form-control" value="<?php echo $usuario->__get("Email"); ?>" required>
            </div>
            <!-- Password -->
            <div class="input-group mb-4">
                <span class="input-group-prepend">
                    <div class="input-group-text border-right-0"><i class="fa fa-key"></i></div>
                </span>
                <input type="password" name="pass" id="pass" class="form-control" placeholder="*********">
            </div>
            <!-- Sign up button -->
            <input type=submit name="Guardar" value="Guardar" class="btn btn-primary">
            <input type=submit name="Borrar" value="Borrar cuenta" class="btn btn-danger">

        </form>

    </div>
    <?php
    $salt1 = "#$.-6j";
    $salt2 = "?[*-+¿";


    if (isset($_POST['Guardar'])) {
        $email = $_POST['email'];
        $clave = $_POST['pass'];

        if (!empty($clave)) {
            $clave = sha1($salt1 . $clave . $salt2);
            if ($clave !== $usuario->__get("Clave")) {
                $usuario->__set("Clave", $clave);
            }
        }
        /* $usuario->__set("Email", $email); */

        $mismoEmail = new Usuario;
        $mismoEmail = $dao->BuscarEmail($email);
        if ($mismoEmail->__get("Nombre") != null && $mismoEmail->__get("Nombre") != "") {
            if ($mismoEmail->__get("Nombre") !== $usuario->__get("Nombre")) {
                echo "ese email ya está siendo usado por otro usuario";
            }
        } else {
            $usuario->__set("Email", $email);
        }

        $dao->Actualizar($usuario);
        echo "<script type='text/javascript'>
        window.location.href = 'http://localhost/_____PROYECTO/account.php';
        </script>";
        /*         echo "<script type='text/javascript'>
        window.location.href = 'https://cloudisk.000webhostapp.com/account.php';
        </script>"; */
    }

    if (isset($_POST['Borrar'])) {
        $dao->Eliminar($_SESSION['usuario']);
        if (isset($_SESSION['usuario'])) {
            unset($_SESSION['usuario']);
            session_destroy();
        }
        echo "<script type='text/javascript'>
        window.location.href = 'http://localhost/_____PROYECTO/index.php';
        </script>";
    }

    ?>
    <footer class="page-footer font-small">

        <!-- Copyright -->
        <div class="footer-copyright text-center py-3 default-color-dark fixed-bottom">© 2020 Copyright:
            <a href="https://cloudisk.000webhostapp.com/"> ClouDisk </a>
        </div>
        <!-- Copyright -->

    </footer>

</body>

</html>