<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    /* header("location:index.php"); */
    echo "<script type='text/javascript'>
    window.location.href = 'http://localhost/_____PROYECTO/index.php';
    </script>";
    /* echo "<script type='text/javascript'>
      window.location.href = 'https://cloudisk.000webhostapp.com/index.php';
      </script>"; */
}
if (!isset($_SESSION['admin'])) {
    /* header("location:dashboard.php"); */
    echo "<script type='text/javascript'>
    window.location.href = 'http://localhost/_____PROYECTO/dashboard.php';
    </script>";
    /* echo "<script type='text/javascript'>
      window.location.href = 'https://cloudisk.000webhostapp.com/dashboard.php';
      </script>"; */
}

require_once("controllers/usuariosDAO.php");
require_once("libreriaPDOCLA.php");

$dao2 = new usuariosDAO("proyecto");
/* $dao2 = new usuariosDAO("id15495097_proyecto"); */
$usuario = new Usuario;
$usuario = $dao2->Buscar($_SESSION['usuario']);

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

    <title>Administrar usuarios</title>
</head>

<body>
    <!--Navbar -->
    <nav class="mb-1 navbar navbar-expand-lg navbar-light default-color lighten-1">
        <a class="navbar-brand" href="admin_dashboard.php">ClouDisk - Administrador</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-555" aria-controls="navbarSupportedContent-555" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent-555">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="admin_dashboard.php">Inicio

                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin_movements.php">Movimientos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin_upload.php">Subir</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#"> <span class="sr-only">(current)</span>Usuarios</a>
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
    <h3 class="m-4">Actividad reciente</h3>
    <script src="js/grafica.js"></script>
    <?php
    $dao1 = new usuariosDAO("proyecto");
    /*             $dao1 = new usuariosDAO("id15495097_proyecto");  */
    $dao1->Listar();

    $usuario = new Usuario();
    $data = array();
    foreach ($dao1->Usuarios as $usuario) {

        $tipoUsu = $usuario->__get("Administrador");
        switch ($tipoUsu) {
            case "si":
                $tipoUsu = "<span class='badge badge-primary'>" . $tipoUsu . "</span>";
                break;
            case "no":
                $tipoUsu = "<span class='badge badge-light'>" . $tipoUsu . "</span>";
                break;
            default:
                $tipoUsu = "<span class='badge badge-secondary'>" . $$tipoUsu . "</span>";
        }
        $data2 = array();
        $data2['Nombre'] = $usuario->__get("Nombre");
        $data2['Nombre'] .= " <a href='./remove_user.php?Nombre=" . $usuario->__get("Nombre") . "' class='badge badge-pill badge-danger'><i class='fas fa-trash-alt'></i></a>";
        $data2['Clave'] = "********";
        $data2['Clave'] .= " <a href='./reset_pass.php?Nombre=" . $usuario->__get("Nombre") . "' class='badge badge-pill badge-secondary darken-4'><i class='fas fa-redo'></i></a>";
        $data2['Email'] = $usuario->__get("Email");
        $data2['Administrador'] = $tipoUsu;
        $data2['Usado'] = round(strval($usuario->__get("Usado") / 1024 / 1024), 4) . " MB";
        $data2['Usado'] .= " <a href='./reset_usage.php?Nombre=" . $usuario->__get("Nombre") . "' class='badge badge-pill badge-secondary darken-4'><i class='fas fa-redo'></i></a>";
        $data[] = $data2;
    }
    ?>
    <script>
        var information = <?php
                            echo json_encode($data)
                            ?>;
        $(document).ready(function() {
            $('#my-table').DataTable({
                data: information,
                columns: [{
                        data: 'Nombre',
                        title: 'Nombre',
                    },
                    {
                        data: 'Clave',
                        title: 'Clave'
                    },
                    {
                        data: 'Email',
                        title: 'Email'
                    },
                    {
                        data: 'Administrador',
                        title: 'Administrador'
                    },
                    {
                        data: 'Usado',
                        title: 'Usado'
                    }
                ],
                "order": [
                    [0, "desc"]
                ],
                "pageLength": 8,
                "lengthMenu": [
                    [8, 25, 50, -1],
                    [8, 25, 50, "All"]
                ],
                "pagingType": "first_last_numbers",
                "language": {
                    "url": "./include/lang/dataTables_es_ES.json"
                }
            });
        });
        $('.dataTables_length').addClass('bs-select');
    </script>
    <div class="row d-flex justify-content-center m-2 p-4">
        <div class="col-sm-12 col-md-11 align-self-center">
            <table id="my-table" class="table tabla" cellpadding="0" cellspacing="0">
                <thead class="teal white-text">
                    <tr>
                        <th>Nombre</th>
                        <th>Clave</th>
                        <th>Email</th>
                        <th>Administrador</th>
                        <th>Usado</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <footer class="page-footer font-small">

        <!-- Copyright -->
        <div class="footer-copyright text-center py-3 default-color-dark fixed-bottom">© 2020 Copyright:
            <a href="https://cloudisk.000webhostapp.com/"> ClouDisk </a>
        </div>
        <!-- Copyright -->

    </footer>
</body>

</html>