<?php
header('Content-Type: application/json');
require_once '../../config/conexion.php';
require_once '../modelo/AprendizModel.php';
require_once '../modelo/EmailModel.php';

try {
    // Verificar método HTTP
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        echo json_encode([
            'success' => false,
            'message' => 'Método no permitido'
        ]);
        exit;
    }

    // Validar que se reciban los datos esperados
    if (!isset($_POST['documento']) || !isset($_POST['nombres']) || !isset($_POST['apellidos']) || 
        !isset($_POST['correo']) || !isset($_POST['contraseña']) || !isset($_POST['celular'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Faltan datos en la solicitud'
        ]);
        exit;
    }

    // Limpiar el búfer de salida
    if (ob_get_length()) {
        ob_clean();
    }

    // Obtener y limpiar datos
    $documento = trim($_POST['documento']);
    $nombres = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $correo = trim($_POST['correo']);
    $password = trim($_POST['contraseña']);
    $celular = trim($_POST['celular'] ?? '');

    // Validar campos requeridos
    if (empty($documento) || empty($nombres) || empty($apellidos) || 
        empty($correo) || empty($password)) {
        throw new Exception('Todos los campos son requeridos');
    }

    // Validar formato del documento
    if (!preg_match('/^\d+$/', $documento)) {
        throw new Exception('El documento debe contener solo números');
    }

    // Crear instancia del modelo de aprendiz
    $aprendizModel = new AprendizModel($pdo);

    // Validar contraseña
    if (!$aprendizModel->validarPassword($password)) {
        throw new Exception('La contraseña debe tener al menos 8 caracteres, incluir mayúsculas, minúsculas y números');
    }

    // Iniciar transacción
    $pdo->beginTransaction();

    // Registrar aprendiz
    if (!$aprendizModel->registrar($documento, $nombres, $apellidos, $correo, $password, $celular)) {
        throw new Exception('Error al registrar el aprendiz');
    }

    // Confirmar transacción
    $pdo->commit();

    // Enviar correo de bienvenida
    $emailModel = new EmailModel();
    if (!$emailModel->enviarCorreoBienvenida($nombres, $correo)) {
        error_log("⚠️ No se pudo enviar el correo de bienvenida a $correo");
    }

    echo json_encode([
        'success' => true,
        'message' => 'Registro exitoso'
    ]);

} catch (Exception $e) {
    // Revertir transacción si hay error
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    error_log("Error en registro.php: " . $e->getMessage());

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>