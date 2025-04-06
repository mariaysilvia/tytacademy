
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

    <!-- Modal para Crear/Editar Proveedor -->
    <div class="modal fade" id="crearAprendizModal" tabindex="-1" aria-labelledby="crearAprendizModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title" id="crearAprendizModalLabel">Editar Aprendiz</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formCrearProveedor">
                        <div class="mb-3">
                            <label for="nombreProveedor" class="form-label">Nombre del Proveedor</label>
                            <input type="text" class="form-control" id="nombreProveedor" required>
                        </div>
                        <div class="mb-3">
                            <label for="direccionProveedor" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccionProveedor" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefonoProveedor" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefonoProveedor" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="btnGuardarProveedor" onclick="guardarProveedor()">Guardar</button>
                </div>
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