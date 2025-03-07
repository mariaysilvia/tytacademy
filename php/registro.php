<?php
header('Content-Type: application/json');
require_once '../php/conexion.php';

function validarPassword($password) {
    if (strlen($password) < 8) return false;
    if (!preg_match('/[0-9]/', $password)) return false;
    if (!preg_match('/[A-Z]/', $password)) return false;
    if (!preg_match('/[a-z]/', $password)) return false;
    return true;
}

try {
    // Verificar método HTTP
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Método no permitido');
    }

    // Obtener y limpiar datos
    $documento = trim($_POST['documento'] ?? '');
    $nombres = trim($_POST['nombres'] ?? '');
    $apellidos = trim($_POST['apellidos'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $password_sin_hash = trim($_POST['contraseña'] ?? '');
    $celular = trim($_POST['celular'] ?? '');

    // Validar campos requeridos
    if (empty($documento) || empty($nombres) || empty($apellidos) || 
        empty($correo) || empty($password_sin_hash)) {
        throw new Exception('Todos los campos son requeridos');
    }

    // Validar formato del documento
    if (!preg_match('/^\d+$/', $documento)) {
        throw new Exception('El documento debe contener solo números');
    }

    // Validar contraseña
    if (!validarPassword($password_sin_hash)) {
        throw new Exception('La contraseña debe tener al menos 8 caracteres, incluir mayúsculas, minúsculas y números');
    }

    // Iniciar transacción
    $pdo->beginTransaction();

    // Verificar documento y correo duplicados en una sola consulta
    $stmt = $pdo->prepare("
        SELECT 
            SUM(CASE WHEN documento = ? THEN 1 ELSE 0 END) as doc_count,
            SUM(CASE WHEN correo = ? THEN 1 ELSE 0 END) as email_count
        FROM Aprendiz
    ");
    $stmt->execute([$documento, $correo]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['doc_count'] > 0) {
        throw new Exception('Este documento ya está registrado');
    }
    if ($result['email_count'] > 0) {
        throw new Exception('Este correo electrónico ya está registrado');
    }

    // Hash de la contraseña
    $contraseña_hash = password_hash($password_sin_hash, PASSWORD_DEFAULT);

    // Preparar la inserción
    $stmt = $pdo->prepare("
        INSERT INTO Aprendiz (documento, nombres, apellidos, correo, contraseña, celular) 
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    // Ejecutar la inserción
    if (!$stmt->execute([$documento, $nombres, $apellidos, $correo, $contraseña_hash, $celular])) {
        throw new Exception('Error al insertar en la base de datos: ' . implode(', ', $stmt->errorInfo()));
    }

    // Confirmar transacción
    $pdo->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Registro exitoso'
    ]);

} catch (Exception $e) {
    // Revertir transacción si hay error
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    // Log del error
    error_log("Error en registro.php: " . $e->getMessage());

    // Respuesta de error
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?>