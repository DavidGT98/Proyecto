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
if (isset($_SESSION['admin'])) {
  /* header("location:dashboard.php"); */
  echo "<script type='text/javascript'>
  window.location.href = 'http://localhost/_____PROYECTO/admin_dashboard.php';
  </script>";
  /* echo "<script type='text/javascript'>
    window.location.href = 'https://cloudisk.000webhostapp.com/admin_dashboard.php';
    </script>"; */
}

require_once("controllers/usuariosDAO.php");
require_once("controllers/archivosDAO.php");
require_once("libreriaPDOCLA.php");

$dao1 = new archivosDAO("proyecto");
$dao2 = new usuariosDAO("proyecto");

/*$dao1 = new archivosDAO("id15495097_proyecto");
 $dao2 = new usuariosDAO("id15495097_proyecto"); */
$usuario = new Usuario;
$usuario = $dao2->Buscar($_SESSION['usuario']);
$usado = $usuario->__get("Usado");

$usado = round($usado / 1024 / 1024, 2);

/* echo $usado . "MB usados de 100MB disponibles"; */

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

  <link href="./src/css/table1.css" rel="stylesheet">
  <!-- JQuery -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!-- Bootstrap tooltips -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js"></script>

  <script type="text/javascript" src="js/datatables2.min.js"></script>

  <title>Dashboard</title>
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
        <li class="nav-item active">
          <a class="nav-link" href="#">Inicio
            <span class="sr-only">(current)</span>
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
            <a class="dropdown-item" href="account.php">Cuenta</a>
            <a class="dropdown-item" href="logout.php">Cerrar sesión</a>
          </div>
        </li>
      </ul>
      <!--       <ul class="navbar-nav ml-auto nav-flex-icons">
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Cerrar sesión</a>
        </li>
        <li class="nav-item avatar">
          <a class="nav-link p-0" href="#">
            <img src="src/img/avatar.png" class="rounded-circle z-depth-0" alt="avatar image" height="35">
          </a>
        </li>
      </ul> -->
    </div>
  </nav>

  <h3 class="my-4 d-flex justify-content-center">Bienvenido/a <?php echo  $usuario->__get("Nombre") ?></h3>
  <div class="service-container" data-service="<?php echo $usado; ?>"></div>
  <script src="js/grafica.js"></script>
  <div class="row d-flex flex-wrap justify-content-center">
    <div class="col-sm-12 col-md-6">
      <canvas id="doughnutChart"></canvas>
    </div>

    <div class="col-sm-12 col-md-6 align-self-center">
      <div class="card my-2 ml-4 mr-3 pl-4 pr-3">
        <?php
        $dao1->ListarPorUsuario($_SESSION['usuario']);

        $archivo = new Archivo();
        $data = array();
        foreach ($dao1->Archivos as $archivo) {
          $data2 = array();
          $data2['Nombre'] = "<a href='./download.php?Bajar=" . $archivo->__get("Id") . "' class='badge badge-pill badge-primary'>" . $archivo->__get("Id") . " <i class='fas fa-download'></i></a>";
          $data2['Nombre'] .= " <a href='./delete.php?Eliminar=" . $archivo->__get("Id") . "' class='badge badge-danger'><i class='fas fa-trash'></i></a>";
          /*           $data2['Nombre'] = "<input type=submit name='Bajar' value='" . $archivo->__get("Id") . "' class='btn btn-default boton'>"; */
          $data2['Tipo'] = $archivo->__get("Tipo");
          $data2['Peso'] = round(strval($archivo->__get("Peso") / 1024 / 1024), 4) . " MB";
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
                  title: 'Nombre'
                },
                {
                  data: 'Tipo',
                  title: 'Tipo'
                },
                {
                  data: 'Peso',
                  title: 'Tamaño'
                }
              ],
              "pageLength": 8,
              "lengthMenu": [
                [8],
                [8]
              ],
              "info": false,
              "pagingType": "first_last_numbers",
              "language": {
                "url": "./include/lang/dataTables_es_ES.json"
              }
            });
          });
          $('.dataTables_length').addClass('bs-select');
        </script>
        <table id="my-table" class="table tabla" cellpadding="0" cellspacing="0" width="100%">

          <thead class="teal white-text">
            <tr>
              <th>Nombre</th>
              <th>Tipo</th>
              <th>Tamaño</th>
            </tr>
          </thead>
        </table>
      </div>
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