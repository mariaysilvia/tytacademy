<?php
session_start();
if (!isset($_SESSION['preguntas'])) {
    header('Location: /trabajos/PruebasTYT/APRENDIZ/vista/PRUEBAS.php?error=No hay preguntas disponibles');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pruebas TYTACADEMY</title>
    <link rel="stylesheet" href="/trabajos/PruebasTYT/APRENDIZ/publico/css/principalAprendiz.css">
    <link rel="stylesheet" href="../simulacropruebas/estilospruebas.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container-prueba">
        <header class="header-prueba">
            <h1 id="tituloPrueba">Prueba TYT - <?php echo htmlspecialchars($_SESSION['tipoPrueba']); ?></h1>
        </header>

        <!-- Contenedor de preguntas -->
        <main class="contenedor-preguntas">
            <form id="formRespuestas" method="POST" action="/trabajos/PruebasTYT/APRENDIZ/controlador/corregirPrueba.php">
                <div id="preguntas">
                    <?php
                    $preguntas = $_SESSION['preguntas'];
                    $contadorPreguntas = 1;
                    
                    // Mostrar las preguntas
                    foreach ($preguntas as $grupo) {
                        if (isset($grupo['preguntas'])) {
                            // Grupo de preguntas con imagen compartida
                            echo '<div class="grupo-preguntas">';
                            if (!empty($grupo['imagen'])) {
                                echo '<div class="imagen-grupo">';
                                echo '<img src="' . $grupo['imagen'] . '" alt="Imagen de las preguntas">';
                                echo '</div>';
                            }
                            
                            foreach ($grupo['preguntas'] as $pregunta) {
                                echo '<div class="pregunta">';
                                echo '<h3>Pregunta ' . $contadorPreguntas . '</h3>';
                                echo '<p>' . htmlspecialchars($pregunta['pregunta']) . '</p>';
                                
                                echo '<div class="opciones-vertical">';
                                foreach ($pregunta['respuestas'] as $respuesta) {
                                    echo '<label class="opcion">';
                                    echo '<input type="radio" name="respuesta_' . $pregunta['id'] . '" value="' . $respuesta['id'] . '" required>';
                                    echo '<span>' . htmlspecialchars($respuesta['texto']) . '</span>';
                                    if (!empty($respuesta['imagen'])) {
                                        echo '<img src="' . $respuesta['imagen'] . '" alt="Imagen de respuesta" class="imagen-respuesta">';
                                    }
                                    echo '</label>';
                                }
                                echo '</div>';
                                echo '</div>';
                                $contadorPreguntas++;
                            }
                            echo '</div>';
                        } else {
                            // Pregunta individual
                            echo '<div class="pregunta">';
                            echo '<h3>Pregunta ' . $contadorPreguntas . '</h3>';
                            
                            if (!empty($grupo['imagen'])) {
                                echo '<div class="imagen-pregunta">';
                                echo '<img src="' . $grupo['imagen'] . '" alt="Imagen de la pregunta">';
                                echo '</div>';
                            }
                            
                            echo '<p>' . htmlspecialchars($grupo['pregunta']) . '</p>';
                            
                            echo '<div class="opciones-vertical">';
                            foreach ($grupo['respuestas'] as $respuesta) {
                                echo '<label class="opcion">';
                                echo '<input type="radio" name="respuesta_' . $grupo['id'] . '" value="' . $respuesta['id'] . '" required>';
                                echo '<span>' . htmlspecialchars($respuesta['texto']) . '</span>';
                                if (!empty($respuesta['imagen'])) {
                                    echo '<img src="' . $respuesta['imagen'] . '" alt="Imagen de respuesta" class="imagen-respuesta">';
                                }
                                echo '</label>';
                            }
                            echo '</div>';
                            echo '</div>';
                            $contadorPreguntas++;
                        }
                    }
                    ?>
                </div>
            </form>
        </main>

        <!-- Botón para finalizar -->
        <div class="finalizar-prueba">
            <button id="btnFinalizar" class="btn-finalizar">Finalizar Prueba</button>
        </div>
    </div>


    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Guardar fecha de inicio
            fetch('/trabajos/PruebasTYT/APRENDIZ/controlador/guardarFechaInicio.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    fechaInicio: new Date().toISOString()
                })
            });

            // Manejar el botón de finalizar
            document.getElementById('btnFinalizar').addEventListener('click', function() {
                // Guardar fecha de finalización
                fetch('/trabajos/PruebasTYT/APRENDIZ/controlador/guardarFechaFin.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        fechaFin: new Date().toISOString()
                    })
                }).then(() => {
                    // Enviar el formulario
                    document.getElementById('formRespuestas').submit();
                });
            });
        });
    </script>
</body>
</html> 