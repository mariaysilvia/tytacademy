<?php
require_once 'PruebaModel.php';

class PruebaRazonamientoModel extends PruebaModel {
    public function __construct($pdo) {
        parent::__construct($pdo, 'razonamiento');
    }

    protected function obtenerRespuestasCorrectas() {
        // Respuestas correctas para la prueba de razonamiento (A=1, B=2, C=3, D=4)
        return [
            1 =>  2, // B
            2 =>  4, // D
            3 =>  1, // A
            4 =>  3, // C
            5 =>  2, // B
            6 =>  4, // D
            7 =>  1, // A
            8 =>  3, // C
            9 =>  2, // B
            10 => 4, // D
            11 => 1, // A
            12 => 3, // C
            13 => 2, // B
            14 => 4, // D
            15 => 1, // A
            16 => 3, // C
            17 => 2, // B
            18 => 4, // D
            19 => 1, // A
            20 => 3  // C
        ];
    }

    protected function guardarResultados($aciertos, $totalPreguntas) {
        // Aquí se implementaría la lógica para guardar los resultados en la base de datos
        // Por ahora es un placeholder
        return true;
    }
} 