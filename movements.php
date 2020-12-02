<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("location:index.php");
}

require_once("controllers/usuariosDAO.php");
require_once("controllers/movimientosDAO.php");
require_once("libreriaPDOCLA.php");

$dao2 = new usuariosDAO("proyecto");
/* $dao2 = new usuariosDAO("id15495097_proyecto"); */
$usuario = new Usuario;
$usuario = $dao2->Buscar($_SESSION['usuario']);
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


    <link href="./src/css/datatables.min.css" rel="stylesheet">

    <link href="./src/css/table2.css" rel="stylesheet">

    <!-- JQuery -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>

    <script type="text/javascript" src="js/datatables2.min.js"></script>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/plug-ins/1.10.22/sorting/datetime-moment.js"></script>

    <title>Movimientos</title>
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
                <li class="nav-item active">
                    <a class="nav-link" href="#">Movimientos <span class="sr-only">(current)</span></a>
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
                        <a class="dropdown-item" href="account.php">Cuenta</a>
                        <a class="dropdown-item" href="logout.php">Cerrar sesión</a>
                    </div>
                </li>
            </ul>

        </div>
    </nav>
    <!--/.Navbar -->
    <!-- Collapsible content -->
    <h3 class="m-4">Actividad reciente</h3>
    <script src="js/grafica.js"></script>
    <!--         <div class="col-md-8">
           
        </div>
        <div class="col-4">
            
        </div> -->
    <?php
    $dao1 = new movimientosDAO("proyecto");
    /*             $dao1 = new movimientosDAO("id15495097_proyecto");  */
    $dao1->ListarPorUsuario($_SESSION['usuario']);

    $movimiento = new Movimiento();
    $data = array();
    foreach ($dao1->Movimientos as $movimiento) {
        $fecha = $movimiento->__get("Fecha");
        // "2017-12-31 10:30:26.555"
                $campos = getdate($fecha);
        foreach ($campos as $key => $value) {
            $campos[$key] = ($value < 10) ? str_pad($value, 2, '0', STR_PAD_LEFT)  : $value;
        }
        $fecha = $campos['year'] . "-" . $campos['mon'] . "-" . $campos['mday'] . " " .  $campos['hours'] . ":" . $campos['minutes'] . ":" . $campos['seconds'];
        $data2 = array();
        $data2['Fecha'] = $fecha;
        $data2['Tipo'] = $movimiento->__get("Tipo");
        $data2['Cantidad'] = round(strval($movimiento->__get("Cantidad") / 1024 / 1024), 4) . " MB";
        $data2['Fichero'] = $movimiento->__get("Fichero");
        $data[] = $data2;
    }

    /*         echo "<table border=2>
            <tr>
                <th>Fecha</th>
                <th>Tipo</th>
                <th>Cantidad</th>
                <th>Nombre del archivo</th>
            </tr>";

        $dao1 = new movimientosDAO("proyecto");
         $dao1 = new movimientosDAO("id15495097_proyecto"); 
        $dao1->ListarDeUsuario($_SESSION['usuario']);

        $movimiento = new Movimiento();

        foreach ($dao1->Movimientos as $movimiento) {
            $fecha = $movimiento->__get("Fecha");
            $campos = getdate($fecha);
            foreach ($campos as $key => $value) {
                $campos[$key] = ($value < 10) ? str_pad($value, 2, '0', STR_PAD_LEFT)  : $value;
            }
            $fecha = $campos['hours'] . ":" . $campos['minutes'] . " " .  $campos['mday'] . "/" . $campos['mon'] . "/" . $campos['year'];
            echo "<tr>";
            echo "<td><input type=text name=Modelos[" . $movimiento->__get("Usuario") . "] value='" . $fecha . "' readonly> </td>";
            echo "<td>";
            echo "<input type=text name=Marcas[" . $movimiento->__get("Usuario") . "] value='" . $movimiento->__get("Tipo") . "'> </td>";
            echo "<td><input type=text name=Precios[" . $movimiento->__get("Usuario") . "] value=" . $movimiento->__get("Cantidad") . "> </td>";
            echo "<td><input type=text name=Precios[" . $movimiento->__get("Usuario") . "] value=" . $movimiento->__get("Fichero") . "> </td>";
            echo "</tr>";
        }
        echo "</table>"; */
    ?>
    <!--Table-->
    <script>
        function toDate(segundos) {
            var fecha = new Date(1970, 0, 1);
            fecha.setSeconds(segundos);
            return fecha;
        }
        var information = <?php
                            echo json_encode($data)
                            ?>;
        $(document).ready(function() {
                    $('#my-table').DataTable({
                            data: information,
                            columns: [{
                                    data: 'Fecha',
                                    title: 'Fecha',
                                    "render": function(data, type) {
                                        return type === 'sort' ? data : moment(data).format('DD/MM/YYYY HH:mm');}
                                    },
                                    {
                                        data: 'Tipo',
                                        title: 'Tipo'
                                    },
                                    {
                                        data: 'Cantidad',
                                        title: 'Peso'
                                    },
                                    {
                                        data: 'Fichero',
                                        title: 'Fichero'
                                    }
                                ],
                                "pagingType": "first_last_numbers",
                                "language": {
                                    "url": "./include/lang/dataTables_es_ES.json"
                                }
                            });
                    }); $('.dataTables_length').addClass('bs-select');
    </script>
    <div class="row justify-content-center tabla-container m-1">
        <div class="col-md-11 align-self-center">
            <table id="my-table" class="table tabla" cellpadding="0" cellspacing="0" width="100%">
                <!--Table head-->

                <thead class="teal white-text">
                    <tr>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Peso</th>
                        <th>Fichero</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <!--Table-->
</body>

</html>