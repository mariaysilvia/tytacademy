<?php
header('Content-Type: application/json');
require_once '../../config/conexion.php';
require_once '../modelo/PruebaModel.php';

try {
    // Obtener parámetros de la solicitud
    $idtemaModulo = $_GET['temaModulo'] ?? null;
    $cantidad = $_GET['cantidad'] ?? null;

    // Validar parámetros
    if (empty($idtemaModulo) || !is_numeric($idtemaModulo)) {
        throw new Exception('Debe seleccionar un tema válido.');
    }

    if (empty($cantidad) || !is_numeric($cantidad)) {
        throw new Exception('Debe especificar una cantidad válida de preguntas.');
    }

    // Conectar a la base de datos
    $conexion = new Conexion();
    $pdo = $conexion->conectar();

    // Obtener el módulo asociado al tema seleccionado
    session_start();
    $stmt = $pdo->prepare("SELECT idModulo FROM temaModulo WHERE idtemaModulo = :idtemaModulo");
    $stmt->bindParam(':idtemaModulo', $idtemaModulo, PDO::PARAM_INT);
    $stmt->execute();
    $modulo = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($modulo) {
        $_SESSION['modulo_id'] = $modulo['idModulo'];
    } else {
        throw new Exception('No se encontró un módulo asociado al tema seleccionado.');
    }


    // Registrar el valor de modulo_id en los logs para depuración
    error_log("modulo_id configurado en la sesión: " . $_SESSION['modulo_id']);

    // Crear instancia del modelo
    $pruebaModel = new PruebaModel($pdo);

    // Obtener preguntas por tema y cantidad
    $preguntas = $pruebaModel->obtenerPreguntasPorTipo($idtemaModulo, $cantidad);

    // Verificar si no hay preguntas
    if (empty($preguntas)) {
        throw new Exception('No se encontraron preguntas para el tema seleccionado.');
    }

    // Responder con las preguntas obtenidas
    echo json_encode([
        'success' => true,
        'preguntas' => $preguntas
    ]);

} catch (Exception $e) {
    // Manejo de errores
    error_log("Error en seleccionarPreguntas: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}