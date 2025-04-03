<<<<<<<< HEAD:ADMINISTRADOR/vista/listaraprendices.html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Aprendices</title>
    <link rel="stylesheet" href="../publico/css/listaraprendices.css">
</head>
========
<?php include '../html/navbarADMIN.php'; ?> <!-- Incluye el navbar aquí -->
>>>>>>>> 75f01eef7f041d9f729c427dc2ec45dedeb8b1b0:ADMINISTRADOR/vista/listaraprendices.php
<body>

    <div class="container">
    <h1>Lista<span class="mt-4 tituloA">Aprendiz</span></h1>
        <div id="listaraprendices" class="row mt-4">
            <!-- Las tarjetas de los aprendices se agregarán aquí dinámicamente -->
        </div>
    </div>
    <!-- Enlace al archivo JavaScript -->
    <script src="../publico/js/instructor.js"></script>
    <script>
        // Llama solo a cargarAprendices
        document.addEventListener('DOMContentLoaded', cargarAprendices);
    </script>
</body>
</html>