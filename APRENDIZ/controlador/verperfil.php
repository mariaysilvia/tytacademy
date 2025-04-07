<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'message' => 'No has iniciado sesión']);
    exit;
}

require_once '../../config/conexion.php';
require_once '../modelo/AprendizModel.php';

try {
    $id_usuario = $_SESSION['usuario_id'];
    
    // Agregar un log para depuración
    error_log("Buscando usuario con ID: " . $id_usuario);
    
    $aprendizModel = new AprendizModel($pdo);
    $usuario = $aprendizModel->obtenerPerfil($id_usuario);

    if ($usuario) {
        error_log("Usuario encontrado: " . json_encode($usuario));

        echo json_encode([
            'success' => true,
            'data' => $usuario
        ]);
    } else {
        error_log("Usuario no encontrado para ID: " . $id_usuario);
        echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
    }
} catch(PDOException $e) {
    error_log("Error en verperfil.php: " . $e->getMessage());
    echo json_encode(['success' => false, 'message' => 'Error al obtener datos del perfil']);
}
?>