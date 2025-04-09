<?php
header('Content-Type: application/json');
require_once '../../config/conexion.php';
require_once '../modelo/PruebaModel.php';

// Habilitar el registro de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $rawData = file_get_contents('php://input');
        error_log("Datos recibidos: " . $rawData);
        
        $data = json_decode($rawData, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Error al decodificar JSON: ' . json_last_error_msg());
        }
        
        error_log("Datos decodificados: " . print_r($data, true));
        
        if (!isset($data['tipoPrueba']) || !isset($data['areas']) || !isset($data['preguntas'])) {
            throw new Exception('Faltan parámetros requeridos');
        }

        // Determinar qué modelo de prueba usar según el tipo
        $modelo = null;
        switch ($data['tipoPrueba']) {
            case 'comunicacion':
                require_once '../modelo/PruebaComunicacionModel.php';
                $modelo = new PruebaComunicacionModel($pdo);
                break;
            case 'critica':
                require_once '../modelo/PruebaCriticaModel.php';
                $modelo = new PruebaCriticaModel($pdo);
                break;
            case 'razonamiento':
                require_once '../modelo/PruebaRazonamientoModel.php';
                $modelo = new PruebaRazonamientoModel($pdo);
                break;
            case 'ciudadana':
                require_once '../modelo/PruebaCiudadanaModel.php';
                $modelo = new PruebaCiudadanaModel($pdo);
                break;
            case 'ingles':
                require_once '../modelo/PruebaInglesModel.php';
                $modelo = new PruebaInglesModel($pdo);
                break;
            default:
                throw new Exception('Tipo de prueba no válido');
        }

        error_log("Modelo seleccionado: " . get_class($modelo));

        // Obtener las preguntas
        $preguntas = $modelo->obtenerPreguntasPorTipo($data['areas'], $data['preguntas']);
        
        error_log("Preguntas obtenidas: " . print_r($preguntas, true));
        
        if (empty($preguntas)) {
            echo json_encode(['success' => false, 'message' => 'No se encontraron preguntas para los criterios especificados']);
        } else {
            echo json_encode(['success' => true, 'data' => $preguntas], JSON_UNESCAPED_UNICODE);
        }
    } catch (Exception $e) {
        error_log("Error en seleccionarPreguntas.php: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido'], JSON_UNESCAPED_UNICODE);
} 