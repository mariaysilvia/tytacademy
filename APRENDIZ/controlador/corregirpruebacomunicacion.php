<?php
// Activar reporting de errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Establecer encabezados JSON de manera estricta
header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

require_once '../../config/conexion.php';
require_once '../modelo/PruebaComunicacionModel.php';
require_once 'PruebaController.php';

// Crear instancia del modelo
$modelo = new PruebaComunicacionModel($pdo);

// Crear instancia del controlador
$controlador = new PruebaController($pdo, $modelo);

// Procesar la solicitud
$controlador->procesarSolicitud();
?>