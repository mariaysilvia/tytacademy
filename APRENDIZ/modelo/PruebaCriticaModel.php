<?php
require_once 'PruebaModel.php';

class PruebaCriticaModel extends PruebaModel {
    public function __construct($pdo) {
        parent::__construct($pdo, 'critica');
    }

    protected function obtenerRespuestasCorrectas() {
        // Respuestas correctas para la prueba de crítica (A=1, B=2, C=3, D=4)
        return [
            1 =>  4,  // D
            2 =>  4,  // D
            3 =>  2,  // B
            4 =>  2,  // B
            5 =>  1,  // A
            6 =>  3,  // C
            7 =>  3,  // C
            8 =>  1,  // A
            9 =>  4,  // D
            10 => 1,  // A
            11 => 3,  // C
            12 => 2,  // B
            13 => 2,  // B
            14 => 4,  // D
            15 => 1,  // A
            16 => 2,  // B
            17 => 4,  // D
            18 => 2,  // B
            19 => 2,  // B
            20 => 3   // C
        ];
    }

    public function guardarResultados($idAprendiz, $preguntas, $respuestas) {
        try {
            $this->pdo->beginTransaction();

            // Insertar el intento de prueba
            $stmt = $this->pdo->prepare("INSERT INTO IntentosPrueba (idAprendiz, tipoPrueba, fecha) VALUES (?, ?, NOW())");
            $stmt->execute([$idAprendiz, $this->tipoPrueba]);
            $idIntento = $this->pdo->lastInsertId();

            // Insertar las respuestas
            $stmt = $this->pdo->prepare("INSERT INTO RespuestasAprendiz (idIntento, idPregunta, idRespuesta) VALUES (?, ?, ?)");
            
            foreach ($respuestas as $idPregunta => $idRespuesta) {
                $stmt->execute([$idIntento, $idPregunta, $idRespuesta]);
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