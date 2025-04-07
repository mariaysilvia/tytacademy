<?php
// Activar reporting de errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Establecer encabezados JSON de manera estricta
header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

require_once '../../config/conexion.php';
require_once '../modelo/PruebaCiudadanaModel.php';
require_once 'PruebaController.php';

$modelo = new PruebaCiudadanaModel($pdo);
$controlador = new PruebaController($pdo, $modelo);

$controlador->procesarSolicitud();