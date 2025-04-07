<?php
error_reporting(E_ALL);
ini_set('display_errors', 0); // Desactivamos la visualización de errores
header('Content-Type: application/json');

try {
    require_once '../../config/conexion.php';
    require_once '../modelo/LoginModel.php';

    // Verificar método de solicitud
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método no permitido');
    }

    // Obtener datos del formulario
    $documento = $_POST['documento'];
    $email = $_POST['correo'];
    $clave = $_POST['clave'];

    // Log para depuración
    error_log("Datos recibidos - Documento: $documento, Email: $email");

    // Validar que todos los campos estén presentes
    if (empty($documento) || empty($email) || empty($clave)) {
        error_log("Campos vacíos detectados");
        echo json_encode(['success' => false, 'message' => 'Todos los campos son requeridos']);
        exit;
    }

    // Crear instancia del modelo
    $loginModel = new LoginModel($pdo);

    // Verificar credenciales
    $instructor = $loginModel->verificarCredenciales([
        'documento' => $documento,
        'email' => $email,
        'clave' => $clave
    ]);

    // Log para depuración
    error_log("Resultado de verificarCredenciales: " . ($instructor ? "éxito" : "fallo"));

    if ($instructor) {
        // Iniciar sesión
        if ($loginModel->iniciarSesion($instructor)) {
            echo json_encode([
                'success' => true,
                'message' => 'Login exitoso',
                'instructor' => $instructor
            ]);
        } else {
            throw new Exception('Error al iniciar sesión');
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Credenciales incorrectas'
        ]);
    }

} catch (Exception $e) {
    // Registrar error en el log
    error_log('Error en logininstructor.php: ' . $e->getMessage());
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} catch (Error $e) {
    // Registrar error fatal en el log
    error_log('Error fatal en logininstructor.php: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error interno del servidor'
    ]);
} 