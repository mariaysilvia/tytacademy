
<?php include '../vista/navbarADMIN.php'; ?> <!-- Incluye el navbar aquí -->
<body>

    <div class="containerA">
    <h1>Lista de <span class="tituloA">los Aprendices</span></h1>
        <div id="listaraprendices">
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