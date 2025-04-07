<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

require_once '../../config/conexion.php';
require_once '../../ADMINISTRADOR/modelo/InstructorModel.php';

try {
    // Verificar método de solicitud
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método no permitido');
    }

    // Obtener y decodificar datos JSON
    $datos = json_decode(file_get_contents('php://input'), true);
    
    if (!$datos) {
        throw new Exception('Datos inválidos');
    }

    // Validar datos requeridos
    if (empty($datos['documento']) || empty($datos['email']) || empty($datos['clave'])) {
        throw new Exception('Todos los campos son requeridos');
    }

    // Crear instancia del modelo
    $instructorModel = new InstructorModel($pdo);

    // Intentar login
    $resultado = $instructorModel->login(
        $datos['documento'],
        $datos['email'],
        $datos['clave']
    );

    if ($resultado) {
        // Iniciar sesión
        session_start();
        $_SESSION['instructor'] = $resultado;
        
        echo json_encode([
            'exito' => true,
            'mensaje' => 'Login exitoso',
            'instructor' => $resultado
        ]);
    } else {
        echo json_encode([
            'exito' => false,
            'mensaje' => 'Credenciales incorrectas'
        ]);
    }

} catch (Exception $e) {
    error_log('Error en logininstructor.php: ' . $e->getMessage());
    echo json_encode([
        'exito' => false,
        'mensaje' => $e->getMessage()
    ]);
} 