
<?php include '../html/navbar.php'; ?> <!-- Incluye el navbar aquí -->


    <!-- Modal para Ver Perfil -->
    <div class="modal fade" id="perfilModal" tabindex="-1" aria-labelledby="perfilModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="perfilModalLabel">Mi Perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center mb-4">
                        <img src="../imagenes/fotoanteojos.jpg" class="rounded-circle" alt="Foto de perfil"
                            style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <p><strong>Nombre:</strong> <span id="perfilNombre" class="dato-perfil"></span></p>
                            <p><strong>Apellido:</strong> <span id="perfilApellido" class="dato-perfil"></span></p>
                            <p><strong>Correo:</strong> <span id="perfilEmail" class="dato-perfil"></span></p>
                            <p><strong>Celular:</strong> <span id="perfilCelular" class="dato-perfil"></span></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="btnEditar"
                        onclick="habilitarEdicion()">Editar</button>
                    <button type="button" class="btn btn-success" id="btnGuardar" onclick="guardarCambios()"
                        style="display: none;">Guardar</button>
                </div>
            </div>
        </div>
    </div>
        
</header>


<section class="modulostarjetas">
    <div class="container-cards">
<!--Lectura critica-->
        <div class="card">
            <h5 class="card-title">Lectura crítica</h5>
            <img src="../imagenes/LogoModuloLecturaCritica.png" class="card-img-top" alt="lecturacritica">
            <div class="card-body">
            <p class="card-text">¡Ponte a prueba! Prepara tus habilidades de lectura crítica con esta prueba. ¡Comienza ahora!</p>
            </div>
            <ul>
                <i class="fa-regular fa-clock"></i><strong>20 Preguntas</strong>
            </ul>
            <div class="card-body">
            <a href="../formulariosparamodulos/formulariolecturacritica.php" class="card-link">Realizar Prueba</a>
            </div>
        </div>

<!--Razonamiento cuantitativo-->
        <div class="card">
            <h5 class="card-title">Razonamiento cuantitativo</h5>
            <img src="../imagenes/LogoModuloRazonamientoCuantitativo.png" class="card-img-top" alt="razonamientocuantitativo">
            <div class="card-body">
            <p class="card-text">¡Ponte a prueba! Prepara tus habilidades de Razonamiento cuantitativo con esta prueba. ¡Comienza ahora!</p>
            </div>
            <ul>
                <i class="fa-regular fa-clock"></i><strong>20 Preguntas</strong>
            </ul>
            <div class="card-body">
            <a href="../formulariosparamodulos/formulariorazonamiento.php" class="card-link">Realizar Prueba</a>
            </div>
        </div>

<!--competencia ciudadana-->
        <div class="card">
            <h5 class="card-title">Competencia ciudadana</h5>
            <img src="../imagenes/LogoModuloCompetenciaCiudadana.png" class="card-img-top" alt="...">
            <div class="card-body">
            <p class="card-text">¡Ponte a prueba! Prepara tus habilidades de Competencia ciudadana con esta prueba. ¡Comienza ahora!</p>
            </div>
            <ul>
                <i class="fa-regular fa-clock"></i><strong>20 Preguntas</strong>
            </ul>
            <div class="card-body">
            <a href="../formulariosparamodulos/formulariosciudadana.php" class="card-link">Realizar Prueba</a>
            </div>
        </div>

<!--comunicacion-->
        <div class="card">
            <h5 class="card-title">Comunicación</h5>
            <img src="../imagenes/LOgoModuloComunicacion.png" class="card-img-top" alt="...">
            <div class="card-body">
            <p class="card-text">¡Ponte a prueba! Prepara tus habilidades de comunicación con esta prueba. ¡Comienza ahora!</p>
            </div>
            <ul>
                <i class="fa-regular fa-clock"></i><strong>20 Preguntas</strong>
            </ul>
            <div class="card-body">
            <a href="../formulariosparamodulos/formularioscomunicacion.php" class="card-link">Realizar Prueba</a>
            </div>
        </div>

<!--ingles-->
        <div class="card">
            <h5 class="card-title">Inglés</h5>
            <img src="../imagenes/LogoModuloIngles.png" class="card-img-top" alt=".">
            <div class="card-body">
            <p class="card-text">¡Ponte a prueba! Prepara tus habilidades de Inglés con esta prueba. ¡Comienza ahora!</p>
            </div>
            <ul>
                <i class="fa-regular fa-clock"></i><strong>20 Preguntas</strong>
            </ul>
            <div class="card-body">
            <a href="../formulariosparamodulos/formularioingles.php" class="card-link">Realizar Prueba</a>
            </div>
        </div>
    </div>
</section>

<?php include '../html/footer.php'; ?> <!-- Incluye el footer aquí -->