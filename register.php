<?php
require_once("libreriaPDOCLA.php");
require_once("usuariosDAO.php");

session_start();
if (isset($_SESSION['usuario'])) {
    header("location:dashboard.php");
    /* echo "<script type='text/javascript'>
    window.location.href = 'https://cloudisk.000webhostapp.com/dashboard.php';
    </script>"; */
}
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>

    <!-- Nuestro css-->
    <link rel="stylesheet" type="text/css" href="src/css/register.css">
    <link rel="stylesheet" type="text/css" href="src/css/main.css">
    <title>Registro</title>
</head>

<body>
    <div class="form card">
        <form class="text-center p-5" name=f1 method=post action=#>

            <p class="h4 mb-4">Regístrate!</p>

            <div class="input-group mb-4">
                <span class="input-group-prepend">
                    <div class="input-group-text border-right-0"><i class="fa fa-user"></i></div>
                </span>
                <input type="text" name="user" id="user" class="form-control" placeholder="Usuario" required>
            </div>

            <!-- E-mail -->
            <div class="input-group mb-4">
                <span class="input-group-prepend">
                    <div class="input-group-text border-right-0"><i class="fa fa-envelope-open-text"></i></div>
                </span>
                <input type="email" name="email" id="email" class="form-control" placeholder="E-mail" required>
            </div>
            <!-- Password -->
            <div class="input-group mb-4">
                <span class="input-group-prepend">
                    <div class="input-group-text border-right-0"><i class="fa fa-key"></i></div>
                </span>
                <input type="password" name="pass" id="pass" class="form-control" placeholder="Contraseña" required>
            </div>
            <!-- Sign up button -->
            <input type=submit name="Registrarse" value="Registrarse" class="btn btn-primary my-4">
            <!-- Terms of service -->
            <p>Al pulsar sobre
                <em>Registrarse</em> estás aceptando nuestros
                <a href="" target="_blank">terminos de servicio</a></p>
            <div class="mt-3">
                <a href="index.php" class="badge badge-dark">Ya tengo cuenta</a>
            </div>
        </form>

    </div>
    <?php
    $salt1 = "#$.-6j";
    $salt2 = "?[*-+¿";


    if (isset($_POST['Registrarse'])) {
        $user = $_POST['user'];
        $clave = $_POST['pass'];
        $clave = sha1($salt1 . $clave . $salt2);
        $email = $_POST['email'];

        /* $dao = new usuariosDAO("id15495097_proyecto"); */
        $dao = new usuariosDAO("proyecto");

        $usuario = new Usuario;
        $usuario->__set("Nombre", $user);
        $usuario->__set("Clave", $clave);
        $usuario->__set("Email", $email);
        $usuario->__set("Administrador", "no");
        $usuario->__set("Usado", 0);

        /* echo $usuario->__toString(); */

        $dao->Insertar($usuario);

        $_SESSION['usuario'] = $user;    //Creamos una de sesion para ese usuario 
        /* header("location: dashboard.php"); */
        echo "<script type='text/javascript'>
        window.location.href = 'http://localhost/_____PROYECTO/dashboard.php';
        </script>";
/*         echo "<script type='text/javascript'>
        window.location.href = 'https://cloudisk.000webhostapp.com/dashboard.php';
        </script>"; */
    }

    ?>

</body>

</html>