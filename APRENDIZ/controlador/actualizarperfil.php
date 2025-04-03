<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['success' => false, 'message' => 'No has iniciado sesión']);
    exit;
}

require_once '../../config/conexion.php';

try {
    $id_usuario = $_SESSION['usuario_id'];
    $datos = json_decode(file_get_contents('php://input'), true);

    $stmt = $pdo->prepare("UPDATE Aprendiz SET 
        nombres = ?, 
        apellidos = ?, 
        correo = ?, 
        celular = ? 
        WHERE idAprendiz = ?");
    
    $stmt->execute([
        $datos['nombres'],
        $datos['apellidos'],
        $datos['correo'],
        $datos['celular'],
        $id_usuario
    ]);

    echo json_encode(['success' => true, 'message' => 'Perfil actualizado correctamente']);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error al actualizar el perfil']);
}
?>