<?php
require_once 'PruebaModel.php';

class PruebaInglesModel extends PruebaModel {
    public function __construct($pdo) {
        parent::__construct($pdo, 'ingles');
    }

    protected function obtenerRespuestasCorrectas() {
        // Respuestas correctas para la prueba de inglés (A=1, B=2, C=3, D=4, E=5, F=6, G=7, H=8)
        return [
            1 =>  2, // B
            2 =>  3, // C
            3 =>  1, // A
            4 =>  3, // C
            5 =>  1, // A
            6 =>  1, // A
            7 =>  2, // B
            8 =>  1, // A
            9 =>  1, // A
            10 => 1, // A
            11 => 2, // B
            12 => 1, // A
            13 => 2, // B
            14 => 3, // C
            15 => 1, // A
            16 => 6, // F
            17 => 5, // E
            18 => 2, // B
            19 => 7, // G
            20 => 8  // H
        ];
    }

    protected function guardarResultados($aciertos, $totalPreguntas) {
        // Aquí se implementaría la lógica para guardar los resultados en la base de datos
        // Por ahora es un placeholder
        return true;
    }
} 