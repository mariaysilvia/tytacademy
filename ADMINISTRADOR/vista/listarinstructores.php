<?php include '../vista/navbarADMIN.php'; ?> <!-- Incluye el navbar aquí -->
<body>
    <div class="containerI">
    <h1>Lista de <span class="tituloI">los Instructores</span></h1>
        <div id="listarinstructores">
            <div class="card-container">
                <!-- Las tarjetas de los aprendices se agregarán aquí dinámicamente -->
            </div>
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