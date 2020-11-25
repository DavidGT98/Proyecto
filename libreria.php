<?php

//Parámetros de Conexion

$host = 'localhost';
$user = 'root';
$pass = '';
/* $user = 'id15495097_localhost';
$pass = 'ykpw{0/<+?t7Jwg)'; */

function Conectar($base)         //Nos conectamos a esa BBDD con los parámetros seleccionados
{
  global $host;
  global $user;
  global $pass;

  $db = mysqli_connect($host, $user, $pass, $base);

  return $db;
}

function ConsultaSimple($db, $consulta)     //Ejecutamos una consulta que no devuelve datos
{
  if (!mysqli_query($db, $consulta)) {
    echo "Error en la consulta<br>";
  }
}

function ConsultaDatos($db, $consulta)     //Ejecutamos una consulta que no devuelve datos
{
  $Resul = array();    //Array de filas con los resultados de la consulta

  $Datos = mysqli_query($db, $consulta);

  if (!$Datos) {
    echo "Error en la Consulta";
  } else   //Si habia datos	
  {
    while ($fila = mysqli_fetch_array($Datos)) {
      $Resul[] = $fila;
    }
  }

  return $Resul;
}

function Cerrar($db)      //Cerramos la conexion
{
  mysqli_close($db);
}
