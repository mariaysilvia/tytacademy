<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

try {
    require_once '../../config/conexion.php';
    require_once '../modelo/PreguntaModel.php';
    
    // Verificar si el instructor está logueado
    if (!isset($_SESSION['instructor'])) {
        echo json_encode(['success' => false, 'message' => 'No autorizado']);
        exit;
    }
    
    $instructor = $_SESSION['instructor'];
    $preguntaModel = new PreguntaModel($pdo);
    
    // Log para depuración
    error_log("Datos del instructor en sesión: " . print_r($instructor, true));
    
    // Obtener el método de la solicitud
    $method = $_SERVER['REQUEST_METHOD'];
    
    switch ($method) {
        case 'GET':
            if (isset($_GET['accion'])) {
                switch ($_GET['accion']) {
                    case 'tipos':
                        $tipos = $preguntaModel->obtenerTiposPregunta();
                        echo json_encode(['success' => true, 'tipos' => $tipos]);
                        break;
                    
                    case 'temas':
                        $temas = $preguntaModel->obtenerTemasModulo($instructor['idInstructor']);
                        echo json_encode(['success' => true, 'temas' => $temas]);
                        break;
                    
                    case 'obtener':
                        if (!isset($_GET['id'])) {
                            throw new Exception('ID de pregunta no proporcionado');
                        }
                        
                        $pregunta = $preguntaModel->getPreguntaPorId($_GET['id']);
                        if (!$pregunta || $pregunta['idModulo'] != $instructor['idModulo']) {
                            throw new Exception('Pregunta no encontrada o no autorizada');
                        }
                        
                        $respuestas = $preguntaModel->getRespuestasPregunta($_GET['id']);
                        echo json_encode(['success' => true, 'pregunta' => $pregunta, 'respuestas' => $respuestas]);
                        break;
                    
                    case 'eliminar':
                        if (!isset($_GET['id'])) {
                            throw new Exception('ID de pregunta no proporcionado');
                        }
                        
                        $pregunta = $preguntaModel->getPreguntaPorId($_GET['id']);
                        if (!$pregunta || $pregunta['idModulo'] != $instructor['idModulo']) {
                            throw new Exception('Pregunta no encontrada o no autorizada');
                        }
                        
                        $resultado = $preguntaModel->eliminarPregunta($_GET['id']);
                        echo json_encode(['success' => $resultado]);
                        break;
                    
                    default:
                        echo json_encode(['success' => false, 'message' => 'Acción no válida']);
                        break;
                }
            } else {
                // Si no se especifica acción, devolvemos los tipos de pregunta por defecto
                $tipos = $preguntaModel->obtenerTiposPregunta();
                echo json_encode(['success' => true, 'tipos' => $tipos]);
            }
            break;
            
        case 'POST':
            try {
                // Validar campos requeridos
                $camposRequeridos = ['pregunta', 'idtipoPregunta', 'idtemaModulo', 'opcionA', 'opcionB', 'opcionC', 'opcionD', 'respuestaCorrecta'];
                foreach ($camposRequeridos as $campo) {
                    if (!isset($_POST[$campo]) || empty($_POST[$campo])) {
                        throw new Exception("El campo $campo es requerido");
                    }
                }
                
                // Procesar imagen de la pregunta si existe
                $imagenPregunta = null;
                if (isset($_FILES['imagenPregunta']) && $_FILES['imagenPregunta']['error'] === UPLOAD_ERR_OK) {
                    $imagenPregunta = $_FILES['imagenPregunta'];
                }
                
                // Preparar datos de la pregunta
                $datosPregunta = [
                    'pregunta' => $_POST['pregunta'],
                    'idtipoPregunta' => $_POST['idtipoPregunta'],
                    'idtemaModulo' => $_POST['idtemaModulo'],
                    'imagenPregunta' => $imagenPregunta
                ];
                
                // Verificar si el instructor tiene un módulo asignado
                if (!isset($instructor['idModulo']) || empty($instructor['idModulo'])) {
                    throw new Exception("El instructor no tiene un módulo asignado");
                }
                
                $datosPregunta['idModulo'] = $instructor['idModulo'];
                
                // Preparar datos de las respuestas
                $respuestas = [
                    [
                        'texto' => $_POST['opcionA'],
                        'esCorrecta' => $_POST['respuestaCorrecta'] == 0
                    ],
                    [
                        'texto' => $_POST['opcionB'],
                        'esCorrecta' => $_POST['respuestaCorrecta'] == 1
                    ],
                    [
                        'texto' => $_POST['opcionC'],
                        'esCorrecta' => $_POST['respuestaCorrecta'] == 2
                    ],
                    [
                        'texto' => $_POST['opcionD'],
                        'esCorrecta' => $_POST['respuestaCorrecta'] == 3
                    ]
                ];
                
                // Guardar pregunta y respuestas
                $resultado = $preguntaModel->guardarPregunta($datosPregunta, $respuestas);
                
                if ($resultado) {
                    echo json_encode(['success' => true, 'message' => 'Pregunta guardada exitosamente']);
                } else {
                    error_log("Error al guardar la pregunta: No se pudo completar la operación");
                    echo json_encode(['success' => false, 'message' => 'Error al guardar la pregunta. Por favor, intente nuevamente.']);
                }
                
            } catch (Exception $e) {
                error_log('Error en pregunta.php: ' . $e->getMessage());
                echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            }
            break;
            
        default:
            throw new Exception('Método no permitido');
    }
    
} catch (Exception $e) {
    error_log('Error en pregunta.php: ' . $e->getMessage());
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
} catch (Error $e) {
    error_log('Error fatal en pregunta.php: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error interno del servidor']);
} 