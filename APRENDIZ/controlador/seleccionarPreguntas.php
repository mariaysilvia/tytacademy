<?php
header('Content-Type: application/json');
require_once '../../config/conexion.php';
require_once '../modelo/PruebaModel.php';

// Habilitar el registro de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $idtemaModulo = $_GET['temaModulo'] ?? '';
    $cantidad = $_GET['cantidad'] ?? 10;

    if (empty($idtemaModulo)) {
        throw new Exception('Debe seleccionar un tema');
    }
    
    $conexion = new Conexion();
    $pdo = $conexion->conectar();
    
    // Primero obtenemos el tipo de prueba basado en el tema
    $sql = "SELECT m.modulo FROM temaModulo tm 
            JOIN Modulo m ON tm.idModulo = m.idModulo 
            WHERE tm.idtemaModulo = :idtemaModulo";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':idtemaModulo', $idtemaModulo, PDO::PARAM_INT);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$resultado) {
        throw new Exception('No se encontró el módulo correspondiente');
    }
    
    $tipoPrueba = $resultado['modulo'];
    
    $pruebaModel = new PruebaModel($pdo, $tipoPrueba);
    $preguntas = $pruebaModel->obtenerPreguntasPorTema($idtemaModulo, $cantidad);
    
    echo json_encode([
        'success' => true,
        'preguntas' => $preguntas
    ]);

} catch (Exception $e) {
    error_log("Error en seleccionarPreguntas: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}