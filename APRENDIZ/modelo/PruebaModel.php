<?php
class PruebaModel {
    protected $pdo;
    protected $tipoPrueba;
    
    public function __construct($pdo, $tipoPrueba) {
        $this->pdo = $pdo;
        $this->tipoPrueba = $tipoPrueba;
    }

    public function obtenerPreguntasPorTipo($tipoTexto, $cantidad) {
        try {
            error_log("Obteniendo preguntas para tipoPrueba: " . $this->tipoPrueba . ", tipoTexto: " . $tipoTexto . ", cantidad: " . $cantidad);

            $sql = "SELECT p.idPregunta, p.pregunta, p.imagen, 
                           r.idRespuesta, r.respuesta, r.imagen as imagenRespuesta, r.tipoRespuesta, r.esCorrecta
                    FROM Pregunta p
                    JOIN Respuesta r ON p.idPregunta = r.idPregunta
                    WHERE p.idModulo = (
                        SELECT idModulo FROM Modulo WHERE modulo = :tipoPrueba
                    )";

            if ($tipoTexto !== 'todos') {
                // Mapear los valores del formulario a los nombres de temas
                $temaMap = [
                    'area1' => 'Discontinuos',
                    'area2' => 'Continuos'
                ];
                
                $nombreTema = $temaMap[$tipoTexto] ?? $tipoTexto;
                
                $sql .= " AND p.idtemaModulo = (
                    SELECT idtemaModulo FROM temaModulo 
                    WHERE nombreTema = :nombreTema
                )";
            }

            $sql .= " ORDER BY RAND()";

            if ($cantidad !== 'todas') {
                $sql .= " LIMIT :cantidad";
            }

            error_log("SQL generado: " . $sql);

            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':tipoPrueba', $this->tipoPrueba, PDO::PARAM_STR);

            if ($tipoTexto !== 'todos') {
                $stmt->bindValue(':nombreTema', $nombreTema, PDO::PARAM_STR);
            }

            if ($cantidad !== 'todas') {
                $stmt->bindValue(':cantidad', (int)$cantidad, PDO::PARAM_INT);
            }

            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($resultados)) {
                error_log("No se encontraron preguntas para los parámetros especificados");
                throw new Exception("No se encontraron preguntas para el tipo de texto especificado");
            }

            return $this->organizarPreguntas($resultados);
        } catch (PDOException $e) {
            error_log("Error en obtenerPreguntasPorTipo: " . $e->getMessage());
            throw new Exception("Error al obtener las preguntas: " . $e->getMessage());
        }
    }

    protected function organizarPreguntas($resultados) {
        $preguntas = [];
        foreach ($resultados as $fila) {
            $idPregunta = $fila['idPregunta'];
            if (!isset($preguntas[$idPregunta])) {
                $preguntas[$idPregunta] = [
                    'id' => $idPregunta,
                    'pregunta' => $fila['pregunta'],
                    'imagen' => $fila['imagen'],
                    'respuestas' => []
                ];
            }
            $preguntas[$idPregunta]['respuestas'][] = [
                'id' => $fila['idRespuesta'],
                'texto' => $fila['respuesta'],
                'imagen' => $fila['imagenRespuesta'],
                'tipo' => $fila['tipoRespuesta'],
                'esCorrecta' => (bool)$fila['esCorrecta']
            ];
        }
        return array_values($preguntas);
    }

    public function guardarResultados($idAprendiz, $preguntas, $respuestas) {
        try {
            $this->pdo->beginTransaction();

            // Insertar el intento de prueba
            $stmt = $this->pdo->prepare("INSERT INTO Prueba (idAprendiz, idModulo, fechaHoraInicial) 
                                       VALUES (?, (SELECT idModulo FROM Modulo WHERE modulo = ?), NOW())");
            $stmt->execute([$idAprendiz, $this->tipoPrueba]);
            $idPrueba = $this->pdo->lastInsertId();

            // Insertar las respuestas
            $stmt = $this->pdo->prepare("INSERT INTO Valoracion (idPrueba, idPregunta, idRespuesta) VALUES (?, ?, ?)");
            
            foreach ($respuestas as $idPregunta => $idRespuesta) {
                $stmt->execute([$idPrueba, $idPregunta, $idRespuesta]);
            }

            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log("Error al guardar resultados: " . $e->getMessage());
            return false;
        }
    }
} 