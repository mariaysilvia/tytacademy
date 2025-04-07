<?php
require '../../vendor/autoload.php';
require_once '../../config/conexion.php';
require_once '../modelo/EmailModel.php';

// Crear instancia del modelo
$emailModel = new EmailModel();

if (isset($_GET['nombre'], $_GET['email'], $_GET['mensaje'])) {
    $datos = [
        'nombre' => htmlspecialchars($_GET['nombre']),
        'email' => filter_var($_GET['email'], FILTER_SANITIZE_EMAIL),
        'mensaje' => htmlspecialchars($_GET['mensaje'])
    ];

    error_log("Intentando enviar correo a: " . $datos['email']);
    
    if ($emailModel->enviarCorreoBienvenida($datos['nombre'], $datos['email'])) {
        echo json_encode(['success' => true, 'message' => 'El mensaje de bienvenida se ha enviado correctamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Hubo un error al enviar el mensaje. Por favor, revisa los logs para más detalles.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Faltan datos en la solicitud']);
}
?>