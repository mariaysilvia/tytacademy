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

    protected function guardarResultados($aciertos, $totalPreguntas) {
        // Aquí se implementaría la lógica para guardar los resultados en la base de datos
        // Por ahora es un placeholder
        return true;
    }
} 