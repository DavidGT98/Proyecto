<?php
require_once("libreria.php");
session_start();
?>

<html>

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

    <title>Inicio</title>


</head>

<body>
    <!--     <div class="form card">

        <div class="user-img">
            <img src="src/img/user.png" alt="user">
        </div>
        <form name=f1 class="text-center p-5" action="#" method="POST">

            <div class="input-group my-4">
                <span class="input-group-prepend">
                    <div class="input-group-text border-right-0"><i class="fa fa-user"></i></div>
                </span>
                <input name="user" type="text" id="user-group" class="form-control" placeholder="Nombre de usuario">
            </div>
            <div class="input-group my-4">
                <span class="input-group-prepend">
                    <div class="input-group-text border-right-0"><i class="fa fa-key"></i></div>
                </span>
                <input name="pass" type="password" class="form-control" placeholder="Contraseña" id="pass-group">
            </div>
                                <button name="Enviar" value="Enviar" type="button" class="btn btn-warning">Login</button>
            <input type=submit name="Enviar" value="Enviar" class="btn btn-primary">
            <div class="forgot">
                <a href="register.php" class="badge badge-dark">Registrarse</a>
            </div>
        </form>
    </div> -->

    <div class="form card text-center">
        <div class="user-img">
            <img src="src/img/user.png" alt="user">
        </div>
        <form class="text-center p-5" name=f1 method=post action=#>

            <p class="h4 mb-4">Accede a tu cuenta</p>

            <!-- User -->
            <div class="input-group mb-4">
                <span class="input-group-prepend">
                    <div class="input-group-text border-right-0"><i class="fa fa-user"></i></div>
                </span>
                <input type="text" name="user" id="user" class="form-control" placeholder="Usuario" required>
            </div>
            <!-- Password -->
            <div class="input-group mb-4">
                <span class="input-group-prepend">
                    <div class="input-group-text border-right-0"><i class="fa fa-key"></i></div>
                </span>
                <input type="password" name="pass" id="pass" class="form-control" placeholder="Contraseña" required>
            </div>
            <!-- Sign up button -->
            <input type=submit name="Enviar" value="Enviar" class="btn btn-primary">
            <!-- Terms of service -->
            <div class="mt-3">
                <a href="register.php" class="badge badge-dark">Registrarse</a>
            </div>
        </form>

    </div>

    <?php
    $salt1 = "#$.-6j";
    $salt2 = "?[*-+¿";

    function LoginCorrecto($usu, $cla)
    {
        $consulta = "select count(*) as Cuenta 
             from usuarios 
			 where nombre='$usu' and clave='$cla'";

        $db = Conectar("proyecto");
       /*  $db = Conectar("id15495097_proyecto"); */
        $datos = ConsultaDatos($db, $consulta);

        $fila = $datos[0];

        $cuenta = $fila['Cuenta'];

        Cerrar($db);

        return $cuenta;   // Puede ser 0 o 1 que sirve como TRUE o FALSE
    }

    if (isset($_POST['Enviar'])) {
        $usuario = $_POST['user'];
        $clave = $_POST['pass'];
        $clave = sha1($salt1 . $clave . $salt2);

        if (LoginCorrecto($usuario, $clave)) {
            $_SESSION['usuario'] = $usuario;    //Creamos una de sesion para ese usuario 
           /*  header("location: dashboard.php"); */  //Redireccionamos la pagina del menu
           echo "<script type='text/javascript'>
           window.location.href = 'http://localhost/_____PROYECTO/dashboard.php';
           </script>"; 
            /* echo "<script type='text/javascript'>
            window.location.href = 'https://cloudisk.000webhostapp.com/dashboard.php';
            </script>"; */
        } else {
            echo "<script>alert('Usuario/clave incorrecto');</script>";
            echo "<div class='alert alert-warning'>Login incorrecto</div>";
        }
    }


    ?>


</body>

</html>