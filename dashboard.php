<?php
session_start();
if (!isset($_SESSION['usuario'])) {
  header("location:index.php");
}

require_once("usuariosDAO.php");
require_once("libreriaPDOCLA.php");

$dao2 = new usuariosDAO("proyecto");
/* $dao2 = new usuariosDAO("id15495097_proyecto"); */
$usuario = new Usuario;
$usuario = $dao2->Buscar($_SESSION['usuario']);
$usado = $usuario->__get("Usado");

$usado = round($usado / 1024 / 1024, 2);

echo $usado . "MB usados de 100MB disponibles";

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

  <style type="text/css">
    .tg {
      border-collapse: collapse;
      border-spacing: 0;
    }

    .tg td {
      border-color: black;
      border-style: solid;
      border-width: 1px;
      font-family: Arial, sans-serif;
      font-size: 14px;
      overflow: hidden;
      padding: 10px 5px;
      word-break: normal;
    }

    .tg th {
      border-color: black;
      border-style: solid;
      border-width: 1px;
      font-family: Arial, sans-serif;
      font-size: 14px;
      font-weight: normal;
      overflow: hidden;
      padding: 10px 5px;
      word-break: normal;
    }

    .tg .tg-0lax {
      text-align: left;
      vertical-align: top
    }
  </style>
  <title>Dashboard</title>
</head>

<body>
  <!--Navbar -->
  <nav class="mb-1 navbar navbar-expand-lg navbar-light default-color lighten-1">
    <a class="navbar-brand" href="#">Navbar</a>
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
          <a class="nav-link" href="#">Movimientos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="upload.php">Subir</a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto nav-flex-icons">
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Cerrar sesión</a>
        </li>
        <li class="nav-item avatar">
          <a class="nav-link p-0" href="#">
            <img src="src/img/avatar.png" class="rounded-circle z-depth-0" alt="avatar image" height="35">
          </a>
        </li>
      </ul>
    </div>
  </nav>
  <!--/.Navbar -->
  <!-- Collapsible content -->
  <h3 class="d-flex justify-content-center">Bienvenido/a <?php echo  $usuario->__get("Nombre") ?></h3>
  <div class="service-container" data-service="<?php echo $usado; ?>"></div>
  <script src="js/grafica.js"></script>
  <div class="row d-flex justify-content-center">
    <div class="col-md-8">
      <canvas id="doughnutChart"></canvas>
    </div>
    <div class="col-4">
      <table class="tg">
        <thead>
          <tr>
            <th class="tg-0lax">Nombre</th>
            <th class="tg-0lax">Tamaño</th>
            <th class="tg-0lax">etc</th>
            <th class="tg-0lax">test</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="tg-0lax"></td>
            <td class="tg-0lax"></td>
            <td class="tg-0lax"></td>
            <td class="tg-0lax"></td>
          </tr>
          <tr>
            <td class="tg-0lax"></td>
            <td class="tg-0lax"></td>
            <td class="tg-0lax"></td>
            <td class="tg-0lax"></td>
          </tr>
          <tr>
            <td class="tg-0lax"></td>
            <td class="tg-0lax"></td>
            <td class="tg-0lax"></td>
            <td class="tg-0lax"></td>
          </tr>
          <tr>
            <td class="tg-0lax"></td>
            <td class="tg-0lax"></td>
            <td class="tg-0lax"></td>
            <td class="tg-0lax"></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</body>

</html>