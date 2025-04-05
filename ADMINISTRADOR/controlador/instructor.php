<?php
// Habilitar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Configurar el tipo de contenido como JSON
header('Content-Type: application/json');

// Iniciar el buffer de salida
ob_start();

try {
    // Incluir archivos necesarios
    require_once '../../config/conexion.php';
    
    // Verificar si la conexión a la base de datos está establecida
    if (!isset($pdo) || !$pdo) {
        throw new Exception('Error: No se pudo establecer la conexión a la base de datos');
    }

    // Verificar si los modelos existen
    if (!file_exists('../modelo/InstructorModel.php')) {
        throw new Exception('Error: No se encontró el archivo InstructorModel.php');
    }

    require_once '../modelo/InstructorModel.php';

    // Obtener y decodificar los datos JSON
    $input = file_get_contents("php://input");
    if ($input === false) {
        throw new Exception('Error al leer los datos de entrada');
    }

    $data = json_decode($input, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        throw new Exception('Error al decodificar JSON: ' . json_last_error_msg());
    }

    // Crear instancia del modelo de instructor
    $instructorModel = new InstructorModel($pdo);

    if ($data && isset($data['action'])) {
        if ($data['action'] === 'getModulos') {
            try {
                $modulos = $instructorModel->getModulos();
                
                if (empty($modulos)) {
                    echo json_encode(['success' => false, 'message' => 'No hay módulos disponibles.']);
                } else {
                    echo json_encode(['success' => true, 'data' => $modulos]);
                }
            } catch (Exception $e) {
                throw new Exception('Error al obtener módulos: ' . $e->getMessage());
            }
            exit;
        } 
        
        elseif ($data['action'] === 'guardarInstructor') {
            // Solo cargar EmailModel cuando sea necesario
            if (!file_exists('../modelo/EmailModel.php')) {
                throw new Exception('Error: No se encontró el archivo EmailModel.php');
            }
            require_once '../modelo/EmailModel.php';
            $emailModel = new EmailModel($pdo);

            if (!$instructorModel->validarDatos($data)) {
                echo json_encode(['success' => false, 'message' => 'Todos los campos obligatorios deben ser completados.']);
                exit;
            }

            // Guardar la clave original antes de encriptarla
            $data['clave_original'] = $data['clave'];
            $data['clave'] = password_hash($data['clave'], PASSWORD_BCRYPT);
            
            if ($instructorModel->guardarInstructor($data)) {
                try {
                    // Enviar correo de bienvenida
                    if ($emailModel->enviarCorreoBienvenida($data)) {
                        echo json_encode([
                            'success' => true, 
                            'message' => 'Instructor guardado exitosamente y correo enviado.'
                        ]);
                    } else {
                        echo json_encode([
                            'success' => true, 
                            'message' => 'Instructor guardado exitosamente, pero hubo un error al enviar el correo.'
                        ]);
                    }
                } catch (Exception $e) {
                    error_log("Error al enviar correo: " . $e->getMessage());
                    echo json_encode([
                        'success' => true, 
                        'message' => 'Instructor guardado exitosamente, pero hubo un error al enviar el correo.'
                    ]);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al guardar el instructor en la base de datos.']);
            }
            exit;
        } 
        elseif ($data['action'] === 'actualizarInstructor') {
            // Validar que los campos obligatorios no estén vacíos
            if (empty($data['id']) || empty($data['nombre']) || empty($data['apellido']) || 
                empty($data['documento']) || empty($data['email']) || empty($data['modulo'])) {
                echo json_encode(['success' => false, 'message' => 'Todos los campos obligatorios deben ser completados.']);
                exit;
            }
            
            // Actualizar el instructor
            if ($instructorModel->actualizarInstructor($data)) {
                echo json_encode(['success' => true, 'message' => 'Instructor actualizado exitosamente.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al actualizar el instructor en la base de datos.']);
            }
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Acción no válida.']);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Datos inválidos.']);
        exit;
    }
} catch (Exception $e) {
    // Limpiar cualquier salida previa
    ob_clean();
    // Enviar error en formato JSON
    echo json_encode([
        'success' => false, 
        'message' => 'Error en el servidor: ' . $e->getMessage()
    ]);
    exit;
}

// Limpiar el buffer y enviar la salida
ob_end_flush();
?>
