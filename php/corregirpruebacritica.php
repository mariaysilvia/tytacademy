<?php
// Activar reporting de errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Establecer encabezados JSON de manera estricta
header('Content-Type: application/json');
header('X-Content-Type-Options: nosniff');

try {
    // Verificar método de solicitud
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        throw new Exception("Método no permitido");
    }

    // Leer datos de entrada
    $respuestasUsuario = json_decode(file_get_contents("php://input"), true);

    // Validación básica de JSON
    if ($respuestasUsuario === null) {
        throw new Exception("Datos JSON inválidos");
    }

    // Respuestas correctas (A=1, B=2, C=3, D=4)
    $respuestasCorrectas = [
        1 => 4,  // D
        2 => 4,  // D
        3 => 2,  // B
        4 => 2,  // B
        5 => 1,  // A
        6 => 3,  // C
        7 => 3,  // C
        8 => 1,  // A
        9 => 4,  // D
        10 => 1, // A
        11 => 3, // C
        12 => 2, // B
        13 => 2, // B
        14 => 4, // D
        15 => 1, // A
        16 => 2, // B
        17 => 4, // D
        18 => 2, // B
        19 => 2, // B
        20 => 3  // C
    ];

    $aciertos = 0;
    $incorrectas = [];
    $respuestasDetalladas = [];

    // Comparar respuestas
    foreach ($respuestasUsuario as $idPregunta => $idRespuestaUsuario) {
        // Verificar si existe respuesta correcta para esta pregunta
        if (isset($respuestasCorrectas[$idPregunta])) {
            $idRespuestaCorrecta = $respuestasCorrectas[$idPregunta];
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

    // Respuesta JSON
    echo json_encode([
        "aciertos" => $aciertos,
        "total_preguntas" => count($respuestasUsuario),
        "incorrectas" => $incorrectas,
        "respuestas" => $respuestasDetalladas
    ]);
    exit;

} catch (Exception $e) {
    // Enviar error como JSON
    echo json_encode([
        'error' => $e->getMessage()
    ]);
    exit;
}
?>