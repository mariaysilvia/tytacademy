<?php
// Iniciar sesión al principio
session_start();

// Configuración de errores más detallada
header('Content-Type: application/json');
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Inicio de captura de salida
ob_start();

try {
    // Verificar si el archivo de conexión existe
    $conexionPath = '../config/conexion.php';
    if (!file_exists($conexionPath)) {
        throw new Exception("Archivo de conexión no encontrado en: " . realpath($conexionPath));
    }

    // Incluir archivo de conexión
    require_once $conexionPath;

    // Verificar si $pdo está definido
    if (!isset($pdo) || !$pdo) {
        throw new Exception("Conexión PDO no establecida");
    }

    // Loguear todos los datos recibidos
    error_log("Método recibido: " . $_SERVER['REQUEST_METHOD']);
    error_log("POST recibido: " . print_r($_POST, true));
    error_log("FILES recibido: " . print_r($_FILES, true));
    error_log("Directorio actual: " . getcwd());

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Manejar la acción para obtener el ID del aprendiz
        if (isset($_POST['action']) && $_POST['action'] === 'getIdAprendiz') {
            if (!isset($_SESSION['usuario_id']) || empty($_SESSION['usuario_id'])) {
                echo json_encode([
                    "success" => false,
                    "message" => "Sesión no iniciada o ID de aprendiz no disponible"
                ]);
            } else {
                echo json_encode([
                    "success" => true,
                    "idAprendiz" => $_SESSION['usuario_id']
                ]);
            }
            exit;
        }

        // Validar que la sesión contiene el ID del usuario
        if (!isset($_SESSION['usuario_id']) || empty($_SESSION['usuario_id'])) {
            echo json_encode([
                "success" => false,
                "message" => "ID de aprendiz no proporcionado o sesión no iniciada"
            ]);
            exit;
        }

        $idAprendiz = $_SESSION['usuario_id'];

        // Ruta del directorio de imágenes con más detalles de verificación
        $directorioBase = $_SERVER['DOCUMENT_ROOT'] . '/trabajos/PruebasTYT/image/';
        
        // Log adicional para depuración
        error_log("Ruta base del directorio: " . $directorioBase);

        // Verificar si el directorio de imágenes existe
        if (!is_dir($directorioBase)) {
            // Intentar crear el directorio si no existe
            if (!mkdir($directorioBase, 0777, true)) {
                throw new Exception("No se pudo crear el directorio de imágenes: " . $directorioBase);
            }
            error_log("Directorio de imágenes creado: " . $directorioBase);
        }

        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            // Generar un nombre único para el archivo
            $extension = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $nombreArchivo = uniqid('foto_', true) . '.' . $extension;
            $rutaDestino = $directorioBase . $nombreArchivo;
            
            // Ruta relativa para guardar en base de datos
            $rutaRelativa = 'image/' . $nombreArchivo;

            error_log("Ruta destino completa: " . $rutaDestino);
            error_log("Ruta relativa: " . $rutaRelativa);

            // Intentar mover el archivo
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $rutaDestino)) {
                // Preparar la consulta con PDO
                $stmt = $pdo->prepare("UPDATE Aprendiz SET foto_perfil = :rutaFoto WHERE idAprendiz = :idAprendiz");
                
                if (!$stmt) {
                    throw new Exception("Error preparando consulta: " . print_r($pdo->errorInfo(), true));
                }

                $stmt->bindParam(':rutaFoto', $rutaRelativa);
                $stmt->bindParam(':idAprendiz', $idAprendiz, PDO::PARAM_INT);
                
                if ($stmt->execute()) {
                    echo json_encode([
                        "success" => true, 
                        "message" => "Foto actualizada correctamente",
                        "rutaFoto" => $rutaRelativa
                    ]);
                } else {
                    throw new Exception("Error al actualizar la foto: " . print_r($stmt->errorInfo(), true));
                }
            } else {
                throw new Exception("No se pudo mover el archivo a " . $rutaDestino);
            }
        } else {
            throw new Exception("No se recibió una foto válida o hubo un error al subirla: " . $_FILES['foto']['error']);
        }
    } else {
        throw new Exception("Método no permitido: " . $_SERVER['REQUEST_METHOD']);
    }
} catch (Exception $e) {
    // Loguear el error completo
    error_log("Excepción capturada: " . $e->getMessage());
    error_log("Traza: " . $e->getTraceAsString());

    // Enviar respuesta de error
    echo json_encode([
        "success" => false, 
        "message" => "Error en el servidor: " . $e->getMessage(),
        "error_details" => $e->getMessage()
    ]);
}

// Limpiar el búfer de salida
ob_end_flush();
?>