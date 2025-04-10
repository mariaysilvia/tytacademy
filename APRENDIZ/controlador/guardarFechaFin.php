<?php
session_start();
require_once '../modelo/PruebaModel.php';

header('Content-Type: application/json');

try {
    // Obtener la fecha de fin del cuerpo de la petición
    $data = json_decode(file_get_contents('php://input'), true);
    $fechaFin = $data['fechaFin'];

    // Guardar la fecha de fin en la sesión
    $_SESSION['fechaFinPrueba'] = $fechaFin;

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
} 