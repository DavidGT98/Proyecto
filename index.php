<html>

<head>
    <!--JQUERY-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- FRAMEWORK BOOTSTRAP para el estilo de la pagina-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

    <!-- Los iconos tipo Solid de Fontawesome-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/solid.css">
    <script src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>

    <!-- Nuestro css-->
    <link rel="stylesheet" type="text/css" href="src/css/css.css">

    <title>Login Form</title>
    <?php

    require_once("libreria.php");
    ?>

</head>

<body>
    <div class="modal-dialog text-center">
        <div class="col-sm-8 main-section">
            <div class="modal-content">
                <div class="col-12 user-img">
                    <img src="src/img/user.png" alt="user">
                </div>
                <form name=f1 class="col-12" action="#" method="POST">
                    <div class="form-group">
                        <p class="icono-login">
                            <input name="user" type="text" class="form-control" placeholder="Nombre de usuario" id="user-group">
                        </p>
                    </div>
                    <div class="form-group">
                        <p class="icono-password">
                            <input name="pass" type="password" class="form-control" placeholder="Contraseña" id="pass-group">
                        </p>
                    </div>
                    <!--                     <button name="Enviar" value="Enviar" type="button" class="btn btn-warning">Login</button> -->
                    <input type=submit name="Enviar" value="Enviar" class="btn btn-dark">
                    <div class="col-12 forgot">
                        <a href="#" class="badge badge-secondary">Contraseña olvidada</a>
                    </div>
                </form>
            </div>
        </div>
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
            session_start();
            $_SESSION['usuario'] = $usuario;    //Creamos una de sesion para ese usuario 
            header("location: dashboard.php");  //Redireccionamos la pagina del menu
        } else {
            echo "<script>alert('Usuario/clave incorrecto');</script>";
            echo "<div class='alert alert-warning'>Login incorrecto</div>";
        }
    }


    ?>


</body>

</html>