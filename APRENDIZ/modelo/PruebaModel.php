<?php

class PruebaModel {
    protected $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    /**
     * Obtener preguntas por tema y cantidad.
     *
     * @param int $temaId ID del tema.
     * @param int $cantidad Número de preguntas a obtener.
     * @return array Lista de preguntas.
     */
    public function obtenerPreguntasPorTipo($temaId, $cantidad) {
        try {
            // Consulta para obtener preguntas por tema
            $sqlPreguntas = "SELECT p.idPregunta, p.pregunta, p.imagen
                             FROM Pregunta p
                             WHERE p.idtemaModulo = :temaId
                             ORDER BY RAND()
                             LIMIT :cantidad";

            $stmtPreguntas = $this->pdo->prepare($sqlPreguntas);
            $stmtPreguntas->bindParam(':temaId', $temaId, PDO::PARAM_INT);
            $stmtPreguntas->bindParam(':cantidad', $cantidad, PDO::PARAM_INT);
            $stmtPreguntas->execute();

            $preguntasSeleccionadas = $stmtPreguntas->fetchAll(PDO::FETCH_ASSOC);

            if (empty($preguntasSeleccionadas)) {
                throw new Exception("No se encontraron preguntas para los parámetros especificados.");
            }

            // Obtener los IDs de las preguntas seleccionadas
            $idsPreguntas = array_column($preguntasSeleccionadas, 'idPregunta');
            $placeholders = str_repeat('?,', count($idsPreguntas) - 1) . '?';

            // Consulta para obtener las respuestas de las preguntas seleccionadas
            $sqlRespuestas = "SELECT r.idPregunta, r.idRespuesta, r.respuesta, r.imagen as imagenRespuesta,
                                     r.tipoRespuesta, r.esCorrecta
                              FROM Respuesta r
                              WHERE r.idPregunta IN ($placeholders)
                              ORDER BY r.idPregunta, r.idRespuesta";

            $stmtRespuestas = $this->pdo->prepare($sqlRespuestas);
            $stmtRespuestas->execute($idsPreguntas);
            $respuestas = $stmtRespuestas->fetchAll(PDO::FETCH_ASSOC);

            // Organizar las preguntas con sus respuestas
            $preguntasOrganizadas = [];
            foreach ($preguntasSeleccionadas as $pregunta) {
                $idPregunta = $pregunta['idPregunta'];
                $preguntasOrganizadas[$idPregunta] = [
                    'id' => $idPregunta,
                    'pregunta' => $pregunta['pregunta'],
                    'imagen' => $pregunta['imagen'],
                    'respuestas' => []
                ];
            }

            foreach ($respuestas as $respuesta) {
                $preguntasOrganizadas[$respuesta['idPregunta']]['respuestas'][] = [
                    'id' => $respuesta['idRespuesta'],
                    'texto' => $respuesta['respuesta'],
                    'imagen' => $respuesta['imagenRespuesta'],
                    'tipo' => $respuesta['tipoRespuesta'],
                    'esCorrecta' => (bool)$respuesta['esCorrecta']
                ];
            }

            return array_values($preguntasOrganizadas);
        } catch (PDOException $e) {
            error_log("Error en obtenerPreguntasPorTipo: " . $e->getMessage());
            throw new Exception("Error al obtener las preguntas: " . $e->getMessage());
        }
    }

    /**
     * Obtener temas por módulo.
     *
     * @param string $modulo Nombre del módulo.
     * @return array Lista de temas.
     */
    public function obtenerTemasPorModulo($modulo) {
        try {
            $sql = "SELECT tm.idtemaModulo, tm.nombreTema 
                    FROM temaModulo tm
                    INNER JOIN Modulo m ON tm.idModulo = m.idModulo
                    WHERE m.modulo = :modulo";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':modulo', $modulo, PDO::PARAM_STR);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error en obtenerTemasPorModulo: " . $e->getMessage());
            throw new Exception("Error al obtener los temas: " . $e->getMessage());
        }
    }
}