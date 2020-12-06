<?php
session_start();
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
  <title>Subir</title>
</head>

<body>
  <?php
  if (!isset($_SESSION['usuario'])) {
    /* header("location:index.php"); */
    /*   echo "<script >
  window.location.href = 'http://localhost/_____PROYECTO/index.php';
  </script>"; */
    echo "<script >
    window.location.href = 'https://cloudisk.000webhostapp.com/index.php';
    </script>";
  }
  if (!isset($_SESSION['admin'])) {
    /* header("location:dashboard.php"); */
    /*   echo "<script >
  window.location.href = 'http://localhost/_____PROYECTO/dashboard.php';
  </script>"; */
    echo "<script >
    window.location.href = 'https://cloudisk.000webhostapp.com/dashboard.php';
    </script>";
  }

  require_once("libreriaPDOCLA.php");
  require_once("controllers/archivosDAO.php");
  require_once("controllers/usuariosDAO.php");
  require_once("controllers/movimientosDAO.php");

  if (isset($_POST['Subir'])) {
    if (!empty($_FILES['Archivo']['name']))  //Si hemos seleccionado y subido la foto
    {
      $nombreArchivo = $_FILES['Archivo']['name'];

      $temporal = $_FILES['Archivo']['tmp_name'];

      $tamano = $_FILES["Archivo"]["size"];

      $ext = pathinfo($nombreArchivo, PATHINFO_EXTENSION);

      $ext = strtolower($ext);

      $archivo = new Archivo;
      $archivo->__set("Id", $nombreArchivo);
      $archivo->__set("Tipo", $ext);
      $archivo->__set("Peso", $tamano);
      $archivo->__set("Propietario", $_SESSION['usuario']);

      $dao1 = new archivosDAO("id15495097_proyecto");

      $dao2 = new usuariosDAO("id15495097_proyecto");

      $dao3 = new movimientosDAO("id15495097_proyecto");

      /*     $dao1 = new archivosDAO("proyecto");

    $dao2 = new usuariosDAO("proyecto");

    $dao3 = new movimientosDAO("proyecto"); */

      $usuario = new Usuario;
      $usuario = $dao2->Buscar($_SESSION['usuario']);

      if (($tamano / 1024 / 1024) > 100) { // Si el archivo pesa mas de 100mb no se podrá subir
        echo "El archivo es demasiado grande";
      } else {
        if ((($usuario->__get("Usado") + $tamano) / 1024 / 1024) <= 100) { // Se comprueba que haya espacio para el fichero

          $ficheroAnt = new Archivo;
          $ficheroAnt = $dao1->Buscar($archivo->__get("Id"), $_SESSION['usuario']);
          if ($ficheroAnt->__get("Id") != null && $ficheroAnt->__get("Id") != "") { // Si ese usuario ya tiene un archivo con ese mismo nombre, lo reemplazamos
            $dao1->Eliminar($archivo->__get("Id"), $_SESSION['usuario']);
            $usado = $usuario->__get("Usado") - $ficheroAnt->__get("Peso");
            $movimiento1 = new Movimiento();
            $movimiento1->__set("Usuario", $_SESSION['usuario']);
            $movimiento1->__set("Fecha", time());
            $movimiento1->__set("Tipo", "borrado");
            $movimiento1->__set("Cantidad", $ficheroAnt->__get("Peso"));
            $movimiento1->__set("Fichero", $ficheroAnt->__get("Id"));
            $dao3->Insertar($movimiento1);
          }
          $dao1->Insertar($archivo);
          $usado = $usuario->__get("Usado") + $tamano; // Se actualiza el almacenamiento usado por el usuario
          $usuario->__set("Usado", $usado);
          $dao2->Actualizar($usuario);
          $movimiento2 = new Movimiento();
          $movimiento2->__set("Usuario", $_SESSION['usuario']);
          $movimiento2->__set("Fecha", time() + 1);
          $movimiento2->__set("Tipo", "subida");
          $movimiento2->__set("Cantidad", $tamano);
          $movimiento2->__set("Fichero", $nombreArchivo);
          $dao3->Insertar($movimiento2);
          $estructura = './uploads/' . $_SESSION['usuario'];
          if (!is_dir($estructura)) {
            mkdir($estructura, 0777, true);
          }
          $location = './uploads/' . $_SESSION['usuario'] . '/' . $nombreArchivo;
          move_uploaded_file($_FILES['Archivo']['tmp_name'], $location);
          echo "<div class='alert alert-primary' role='alert'>
        Archivo subido!</div>";
        } else {
          echo "<div class='alert alert-danger' role='alert'>
        No hay espacio suficiente!</div>";
        }
      }
    } else {
      echo "<div class='alert alert-danger' role='alert'>
    Error: fichero no subido </div>";
    }
  }
  ?>
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
        <li class="nav-item active">
          <span class="sr-only">(current)</span>
          <a class="nav-link" href="#">Subir</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="admin_users.php">Usuarios</a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="button">
            <i class="fas fa-user"></i> Perfil </a>
          <div class="dropdown-menu dropdown-menu-right dropdown-info" aria-labelledby="navbarDropdownMenuLink-4">
            <a class="dropdown-item" href="admin_account.php">Cuenta</a>
            <a class="dropdown-item" href="logout.php">Cerrar sesión</a>
          </div>
        </li>
      </ul>
    </div>
  </nav>
  <!--/.Navbar -->
  <!-- Collapsible content -->
  <form name=f1 method=post action=# enctype="multipart/form-data">
    <div class="input-group p-5">
      <div class="input-group-prepend">
        <span class="input-group-text" id="inputGroupFileAddon01">Subir</span>
      </div>
      <div class="custom-file">
        <input name=Archivo lang="es" type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
        <label class="custom-file-label" for="inputGroupFile01">Elegir archivo</label>
      </div>
    </div>
    <input type=submit name="Subir" value="Subir" class="ml-5 btn btn-default">
  </form>
  <footer class="page-footer font-small">

    <!-- Copyright -->
    <div class="footer-copyright text-center py-3 default-color-dark fixed-bottom">© 2020 Copyright:
      <a href="https://cloudisk.000webhostapp.com/"> ClouDisk </a>
    </div>
    <!-- Copyright -->

  </footer>
</body>

</html>