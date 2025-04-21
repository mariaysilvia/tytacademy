<?php
session_start();
require_once '../../config/conexion.php'; // Ajusta la ruta si es necesario
require_once '../modelo/PruebaModel.php'; // Modelo para manejar la lógica de preguntas

// Validar parámetros
$temaId = $_GET['temaModulo'] ?? null;
$cantidad = $_GET['cantidad'] ?? null;

if (!$temaId || !$cantidad || !is_numeric($cantidad)) {
    header("Location: /trabajos/PruebasTYT/APRENDIZ/vista/PRUEBAS.php?error=Faltan parámetros o cantidad inválida");
    exit;
}

// Guardar módulo en la sesión
$_SESSION['modulo_id'] = obtenerModuloDesdeTema($temaId); // Función para obtener el módulo desde el tema

try {
    // Crear instancia del modelo
    $pdo = new PDO("mysql:host=localhost;dbname=basededatostytacademy;charset=utf8", "root", "1234");
    $pruebaModel = new PruebaModel($pdo);

    // Obtener preguntas
    $preguntas = $pruebaModel->obtenerPreguntasPorTipo($temaId, $cantidad);

    if (empty($preguntas)) {
        header("Location: /trabajos/PruebasTYT/APRENDIZ/vista/PRUEBAS.php?error=No se encontraron preguntas");
        exit;
    }

    // Guardar preguntas en la sesión
    $_SESSION['preguntas'] = $preguntas;

    // Redirigir a la vista de la prueba
    header("Location: /trabajos/PruebasTYT/simulacropruebas/pruebas.php");
    exit;

} catch (Exception $e) {
    error_log("Error en realizarPrueba.php: " . $e->getMessage());
    header("Location: /trabajos/PruebasTYT/APRENDIZ/vista/PRUEBAS.php?error=Error al obtener preguntas");
    exit;
}

// Función opcional para obtener el módulo desde el tema
function obtenerModuloDesdeTema($temaId) {
    // Aquí puedes implementar la lógica para obtener el módulo desde el tema
    return $temaId; // Cambia esto según tu lógica
}