<?php
header('Content-Type: application/json');
ob_start(); // Inicia el buffer de salida
include '../../config/conexion.php'; // Ruta corregida

// Mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$data = json_decode(file_get_contents("php://input"));
error_log("Datos recibidos: " . json_encode($data));

try {
    if ($data && isset($data->action)) {
        error_log("Acción recibida: " . $data->action);
        
        if ($data->action === 'getModulos') {
            // Consulta para obtener los módulos disponibles
            $stmt = $pdo->query("SELECT idModulo, modulo FROM Modulo");
            $modulos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            ob_clean();
            if (empty($modulos)) {
                echo json_encode(['success' => false, 'message' => 'No hay módulos disponibles.']);
            } else {
                echo json_encode(['success' => true, 'data' => $modulos]);
            }
        } elseif ($data->action === 'guardarInstructor') {
            error_log("Datos recibidos para guardar: " . json_encode($data));

            // Validación de campos obligatorios
            $documento = $data->documento;
            $nombre = $data->nombre;
            $apellido = $data->apellido;
            $email = $data->email;
            $clave = password_hash($data->clave, PASSWORD_BCRYPT);
            $celular = $data->celular;
            $modulo = $data->modulo;

            if (!$documento || !$nombre || !$apellido || !$email || !$clave || !$modulo) {
                error_log("❌ Campos obligatorios faltantes");
                ob_clean();
                echo json_encode(['success' => false, 'message' => 'Todos los campos obligatorios deben ser completados.']);
                exit;
            }

            // Preparar la consulta SQL con PDO
            $stmt = $pdo->prepare("INSERT INTO Instructor (documento, nombre, apellido, email, clave, celular, idModulo) VALUES (?, ?, ?, ?, ?, ?, ?)");
            
            if ($stmt->execute([$documento, $nombre, $apellido, $email, $clave, $celular, $modulo])) {
                error_log("✅ Instructor guardado exitosamente");
                
                // Intentar enviar el correo
                try {
                    require_once 'emailinstructor.php';
                    $correoEnviado = enviarCorreoBienvenida($nombre, $email, $data->clave, $modulo, $documento);
                    
                    if ($correoEnviado) {
                        ob_clean();
                        echo json_encode(['success' => true, 'message' => 'Instructor guardado exitosamente y correo enviado.']);
                    } else {
                        ob_clean();
                        echo json_encode(['success' => true, 'message' => 'Instructor guardado exitosamente, pero hubo un error al enviar el correo.']);
                    }
                } catch (Exception $e) {
                    error_log("Error al enviar el correo: " . $e->getMessage());
                    ob_clean();
                    echo json_encode(['success' => true, 'message' => 'Instructor guardado exitosamente, pero hubo un error al enviar el correo.']);
                }
            } else {
                error_log("❌ Error al ejecutar la consulta SQL: " . json_encode($stmt->errorInfo()));
                ob_clean();
                echo json_encode(['success' => false, 'message' => 'Error al guardar el instructor en la base de datos.']);
            }
        } else {
            ob_clean();
            echo json_encode(['success' => false, 'message' => 'Acción no válida.']);
        }
    } else {
        ob_clean();
        echo json_encode(['success' => false, 'message' => 'Datos inválidos.']);
    }
} catch (Exception $e) {
    error_log("Error en el servidor: " . $e->getMessage());
    ob_clean();
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}

ob_end_flush();
?>
