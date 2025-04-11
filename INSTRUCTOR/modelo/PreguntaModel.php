<?php
require_once '../../config/conexion.php';

class PreguntaModel {
    private $conexion;
    
    public function __construct($pdo) {
        $this->conexion = $pdo;
    }
    
    // Obtiene los tipos de pregunta disponibles
    // @return array Lista de tipos de pregunta
    public function obtenerTiposPregunta() {
        try {
            $query = "SELECT idtipoPregunta as id, nombreTipoPregunta as nombre FROM tipoPregunta";
            $stmt = $this->conexion->prepare($query);
            $stmt->execute();
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (empty($resultado)) {
                error_log("No se encontraron tipos de pregunta en la base de datos");
                return [];
            }
            
            return $resultado;
        } catch (PDOException $e) {
            error_log("Error en obtenerTiposPregunta: " . $e->getMessage());
            return [];
        }
    }
    
    // Obtiene los temas de un módulo específico
    // @param int $idInstructor ID del instructor
    // @return array Lista de temas del módulo
    public function obtenerTemasModulo($idInstructor) {
        try {
            // Primero obtenemos el idModulo del instructor
            $queryInstructor = "SELECT idModulo FROM Instructor WHERE idInstructor = ?";
            $stmtInstructor = $this->conexion->prepare($queryInstructor);
            $stmtInstructor->execute([$idInstructor]);
            $instructor = $stmtInstructor->fetch(PDO::FETCH_ASSOC);
            
            if (!$instructor) {
                error_log("No se encontró el instructor con ID: " . $idInstructor);
                return [];
            }
            
            // Luego obtenemos los temas del módulo
            $query = "SELECT idtemaModulo as id, nombreTema as nombre 
                    FROM temaModulo 
                    WHERE idModulo = ?";
            $stmt = $this->conexion->prepare($query);
            $stmt->execute([$instructor['idModulo']]);
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (empty($resultado)) {
                error_log("No se encontraron temas para el módulo con ID: " . $instructor['idModulo']);
                return [];
            }
            
            return $resultado;
        } catch (PDOException $e) {
            error_log("Error en obtenerTemasModulo: " . $e->getMessage());
            return [];
        }
    }
    
    // Guarda una nueva pregunta con sus respuestas
    // @param array $datosPregunta Datos de la pregunta
    // @param array $respuestas Respuestas de la pregunta
    // @return bool True si se guardó correctamente
    public function guardarPregunta($datosPregunta, $respuestas) {
        try {
            // Verificar que el idModulo sea válido
            if (!isset($datosPregunta['idModulo']) || empty($datosPregunta['idModulo'])) {
                error_log("Error en guardarPregunta: No se proporcionó un idModulo válido");
                return false;
            }
            
            // Verificar que el módulo exista
            $queryModulo = "SELECT idModulo FROM Modulo WHERE idModulo = ?";
            $stmtModulo = $this->conexion->prepare($queryModulo);
            $stmtModulo->execute([$datosPregunta['idModulo']]);
            $modulo = $stmtModulo->fetch(PDO::FETCH_ASSOC);
            
            if (!$modulo) {
                error_log("Error en guardarPregunta: El módulo con ID " . $datosPregunta['idModulo'] . " no existe");
                return false;
            }
            
            // Verificar que el tipo de pregunta exista
            $queryTipo = "SELECT idtipoPregunta FROM tipoPregunta WHERE idtipoPregunta = ?";
            $stmtTipo = $this->conexion->prepare($queryTipo);
            $stmtTipo->execute([$datosPregunta['idtipoPregunta']]);
            if (!$stmtTipo->fetch()) {
                error_log("Error en guardarPregunta: El tipo de pregunta con ID " . $datosPregunta['idtipoPregunta'] . " no existe");
                return false;
            }
            
            // Verificar que el tema del módulo exista
            $queryTema = "SELECT idtemaModulo FROM temaModulo WHERE idtemaModulo = ? AND idModulo = ?";
            $stmtTema = $this->conexion->prepare($queryTema);
            $stmtTema->execute([$datosPregunta['idtemaModulo'], $datosPregunta['idModulo']]);
            if (!$stmtTema->fetch()) {
                error_log("Error en guardarPregunta: El tema con ID " . $datosPregunta['idtemaModulo'] . " no existe o no pertenece al módulo");
                return false;
            }
            
            $this->conexion->beginTransaction();
            
            // Procesar imagen si existe
            $rutaImagen = null;
            if (isset($datosPregunta['imagenPregunta']) && $datosPregunta['imagenPregunta'] !== null) {
                $rutaImagen = $this->procesarImagen($datosPregunta['imagenPregunta']);
                if ($rutaImagen === null) {
                    error_log("Error al procesar la imagen de la pregunta");
                    // Continuamos sin la imagen
                }
            }
            
            // Insertar pregunta
            $query = "INSERT INTO Pregunta (pregunta, idtipoPregunta, idtemaModulo, idModulo, imagen) 
                     VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->conexion->prepare($query);
            $stmt->execute([
                $datosPregunta['pregunta'],
                $datosPregunta['idtipoPregunta'],
                $datosPregunta['idtemaModulo'],
                $datosPregunta['idModulo'],
                $rutaImagen
            ]);
            
            $idPregunta = $this->conexion->lastInsertId();
            
            // Insertar respuestas
            $query = "INSERT INTO Respuesta (respuesta, idPregunta, esCorrecta) VALUES (?, ?, ?)";
            $stmt = $this->conexion->prepare($query);
            
            foreach ($respuestas as $respuesta) {
                $stmt->execute([
                    $respuesta['texto'],
                    $idPregunta,
                    $respuesta['esCorrecta'] ? 1 : 0
                ]);
            }
            
            $this->conexion->commit();
            error_log("Pregunta guardada exitosamente con ID: " . $idPregunta);
            return true;
            
        } catch (Exception $e) {
            $this->conexion->rollBack();
            error_log("Error en guardarPregunta: " . $e->getMessage());
            return false;
        }
    }
    
