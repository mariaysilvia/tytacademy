<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TYT ACADEMY</title>
    <link rel="stylesheet" href="formulariosparamodulos.css">
    <link rel="icon" href="../imagenes/lecturacriticamodulo.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div id="video-background">
        <video autoplay muted loop>
            <source src="imagenesVideos/COMPETENCIA.mp4" type="video/mp4">
        </video>
    </div>
    <section class="form-register">
            <img src="imagenesVideos/tytacademy.png" alt="TYTAcademy">
        </a>
        <h2>¿Quieres prepararte para Competencia Ciudadana?</h2>
        <h4>¡Realiza el simulacro de las pruebas TYT de Competencia Ciudadana!</h4>
        <br>
        <h6>Define las caracteristicas de la prueba</h6>
        <form action="../simulacropruebas/prueba10ciudadana.html">
                <label for="preguntas">¿Qué cantidad de preguntas desea en su prueba?:</label>
                <select class="controls" name="preguntas" id="preguntas" required>
                    <option value="todas">Todas</option>
                    <option value="10">10 Preguntas</option>
                    <option value="20">20 Preguntas</option>
                    </select>
                
            <input class="botons" type="submit" value="Comenzar">
            <p><a href="../APRENDIZ/vista/PRUEBAS.php">Cambiar de modulo</a></p>
        </form>
    </section>


    <?php include '../APRENDIZ/vista/footer.php'; ?> <!-- Incluye el footer aquí -->
