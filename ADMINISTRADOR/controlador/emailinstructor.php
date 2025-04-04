<?php
require '../../vendor/autoload.php';
include '../../config/conexion.php';
require_once '../modelo/EmailModel.php';

// Crear instancia del modelo
$emailModel = new EmailModel($pdo);

if (isset($_GET['nombre'], $_GET['email'], $_GET['clave'], $_GET['modulo'], $_GET['documento'])) {
    $datos = [
        'nombre' => htmlspecialchars($_GET['nombre']),
        'email' => filter_var($_GET['email'], FILTER_SANITIZE_EMAIL),
        'clave' => htmlspecialchars($_GET['clave']),
        'modulo' => htmlspecialchars($_GET['modulo']),
        'documento' => htmlspecialchars($_GET['documento'])
    ];

    error_log("Intentando enviar correo a: " . $datos['email']);
    
    if ($emailModel->enviarCorreoBienvenida($datos)) {
        echo json_encode(['success' => true, 'message' => 'El mensaje de bienvenida se ha enviado correctamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Hubo un error al enviar el mensaje. Por favor, revisa los logs para más detalles.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Faltan datos en la solicitud']);
}
?>