    // Obtiene todas las preguntas de un módulo específico
    // @param int $idModulo ID del módulo
    // @return array Lista de preguntas con sus respuestas
    public function getPreguntasModulo($idModulo) {
        try {
            $query = "SELECT p.idPregunta, p.pregunta, p.imagen, p.idtipoPregunta, p.idtemaModulo, 
                      tp.nombreTipoPregunta as tipoPregunta, tm.nombreTema as temaModulo,
                      m.modulo as nombreModulo
                      FROM Pregunta p 
                      JOIN tipoPregunta tp ON p.idtipoPregunta = tp.idtipoPregunta 
                      JOIN temaModulo tm ON p.idtemaModulo = tm.idtemaModulo 
                      JOIN Modulo m ON p.idModulo = m.idModulo
                      WHERE p.idModulo = ?";
            
            $stmt = $this->conexion->prepare($query);
            $stmt->execute([$idModulo]);
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (empty($resultado)) {
                error_log("No se encontraron preguntas para el módulo con ID: " . $idModulo);
                return [];
            }
            
            return $resultado;
        } catch (PDOException $e) {
            error_log("Error en getPreguntasModulo: " . $e->getMessage());
            return [];
        }
    }
    
    // Procesa y guarda la imagen de una pregunta
    // @param array $imagen Datos de la imagen a procesar
    // @return string|null Ruta de la imagen guardada o null si hubo error
    private function procesarImagen($imagen) {
        try {
            // Definir el directorio para las imágenes
            $directorio = "/trabajos/PruebasTYT/INSTRUCTOR/publico/imagenes/";   
            $directorioAbsoluto = $_SERVER['DOCUMENT_ROOT'] . $directorio;
            
            // Verificar si el directorio existe, si no, crearlo
            if (!file_exists($directorioAbsoluto)) {
                if (!mkdir($directorioAbsoluto, 0777, true)) {
                    error_log("Error al crear el directorio de imágenes: " . $directorioAbsoluto);
                    return null;
                }
            }
            
            // Generar un nombre único para la imagen
            $extension = pathinfo($imagen['name'], PATHINFO_EXTENSION);
            $nombreArchivo = uniqid() . "." . $extension;
            $rutaCompleta = $directorioAbsoluto . $nombreArchivo;
            
            // Mover el archivo subido al directorio
            if (move_uploaded_file($imagen['tmp_name'], $rutaCompleta)) {
                // Devolver la ruta relativa para guardar en la base de datos
                return $directorio . $nombreArchivo;
            } else {
                error_log("Error al mover el archivo subido: " . $imagen['tmp_name'] . " a " . $rutaCompleta);
                return null;
            }
        } catch (Exception $e) {
            error_log("Error en procesarImagen: " . $e->getMessage());
            return null;
        }
    }
    
    // Obtiene las respuestas de una pregunta específica
    // @param int $idPregunta ID de la pregunta
    // @return array Lista de respuestas de la pregunta
    public function getRespuestasPregunta($idPregunta) {
        try {
            $query = "SELECT idRespuesta, respuesta, esCorrecta FROM Respuesta WHERE idPregunta = ?";
            $stmt = $this->conexion->prepare($query);
            $stmt->execute([$idPregunta]);
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (empty($resultado)) {
                error_log("No se encontraron respuestas para la pregunta con ID: " . $idPregunta);
                return [];
            }
            
            return $resultado;
        } catch (PDOException $e) {
            error_log("Error en getRespuestasPregunta: " . $e->getMessage());
            return [];
        }
    }
    
