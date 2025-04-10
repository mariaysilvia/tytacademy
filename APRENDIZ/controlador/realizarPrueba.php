<?php
require_once '../../config/conexion.php';
require_once '../modelo/PruebaModel.php';

// Obtener parámetros de la URL
$temaModulo = $_GET['temaModulo'] ?? '';
$cantidad = $_GET['cantidad'] ?? 10;

if (empty($temaModulo)) {
    header('Location: ../vista/PRUEBAS.php?error=Debe seleccionar un tema');
    exit;
}

try {
    // Usar la conexión PDO que ya está definida en conexion.php
    global $pdo;
    
    // Obtener el tipo de prueba basado en el tema
    $sql = "SELECT m.modulo, tm.nombreTema FROM temaModulo tm 
            JOIN Modulo m ON tm.idModulo = m.idModulo 
            WHERE tm.idtemaModulo = :idtemaModulo";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':idtemaModulo', $temaModulo, PDO::PARAM_INT);
    $stmt->execute();
    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$resultado) {
        throw new Exception('No se encontró el módulo correspondiente');
    }
    
    $tipoPrueba = $resultado['modulo'];
    $tipoTexto = $resultado['nombreTema'];
    
    // Instanciar el modelo y obtener las preguntas
    $pruebaModel = new PruebaModel($pdo, $tipoPrueba);
    $preguntas = $pruebaModel->obtenerPreguntasPorTipo($tipoTexto, $cantidad);
    
    if (empty($preguntas)) {
        throw new Exception('No se encontraron preguntas para el tema seleccionado');
    }
    
    // Guardar las preguntas en la sesión
    session_start();
    $_SESSION['preguntas'] = $preguntas;
    $_SESSION['tipoPrueba'] = $tipoPrueba;
    $_SESSION['temaModulo'] = $temaModulo;
    $_SESSION['cantidad'] = $cantidad;
    
    // Redirigir a la página de prueba general
    header('Location: /trabajos/PruebasTYT/simulacropruebas/prueba.php');
    exit;
    
} catch (Exception $e) {
    error_log("Error en realizarPrueba: " . $e->getMessage());
    header('Location: ../vista/PRUEBAS.php?error=' . urlencode($e->getMessage()));
    exit;
} 