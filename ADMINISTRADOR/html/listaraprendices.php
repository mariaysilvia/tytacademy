<?php include '../html/navbarADMIN.php'; ?> <!-- Incluye el navbar aquí -->
<body>

    <div class="container">
    <h1>Lista<span class="mt-4 tituloA">Aprendiz</span></h1>
        <div id="listaraprendices" class="row mt-4">
            <!-- Las tarjetas de los aprendices se agregarán aquí dinámicamente -->
        </div>
    </div>
    <!-- Enlace al archivo JavaScript -->
    <script src="../js/instructor.js"></script>
    <script>
        // Llama solo a cargarAprendices
        document.addEventListener('DOMContentLoaded', cargarAprendices);
    </script>
</body>
</html>