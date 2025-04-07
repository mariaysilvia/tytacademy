<?php
session_start();
header('Content-Type: application/json');

require_once '../../config/conexion.php';
require_once '../modelo/AprendizModel.php';

try {
    // Obtener datos del formulario
    $documento = $_POST['documento'];
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

    // Validar que todos los campos estén presentes
    if (empty($documento) || empty($correo) || empty($contraseña)) {
        echo json_encode(['success' => false, 'message' => 'Todos los campos son requeridos']);
        exit;
    }

    // Crear instancia del modelo
    $aprendizModel = new AprendizModel($pdo);
    
    // Intentar login
    $usuario = $aprendizModel->login($documento, $correo, $contraseña);

    if ($usuario) {
        // Iniciar sesión
        $_SESSION['usuario_id'] = $usuario['idAprendiz'];
        $_SESSION['documento'] = $usuario['documento'];
        $_SESSION['nombres'] = $usuario['nombres'];
        $_SESSION['apellidos'] = $usuario['apellidos'];
        $_SESSION['correo'] = $usuario['correo'];

        echo json_encode([
            'success' => true,
            'message' => 'Inicio de sesión exitoso'
        ]);
    } else {
        echo json_encode([
            'success' => false, 
            'message' => 'Credenciales incorrectas'
        ]);
    }
} catch(PDOException $e) {
    error_log("Error en login: " . $e->getMessage());
    echo json_encode([
        'success' => false, 
        'message' => 'Error al procesar el inicio de sesión'
    ]);
}
?>

