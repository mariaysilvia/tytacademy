<?php
header('Content-Type: application/json');
ob_start(); // Inicia el buffer de salida

// Ajusta la ruta de 'conexion.php' según su ubicación real
include '../../config/conexion.php'; // Ruta corregida
require_once '../modelo/InstructorModel.php';

// Verificar si es una solicitud POST para eliminar un instructor
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el cuerpo de la solicitud
    $data = json_decode(file_get_contents('php://input'), true);
    
    // Verificar si es una acción de eliminar
    if (isset($data['action']) && $data['action'] === 'eliminarInstructor' && isset($data['id'])) {
        try {
            // Crear instancia del modelo
            $instructorModel = new InstructorModel($pdo);
            
            // Intentar eliminar el instructor
            $resultado = $instructorModel->eliminarInstructor($data['id']);
            
            if ($resultado) {
                ob_clean(); // Limpia cualquier salida previa
                echo json_encode(['success' => true, 'message' => 'Instructor eliminado correctamente.']);
            } else {
                ob_clean(); // Limpia cualquier salida previa
                echo json_encode(['success' => false, 'message' => 'No se pudo eliminar el instructor.']);
            }
        } catch (PDOException $e) {
            // Manejo de errores
            ob_clean(); // Limpia cualquier salida previa
            echo json_encode(['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
            error_log('Error en listarinstructores.php (eliminar): ' . $e->getMessage());
        } catch (Exception $e) {
            // Manejo de errores generales
            ob_clean();
            echo json_encode(['success' => false, 'message' => 'Error inesperado: ' . $e->getMessage()]);
            error_log('Error inesperado en listarinstructores.php (eliminar): ' . $e->getMessage());
        }
        
        $pdo = null; // Cierra la conexión
        ob_end_flush(); // Envía la salida del buffer
        exit; // Termina la ejecución
    }
}

try {
    // Crear instancia del modelo
    $instructorModel = new InstructorModel($pdo);
    
    // Obtener los instructores
    $instructores = $instructorModel->obtener();
    
    // Verificar si hay instructores
    if (empty($instructores)) {
        ob_clean(); // Limpia cualquier salida previa
        echo json_encode(['success' => false, 'message' => 'No hay instructores disponibles.']);
    } else {
        ob_clean(); // Limpia cualquier salida previa
        echo json_encode(['success' => true, 'data' => $instructores]);
    }
} catch (PDOException $e) {
    // Manejo de errores
    ob_clean(); // Limpia cualquier salida previa
    echo json_encode(['success' => false, 'message' => 'Error en la base de datos: ' . $e->getMessage()]);
    error_log('Error en listarinstructores.php: ' . $e->getMessage());
} catch (Exception $e) {
    // Manejo de errores generales
    ob_clean();
    echo json_encode(['success' => false, 'message' => 'Error inesperado: ' . $e->getMessage()]);
    error_log('Error inesperado en listarinstructores.php: ' . $e->getMessage());
}

$pdo = null; // Cierra la conexión
ob_end_flush(); // Envía la salida del buffer
?>