<?php
require_once 'PruebaModel.php';

class PruebaCiudadanaModel extends PruebaModel {
    public function __construct($pdo) {
        parent::__construct($pdo, 'ciudadana');
    }

    protected function obtenerRespuestasCorrectas() {
        // Respuestas correctas para la prueba de ciudadana (A=1, B=2, C=3, D=4)
        return [
            1 =>  3, // C
            2 =>  2, // B
            3 =>  4, // D
            4 =>  1, // A
            5 =>  4, // D
            6 =>  4, // D
            7 =>  1, // A
            8 =>  1, // A
            9 =>  4, // D
            10 => 4, // D
            11 => 4, // D
            12 => 3, // C
            13 => 4, // D
            14 => 2, // B
            15 => 4, // D
            16 => 1, // A
            17 => 1, // A
            18 => 4, // D
            19 => 3, // C
            20 => 1  // A
        ];
    }

    protected function guardarResultados($aciertos, $totalPreguntas) {
        // Aquí se implementaría la lógica para guardar los resultados en la base de datos
        // Por ahora es un placeholder
        return true;
    }
} 