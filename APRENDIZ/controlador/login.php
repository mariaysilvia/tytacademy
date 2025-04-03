<?php
session_start();
header('Content-Type: application/json');

require_once '../../config/conexion.php';

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

    // Buscar usuario por documento y correo
    $stmt = $pdo->prepare("SELECT * FROM Aprendiz WHERE documento = ? AND correo = ?");
    $stmt->execute([$documento, $correo]);
    $usuario = $stmt->fetch();

    if ($usuario) {
        // Verificar la contraseña
        if (password_verify($contraseña, $usuario['contraseña'])) {
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
                'message' => 'Contraseña incorrecta'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false, 
            'message' => 'No existe un usuario con ese documento y correo'
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

