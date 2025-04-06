<?php include '../vista/navbarADMIN.php'; ?> <!-- Incluye el navbar aquí -->
<body>
    <div class="containerI">
    <h1>Lista de <span class="tituloI">los Instructores</span></h1>
        <div id="listarinstructores">
            <div class="card-container">
                <!-- Las tarjetas de los instructores se agregarán aquí dinámicamente -->
            </div>
        </div>
    </div>

    <!-- Modal de Edición -->
    <div class="modal fade" id="editarInstructorModal" tabindex="-1" aria-labelledby="editarInstructorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editarInstructorModalLabel">Editar Instructor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editarInstructorForm">
                        <input type="hidden" id="edit_id">
                        <div class="mb-3">
                            <label for="edit_documento" class="form-label">Documento:</label>
                            <input type="text" class="form-control" id="edit_documento" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_nombres" class="form-label">Nombres:</label>
                            <input type="text" class="form-control" id="edit_nombres" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_apellidos" class="form-label">Apellidos:</label>
                            <input type="text" class="form-control" id="edit_apellidos" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_correo" class="form-label">Correo:</label>
                            <input type="email" class="form-control" id="edit_correo" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_celular" class="form-label">Celular:</label>
                            <input type="text" class="form-control" id="edit_celular">
                        </div>
                        <div class="mb-3">
                            <label for="edit_modulo" class="form-label">Módulo:</label>
                            <select class="form-control" id="edit_modulo" required>
                                <option value="">Seleccione un módulo</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="guardarCambiosInstructor()">Guardar cambios</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Incluir Bootstrap CSS y JS solo para el modal -->
    <style>
        /* Estilos para aislar Bootstrap solo al modal */
        .modal, .modal-dialog, .modal-content, .modal-header, .modal-body, .modal-footer,
        .btn-close, .form-control, .form-label, .mb-3, .btn, .btn-primary, .btn-secondary {
            font-family: inherit;
        }
        
        /* Restaurar estilos originales para elementos fuera del modal */
        body, .containerI, h1, .tituloI, .card-container, .card-instructor, .card-body, 
        .card-title, .card-text, .button-group, .btn-sm {
            font-family: 'Montserrat', sans-serif;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Enlaces a los archivos JavaScript -->
    <script src="../publico/js/instructor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            cargarInstructores();
            // Solo cargar módulos si estamos en la página de crear instructor o en el modal de edición
            if (document.getElementById('modulo') || document.getElementById('edit_modulo')) {
                cargarModulos();
            }
        });
    </script>
</body>
</html>