<?php
class PruebaModel {
    protected $pdo;
    protected $tipoPrueba;

    public function __construct($pdo, $tipoPrueba) {
        $this->pdo = $pdo;
        $this->tipoPrueba = $tipoPrueba;
    }

    public function obtenerTemasPorTipoPrueba() {
        try {
            // Mapeo completo de URLs a nombres de módulo en BD
            $moduloMap = [
                'lecturacritica' => 'Lectura Crítica',
                'razonamiento' => 'Razonamiento Cuantitativo',
                'ciudadana' => 'Competencias Ciudadanas',
                'comunicacion' => 'Comunicación Escrita',
                'ingles' => 'Inglés',
                // Aliases adicionales por si acaso
                'critica' => 'Lectura Crítica',
                'cuantitativo' => 'Razonamiento Cuantitativo',
                'competencias' => 'Competencias Ciudadanas'
            ];
    
            $nombreModulo = $moduloMap[strtolower($this->tipoPrueba)] ?? $this->tipoPrueba;
            error_log("Buscando temas para módulo: " . $nombreModulo);
    
            // Consulta SQL mejorada con JOIN explícito
            $sql = "SELECT tm.idtemaModulo, tm.nombreTema 
                    FROM temaModulo tm
                    INNER JOIN Modulo m ON tm.idModulo = m.idModulo
                    WHERE m.modulo = :nombreModulo
                    ORDER BY tm.nombreTema";
    
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':nombreModulo', $nombreModulo, PDO::PARAM_STR);
            
            if (!$stmt->execute()) {
                $errorInfo = $stmt->errorInfo();
                throw new Exception("Error en ejecución de consulta: " . $errorInfo[2]);
            }
    
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (empty($resultados)) {
                error_log("Consulta no devolvió resultados para: " . $nombreModulo);
                // Verificar si el módulo existe
                $sqlCheck = "SELECT idModulo FROM Modulo WHERE modulo = :nombreModulo";
                $stmtCheck = $this->pdo->prepare($sqlCheck);
                $stmtCheck->execute([':nombreModulo' => $nombreModulo]);
                if (!$stmtCheck->fetch()) {
                    throw new Exception("El módulo '$nombreModulo' no existe en la base de datos");
                }
            }
    
            return $resultados;
    
        } catch (PDOException $e) {
            error_log("PDOException en obtenerTemasPorTipoPrueba: " . $e->getMessage());
            throw new Exception("Error de base de datos al obtener temas");
        }
    }

    public function obtenerPreguntasPorTipo($tipoTexto, $cantidad) {
        try {
            error_log("Obteniendo preguntas para tipoPrueba: " . $this->tipoPrueba . ", tipoTexto: " . $tipoTexto . ", cantidad: " . $cantidad);

            // Primero obtener las preguntas aleatorias agrupadas por imagen
            $sqlPreguntas = "SELECT p.idPregunta, p.pregunta, p.imagen,
                     COUNT(*) OVER (PARTITION BY p.imagen) as preguntasPorImagen
                            FROM Pregunta p
                            WHERE p.idModulo = (SELECT idModulo FROM Modulo WHERE modulo = :tipoPrueba)";

            if ($tipoTexto !== 'todos') {
                $temaMap = [
                    'area1' => 'Discontinuos',
                    'area2' => 'Continuos',
                    'estadistica' => 'Estadística',
                    'geometria' => 'Geometría',
                    'algebra' => 'Álgebra y cálculo'
                ];

                $nombreTema = $temaMap[$tipoTexto] ?? $tipoTexto;

                $sqlPreguntas .= " AND p.idtemaModulo = (
                    SELECT idtemaModulo FROM temaModulo 
                    WHERE nombreTema = :nombreTema
                )";
            }

            $sqlPreguntas .= " ORDER BY p.imagen IS NULL, p.imagen, RAND() LIMIT :cantidad";

            $stmtPreguntas = $this->pdo->prepare($sqlPreguntas);
            $stmtPreguntas->bindValue(':tipoPrueba', $this->tipoPrueba, PDO::PARAM_STR);
            
            if ($tipoTexto !== 'todos') {
                $stmtPreguntas->bindValue(':nombreTema', $nombreTema, PDO::PARAM_STR);
            }
            
            $stmtPreguntas->bindValue(':cantidad', (int)$cantidad, PDO::PARAM_INT);
            $stmtPreguntas->execute();
            $preguntasSeleccionadas = $stmtPreguntas->fetchAll(PDO::FETCH_ASSOC);

            if (empty($preguntasSeleccionadas)) {
                throw new Exception("No se encontraron preguntas para los parámetros especificados");
            }

            // Obtener los IDs de las preguntas seleccionadas
            $idsPreguntas = array_column($preguntasSeleccionadas, 'idPregunta');
            $placeholders = str_repeat('?,', count($idsPreguntas) - 1) . '?';

            // Obtener las respuestas para las preguntas seleccionadas
            $sqlRespuestas = "SELECT r.idPregunta, r.idRespuesta, r.respuesta, r.imagen as imagenRespuesta,
                                    r.tipoRespuesta, r.esCorrecta
                            FROM Respuesta r
                            WHERE r.idPregunta IN ($placeholders)
                            ORDER BY r.idPregunta, r.idRespuesta";

            $stmtRespuestas = $this->pdo->prepare($sqlRespuestas);
            $stmtRespuestas->execute($idsPreguntas);
            $respuestas = $stmtRespuestas->fetchAll(PDO::FETCH_ASSOC);

            // Organizar las preguntas con sus respuestas y agrupar por imagen
            $preguntasOrganizadas = [];
            $gruposPorImagen = [];

            foreach ($preguntasSeleccionadas as $pregunta) {
                $imagen = $pregunta['imagen'];
                $idPregunta = $pregunta['idPregunta'];

                if (!empty($imagen)) {
                    if (!isset($gruposPorImagen[$imagen])) {
                        $gruposPorImagen[$imagen] = [];
                    }
                    $gruposPorImagen[$imagen][] = $idPregunta;
                }

                $preguntasOrganizadas[$idPregunta] = [
                    'id' => $idPregunta,
                    'pregunta' => $pregunta['pregunta'],
                    'imagen' => $imagen,
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

            // Organizar las preguntas en grupos por imagen
            $resultadoFinal = [];
            $imagenesProcesadas = [];

            foreach ($preguntasOrganizadas as $pregunta) {
                $imagen = $pregunta['imagen'];
                
                if (!empty($imagen) && !in_array($imagen, $imagenesProcesadas)) {
                    // Agregar el grupo de preguntas con la misma imagen
                    $grupo = [
                        'imagen' => $imagen,
                        'preguntas' => []
                    ];
                    
                    foreach ($gruposPorImagen[$imagen] as $idPregunta) {
                        $grupo['preguntas'][] = $preguntasOrganizadas[$idPregunta];
                    }
                    
                    $resultadoFinal[] = $grupo;
                    $imagenesProcesadas[] = $imagen;
                } elseif (empty($imagen)) {
                    // Preguntas sin imagen se agregan individualmente
                    $resultadoFinal[] = $pregunta;
                }
            }

            return $resultadoFinal;
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
}