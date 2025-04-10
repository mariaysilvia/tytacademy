<?php
header('Content-Type: application/json');
require_once '../../config/conexion.php';
require_once '../modelo/PruebaModel.php';

try {
    // Verificar que la conexión a la base de datos esté disponible
    if (!isset($pdo)) {
        throw new Exception('No se pudo establecer la conexión con la base de datos.');
    }

    $tipoPrueba = $_GET['tipoPrueba'] ?? '';
    
    if (empty($tipoPrueba)) {
        throw new Exception('Tipo de prueba no especificado.');
    }

    $pruebaModel = new PruebaModel($pdo, $tipoPrueba);
    $temas = $pruebaModel->obtenerTemasPorTipoPrueba();

    if (!is_array($temas) || empty($temas)) {
        throw new Exception('No se encontraron temas para el tipo de prueba especificado.');
    }
    
    echo json_encode([
        'success' => true,
        'temas' => $temas
    ]);

} catch (Exception $e) {
    error_log("Error en obtenerTemas: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}