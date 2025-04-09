<?php
header('Content-Type: application/json');
require_once '../../config/conexion.php';
session_start();

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $action = $_GET['action'] ?? '';

    // Depuración inicial de la sesión
    $sessionDebug = [
        'session_id' => session_id(),
        'session_status' => session_status(),
        'session_data' => $_SESSION,
        'cookie' => $_COOKIE
    ];

    switch ($action) {
        case 'obtenerPerfil':
            if (!isset($_SESSION['id_instructor'])) {
                echo json_encode([
                    'success' => false,
                    'message' => 'No hay sesión iniciada',
                    'debug' => $sessionDebug
                ]);
                exit;
            }

            $idInstructor = $_SESSION['id_instructor'];
            $stmt = $pdo->prepare("
                SELECT i.*, m.modulo as nombreModulo 
                FROM Instructor i 
                LEFT JOIN Modulo m ON i.idModulo = m.idModulo 
                WHERE i.idInstructor = ?
            ");
            $stmt->execute([$idInstructor]);
            $instructor = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($instructor) {
                echo json_encode([
                    'success' => true,
                    'instructor' => [
                        'documento' => $instructor['documento'],
                        'nombre' => $instructor['nombre'],
                        'apellido' => $instructor['apellido'],
                        'email' => $instructor['email'],
                        'celular' => $instructor['celular'],
                        'estado' => $instructor['estado'],
                        'nombreModulo' => $instructor['nombreModulo']
                    ],
                    'debug' => $sessionDebug
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'message' => 'Instructor no encontrado',
                    'debug' => $sessionDebug
                ]);
            }
            break;

            case 'actualizarPerfil':
                if (!isset($_SESSION['id_instructor'])) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'No hay sesión iniciada',
                        'debug' => $sessionDebug
                    ]);
                    exit;
                }
            
                $idInstructor = $_SESSION['id_instructor'];
                $documento = $_POST['documento'] ?? '';
                $nombre = $_POST['nombre'] ?? '';
                $apellido = $_POST['apellido'] ?? '';
                $email = $_POST['email'] ?? '';
                $celular = $_POST['celular'] ?? '';
            
                // Validación de datos
                if (empty($documento) || empty($nombre) || empty($apellido) || empty($email) || empty($celular)) {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Todos los campos son obligatorios',
                        'debug' => $sessionDebug
                    ]);
                    exit;
                }
            
                // Actualizar solo los campos permitidos
                $stmt = $pdo->prepare("
                    UPDATE Instructor 
                    SET documento = ?, nombre = ?, apellido = ?, email = ?, celular = ?
                    WHERE idInstructor = ?
                ");
            
                if ($stmt->execute([$documento, $nombre, $apellido, $email, $celular, $idInstructor])) {
                    echo json_encode([
                        'success' => true,
                        'message' => 'Perfil actualizado correctamente',
                        'debug' => $sessionDebug
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Error al actualizar el perfil',
                        'debug' => $sessionDebug
                    ]);
                }
                break;
        default:
            echo json_encode([
                'success' => false,
                'message' => 'Acción no válida',
                'debug' => $sessionDebug
            ]);
            break;
    }

} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error en la base de datos: ' . $e->getMessage(),
        'debug' => $sessionDebug
    ]);
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage(),
        'debug' => $sessionDebug
    ]);
}