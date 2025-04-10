<?php
session_start();
require_once '../modelo/PruebaModel.php';

header('Content-Type: application/json');

try {
    // Obtener la fecha de inicio del cuerpo de la petición
    $data = json_decode(file_get_contents('php://input'), true);
    $fechaInicio = $data['fechaInicio'];

    // Guardar la fecha de inicio en la sesión
    $_SESSION['fechaInicioPrueba'] = $fechaInicio;

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
} 