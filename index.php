<?php
session_start();

require_once("libreriaPDOCLA.php");
require_once("controllers/usuariosDAO.php");

function Bloqueado($usu)
{
    $bloqueado = false;  //Suponemos por defecto que no esta bloqueado	

    $consulta = "SELECT Acceso, Hora
             from intentos
             where usuario=:usuario
             order by hora DESC
             limit 3";

    $con = new ConBase("id15495097_proyecto");
    /*     $con = new ConBase(); */

    $param = array(":usuario" => $usu);

    $con->ConsultaDatos($consulta, $param);

    $cont = 0;  //Contamos los accesos denegados

    while ((list($clave, $fila) = each($con->filas)) && (($fila['Acceso'] != 'C'))) {
        $cont++;
    }

    if ($cont == 3) {
        $transcurrido = time() - $con->filas[0]['Hora'];

        $primerInt = $con->filas[2]['Hora'];

        $ultimoInt = $con->filas[0]['Hora'];

        $entreInt = $ultimoInt - $primerInt;

        return (($cont == 3) && $transcurrido < 300 && $entreInt < 600);
    }

    return $bloqueado; // Devuelve true si hemos contado 3 D o sino un False

}

function LoginCorrecto($usu, $cla)
{
    $consulta = "select count(*) as Cuenta 
             from usuarios 
             where Nombre=:nombre and Clave=:clave";

    $con = new ConBase("id15495097_proyecto");
    /*     $con = new ConBase(); */

    $param = array(":nombre" => $usu, ":clave" => $cla);

    $con->ConsultaDatos($consulta, $param);

    $fila = $con->filas[0];

    $cuenta = $fila['Cuenta'];

    return $cuenta;   // Puede ser 0 o 1 que me sirve como TRUE o FALSE

}

function TiempoRestante($usu)
{
    $consulta = "SELECT Acceso, Hora
	from intentos
	where Usuario=:usuario
	order by hora DESC
    limit 1";

    $con = new ConBase("id15495097_proyecto");
    /*     $con = new ConBase(); */

    $param = array(":usuario" => $usu);

    $con->ConsultaDatos($consulta, $param);
    $fecha = $con->filas[0]['Hora'] + 300;
    $campos = getdate($fecha);
    foreach ($campos as $key => $value) {
        $campos[$key] = ($value < 10) ? str_pad($value, 2, '0', STR_PAD_LEFT)  : $value;
    }
    $fecha = $campos['hours'] . ":" . $campos['minutes'] . " " . $campos['mday'] . "/" . $campos['mon'] . "/" . $campos['year'];
    return $fecha;
}

function InsertarLogin($usu, $cla, $acceso)
{
    $hora = time();

    $consulta = "insert into intentos values (:usuario,:clave,:hora,:acceso)";

    $con = new ConBase("id15495097_proyecto");
    /*     $con = new ConBase(); */


    $param = array(":usuario" => $usu, ":clave" => $cla, ":hora" => $hora, ":acceso" => $acceso);

    $con->ConsultaSimple($consulta, $param);
}

function EsAdmin($usu)
{
    /*     $dao = new usuariosDAO(); */
    $dao = new usuariosDAO("id15495097_proyecto");

    $usuario = new Usuario;
    $usuario = $dao->Buscar($usu);

    if ($usuario->__get('Administrador') == 'si') {
        return true;
    } else {
        return false;
    }
}

?>

<!DOCTYPE html>
<html lang="es">

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>

    <!-- Nuestro css-->
    <link rel="stylesheet" type="text/css" href="src/css/register.css">
    <link rel="stylesheet" type="text/css" href="src/css/main.css">

    <title>Inicio</title>


</head>

<body>

    <div class="container my-4 px-0">

        <!--Section: Content-->
        <section class="p-4 my-md-4 text-center">

            <form class="my-4 mx-md-4" name=f1 method=post action=#>

                <div class="row">
                    <div class="col-md-6 mx-auto">

                        <div class="card">

                            <div>
                                <img src="src/img/logo.png" width="200" height="200" alt="user">
                            </div>

                            <div class="card-body">

                                <div class="text-center" style="color: #757575;">

                                    <h3 class="font-weight-bold my-4 pb-2 text-center dark-grey-text">Iniciar sesión</h3>

                                    <span class="input-group mb-4">
                                        <span class="input-group-prepend">
                                            <span class="input-group-text border-right-0"><i class="fa fa-user"></i></span>
                                        </span>
                                        <input type="text" name="user" id="user" class="form-control" placeholder="Usuario" required>
                                    </span>

                                    <span class="input-group mb-4">
                                        <span class="input-group-prepend">
                                            <span class="input-group-text border-right-0"><i class="fa fa-key"></i></span>
                                        </span>
                                        <input type="password" name="pass" id="pass" class="form-control" placeholder="Contraseña" required>
                                    </span>
                                    <small class="form-text text-right">
                                        <a class="text-info" href="register.php">Registrarse</a>
                                    </small>

                                    <div class="text-center">
                                        <input type=submit name="Enviar" value="Enviar" class="btn btn-outline-primary">
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>

            </form>

        </section>
        <!--Section: Content-->


    </div>

    <footer class="page-footer font-small">

        <!-- Copyright -->
        <div class="footer-copyright text-center py-3 default-color-dark fixed-bottom">© 2020 Copyright:
            <a href="https://cloudisk.000webhostapp.com/"> ClouDisk </a>
        </div>
        <!-- Copyright -->

    </footer>

    <?php
    $salt1 = "#$.-6j";
    $salt2 = "?[*-+¿";

    if (isset($_POST['Enviar'])) {
        $usu = $_POST['user'];
        $cla = $_POST['pass'];

        $cla = sha1($salt1 . $cla . $salt2);

        if (!Bloqueado($usu))        //Si el usuario no esta bloqueado	
        {
            if (LoginCorrecto($usu, $cla))      //Comprobamos si el login es correcto
            {
                $acceso = "C";   //El acceso es concedido
                InsertarLogin($usu, $cla, $acceso);

                $_SESSION['usuario'] = $usu;    //Creamos una de sesion para ese usuario 
                if (EsAdmin($usu)) {
                    $_SESSION['admin'] = $usu;  // Si el usuario es administrador se le lleva a su propio dashboard
                    /*                     echo "<script >
                    window.location.href = 'http://localhost/_____PROYECTO/admin_dashboard.php';
                    </script>"; */
                    echo "<script >
                 window.location.href = 'https://cloudisk.000webhostapp.com/admin_dashboard.php';
                 </script>";
                }
                /*                 echo "<script >
                     window.location.href = 'http://localhost/_____PROYECTO/dashboard.php';
                     </script>"; */
                echo "<script >
                 window.location.href = 'https://cloudisk.000webhostapp.com/dashboard.php';
                 </script>";
            } else {
                echo "<div class='alert alert-warning' role='alert'>
                Usuario/clave incorrecto</div>";
            }

            if (Bloqueado($usu)) {
                echo "<div class='alert alert-danger' role='alert'>
                     Usuario bloqueado hasta: " . TiempoRestante($usu) .
                    "</div>";
            }

            $acceso = "D";   //El acceso es denegado
            InsertarLogin($usu, $cla, $acceso);
        } else   //Estaba bloqueado
        {
            echo "<div class='alert alert-danger' role='alert'>
                     Usuario bloqueado hasta: " . TiempoRestante($usu) .
                "</div>";
        }
    }

    ?>


</body>

</html>