    // Obtiene una pregunta por su ID
    // @param int $idPregunta ID de la pregunta
    // @return array|null Datos de la pregunta o null si no se encuentra
    public function getPreguntaPorId($idPregunta) {
        try {
            $query = "SELECT p.*, tp.nombreTipoPregunta as tipoPregunta, tm.nombreTema as temaModulo 
                      FROM Pregunta p 
                      JOIN tipoPregunta tp ON p.idtipoPregunta = tp.idtipoPregunta 
                      JOIN temaModulo tm ON p.idtemaModulo = tm.idtemaModulo 
                      WHERE p.idPregunta = ?";
            
            $stmt = $this->conexion->prepare($query);
            $stmt->execute([$idPregunta]);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$resultado) {
                error_log("No se encontró la pregunta con ID: " . $idPregunta);
                return null;
            }
            
            return $resultado;
        } catch (PDOException $e) {
            error_log("Error en getPreguntaPorId: " . $e->getMessage());
            return null;
        }
    }
    
    // Elimina una pregunta y sus respuestas
    // @param int $idPregunta ID de la pregunta a eliminar
    // @return bool True si se eliminó correctamente
    public function eliminarPregunta($idPregunta) {
        try {
            // Obtener la información de la pregunta antes de eliminarla
            $pregunta = $this->getPreguntaPorId($idPregunta);
            if (!$pregunta) {
                error_log("No se encontró la pregunta con ID: " . $idPregunta);
                return false;
            }
            
            $this->conexion->beginTransaction();
            
            // Eliminar las respuestas primero
            $queryRespuestas = "DELETE FROM Respuesta WHERE idPregunta = ?";
            $stmtRespuestas = $this->conexion->prepare($queryRespuestas);
            $stmtRespuestas->execute([$idPregunta]);
            
            // Eliminar la pregunta
            $queryPregunta = "DELETE FROM Pregunta WHERE idPregunta = ?";
            $stmtPregunta = $this->conexion->prepare($queryPregunta);
            $stmtPregunta->execute([$idPregunta]);
            
            // Si hay una imagen, eliminarla del sistema de archivos
            if (!empty($pregunta['imagen'])) {
                $rutaImagen = $pregunta['imagen'];
                if (file_exists($rutaImagen)) {
                    unlink($rutaImagen);
                }
            }
            
            $this->conexion->commit();
            return true;
            
        } catch (PDOException $e) {
            $this->conexion->rollBack();
            error_log("Error en eliminarPregunta: " . $e->getMessage());
            return false;
        }
    }
    
    // Actualiza una pregunta existente y sus respuestas
    // @param array $datosPregunta Datos actualizados de la pregunta
    // @param array $respuestas Respuestas actualizadas de la pregunta
    // @return bool True si se actualizó correctamente
    public function actualizarPregunta($datosPregunta, $respuestas) {
        try {
            // Verificar que la pregunta exista
            $preguntaOriginal = $this->getPreguntaPorId($datosPregunta['idPregunta']);
            if (!$preguntaOriginal) {
                error_log("Error en actualizarPregunta: La pregunta con ID " . $datosPregunta['idPregunta'] . " no existe");
                return false;
            }
            
            $this->conexion->beginTransaction();
            
            // Procesar imagen si existe
            $rutaImagen = $preguntaOriginal['imagen']; // Mantener la imagen original por defecto
            if (isset($datosPregunta['imagenPregunta']) && $datosPregunta['imagenPregunta'] !== null) {
                $nuevaRutaImagen = $this->procesarImagen($datosPregunta['imagenPregunta']);
                if ($nuevaRutaImagen !== null) {
                    // Si hay una imagen anterior, eliminarla
                    if (!empty($preguntaOriginal['imagen']) && file_exists($preguntaOriginal['imagen'])) {
                        unlink($preguntaOriginal['imagen']);
                    }
                    $rutaImagen = $nuevaRutaImagen;
                }
            }
            
            // Actualizar pregunta
            $query = "UPDATE Pregunta SET pregunta = ?, imagen = ? WHERE idPregunta = ?";
            $stmt = $this->conexion->prepare($query);
            $stmt->execute([
                $datosPregunta['pregunta'],
                $rutaImagen,
                $datosPregunta['idPregunta']
            ]);
            
            // Eliminar respuestas anteriores
            $queryEliminar = "DELETE FROM Respuesta WHERE idPregunta = ?";
            $stmtEliminar = $this->conexion->prepare($queryEliminar);
            $stmtEliminar->execute([$datosPregunta['idPregunta']]);
            
            // Insertar nuevas respuestas
            $query = "INSERT INTO Respuesta (respuesta, idPregunta, esCorrecta) VALUES (?, ?, ?)";
            $stmt = $this->conexion->prepare($query);
            
            foreach ($respuestas as $respuesta) {
                $stmt->execute([
                    $respuesta['texto'],
                    $datosPregunta['idPregunta'],
                    $respuesta['esCorrecta'] ? 1 : 0
                ]);
            }
            
            $this->conexion->commit();
            error_log("Pregunta actualizada exitosamente con ID: " . $datosPregunta['idPregunta']);
            return true;
            
        } catch (Exception $e) {
            $this->conexion->rollBack();
            error_log("Error en actualizarPregunta: " . $e->getMessage());
            return false;
        }
    }
} 