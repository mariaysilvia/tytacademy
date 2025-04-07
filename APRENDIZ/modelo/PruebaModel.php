<?php
class PruebaModel {
    protected $pdo;
    protected $respuestasCorrectas;
    protected $nombrePrueba;

    public function __construct($pdo, $nombrePrueba) {
        $this->pdo = $pdo;
        $this->nombrePrueba = $nombrePrueba;
        $this->respuestasCorrectas = $this->obtenerRespuestasCorrectas();
    }

    protected function obtenerRespuestasCorrectas() {
        // Este método será sobrescrito por las clases hijas
        return [];
    }

    public function corregirPrueba($respuestasUsuario) {
        if (empty($respuestasUsuario)) {
            throw new Exception("No se recibieron respuestas para corregir");
        }

        $aciertos = 0;
        $incorrectas = [];
        $respuestasDetalladas = [];

        // Comparar respuestas
        foreach ($respuestasUsuario as $idPregunta => $idRespuestaUsuario) {
            // Verificar si existe respuesta correcta para esta pregunta
            if (isset($this->respuestasCorrectas[$idPregunta])) {
                $idRespuestaCorrecta = $this->respuestasCorrectas[$idPregunta];
                $esCorrecta = ($idRespuestaUsuario == $idRespuestaCorrecta);

                if ($esCorrecta) {
                    $aciertos++;
                } else {
                    $incorrectas[] = $idPregunta;
                }

                $respuestasDetalladas[] = [
                    "id_pregunta" => $idPregunta,
                    "respuesta_usuario" => $idRespuestaUsuario,
                    "respuesta_correcta" => $idRespuestaCorrecta,
                    "es_correcta" => $esCorrecta
                ];
            }
        }

        // Guardar resultados en la base de datos
        $this->guardarResultados($aciertos, count($respuestasUsuario));

        return [
            "aciertos" => $aciertos,
            "total_preguntas" => count($respuestasUsuario),
            "incorrectas" => $incorrectas,
            "respuestas" => $respuestasDetalladas
        ];
    }

    protected function guardarResultados($aciertos, $totalPreguntas) {
        // Este método será implementado para guardar los resultados en la base de datos
        // Por ahora es un placeholder
        return true;
    }
} 