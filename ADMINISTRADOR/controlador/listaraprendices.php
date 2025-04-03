<?php
header('Content-Type: application/json');
ob_start(); // Inicia el buffer de salida

// Ajusta la ruta de 'conexion.php' según su ubicación real
include '../../config/conexion.php'; // Ruta corregida

try {
    // Consulta para obtener los aprendices
    $sql = "SELECT idAprendiz, documento, nombres, apellidos, correo, contraseña AS clave, celular FROM Aprendiz";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    // Obtener los resultados
    $aprendices = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Verificar si hay aprendices
    if (empty($aprendices)) {
        ob_clean(); // Limpia cualquier salida previa
        echo json_encode(['success' => false, 'message' => 'No hay aprendices disponibles.']);
    } else {
        ob_clean(); // Limpia cualquier salida previa
        echo json_encode(['success' => true, 'data' => $aprendices]);
    }
} catch (PDOException $e) {
    // Manejo de errores
    ob_clean(); // Limpia cualquier salida previa
    echo json_encode(['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
    error_log('Error en listaraprendices.php: ' . $e->getMessage());
} catch (Exception $e) {
    // Manejo de errores generales
    ob_clean();
    echo json_encode(['success' => false, 'message' => 'Error inesperado: ' . $e->getMessage()]);
    error_log('Error inesperado en listaraprendices.php: ' . $e->getMessage());
}

$pdo = null; // Cierra la conexión
ob_end_flush(); // Envía la salida del buffer
?>