<?php
require_once '../modelo/PruebaModel.php';
require_once '../modelo/AprendizModel.php';

session_start();

header('Content-Type: application/json');

try {
    // Verificar si el usuario está logueado
    if (!isset($_SESSION['idAprendiz'])) {
        throw new Exception('Debe iniciar sesión para realizar la prueba');
    }

    // Obtener datos del POST
    $respuestas = $_POST['respuestas'] ?? [];
    $tipoPrueba = $_POST['tipoPrueba'] ?? '';
    $tiempoTotal = $_POST['tiempoTotal'] ?? 0;
    $idAprendiz = $_SESSION['idAprendiz'];

    // Validaciones
    if (empty($respuestas)) {
        throw new Exception('No se recibieron respuestas');
    }

    if (empty($tipoPrueba)) {
        throw new Exception('No se especificó el tipo de prueba');
    }

    if (!is_array($respuestas)) {
        throw new Exception('Formato de respuestas inválido');
    }

    // Verificar duplicados
    $preguntasRespondidas = array_keys($respuestas);
    if (count($preguntasRespondidas) !== count(array_unique($preguntasRespondidas))) {
        throw new Exception('Hay preguntas duplicadas en las respuestas');
    }

    // Crear instancia del modelo
    $pruebaModel = new PruebaModel($tipoPrueba);

    // Guardar la prueba con tiempo total
    $idPrueba = $pruebaModel->guardarPrueba($idAprendiz, $tiempoTotal);

    // Guardar las respuestas y calcular resultados
    $resultados = $pruebaModel->guardarRespuestas($idPrueba, $respuestas);

    // Calcular porcentaje
    $totalPreguntas = count($respuestas);
    $porcentaje = ($resultados['correctas'] / $totalPreguntas) * 100;

    // Devolver resultados detallados
    echo json_encode([
        'success' => true,
        'totalPreguntas' => $totalPreguntas,
        'correctas' => $resultados['correctas'],
        'incorrectas' => $resultados['incorrectas'],
        'porcentaje' => round($porcentaje, 2),
        'tiempoTotal' => $tiempoTotal,
        'mensaje' => generarMensajeResultado($porcentaje)
    ]);

} catch (Exception $e) {
    error_log("Error en corregirPrueba: " . $e->getMessage());
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}

function generarMensajeResultado($porcentaje) {
    if ($porcentaje >= 80) {
        return "¡Excelente trabajo! Has demostrado un gran dominio del tema.";
    } elseif ($porcentaje >= 60) {
        return "Buen trabajo. Sigue practicando para mejorar tus resultados.";
    } else {
        return "Necesitas practicar más. Revisa los temas y vuelve a intentarlo.";
    }
} 