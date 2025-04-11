
<?php 
session_start();
if (!isset($_SESSION['preguntas'])) {
    header('Location: PRUEBAS.php');
    exit;
}
include '../vista/navbar.php'; 
?>
<section class="modulostarjetas">
    <div class="container-cards">
<!--Lectura critica-->
        <div class="card">
            <h5 class="card-title">Lectura crítica</h5>
            <img src="../publico/imagenes/LogoModuloLecturaCritica.png" class="card-img-top" alt="lecturacritica">
            <div class="card-body">
            <p class="card-text">¡Ponte a prueba! Prepara tus habilidades de lectura crítica con esta prueba. ¡Comienza ahora!</p>
            </div>
            <ul>
                <i class="fa-regular fa-clock"></i><strong>20 Preguntas</strong>
            </ul>
            <div class="card-body">
            <a href="../../formulariosiniciomodulos/formulariodelaspruebas.php?modulo=lecturacritica" class="card-link">Realizar Prueba</a>
            </div>
        </div>

<!--Razonamiento cuantitativo-->
        <div class="card">
            <h5 class="card-title">Razonamiento cuantitativo</h5>
            <img src="../publico/imagenes/LogoModuloRazonamientoCuantitativo.png" class="card-img-top" alt="razonamientocuantitativo">
            <div class="card-body">
            <p class="card-text">¡Ponte a prueba! Prepara tus habilidades de Razonamiento cuantitativo con esta prueba. ¡Comienza ahora!</p>
            </div>
            <ul>
                <i class="fa-regular fa-clock"></i><strong>20 Preguntas</strong>
            </ul>
            <div class="card-body">
            <a href="../../formulariosiniciomodulos/formulariodelaspruebas.php?modulo=razonamientocuantitativo" class="card-link">Realizar Prueba</a>
            </div>
        </div>

<!--competencia ciudadana-->
        <div class="card">
            <h5 class="card-title">Competencia ciudadana</h5>
            <img src="../publico/imagenes/LogoModuloCompetenciaCiudadana.png" class="card-img-top" alt="...">
            <div class="card-body">
            <p class="card-text">¡Ponte a prueba! Prepara tus habilidades de Competencia ciudadana con esta prueba. ¡Comienza ahora!</p>
            </div>
            <ul>
                <i class="fa-regular fa-clock"></i><strong>20 Preguntas</strong>
            </ul>
            <div class="card-body">
            <a href="../../formulariosiniciomodulos/formulariodelaspruebas.php?modulo=competenciasciudadanas" class="card-link">Realizar Prueba</a>
            </div>
        </div>

<!--comunicacion-->
        <div class="card">
            <h5 class="card-title">Comunicación</h5>
            <img src="../publico/imagenes/LOgoModuloComunicacion.png" class="card-img-top" alt="...">
            <div class="card-body">
            <p class="card-text">¡Ponte a prueba! Prepara tus habilidades de comunicación con esta prueba. ¡Comienza ahora!</p>
            </div>
            <ul>
                <i class="fa-regular fa-clock"></i><strong>20 Preguntas</strong>
            </ul>
            <div class="card-body">
            <a href="../../formulariosiniciomodulos/formulariodelaspruebas.php?modulo=comunicacion" class="card-link">Realizar Prueba</a>
            </div>
        </div>

<!--ingles-->
        <div class="card">
            <h5 class="card-title">Inglés</h5>
            <img src="../publico/imagenes/LogoModuloIngles.png" class="card-img-top" alt=".">
            <div class="card-body">
            <p class="card-text">¡Ponte a prueba! Prepara tus habilidades de Inglés con esta prueba. ¡Comienza ahora!</p>
            </div>
            <ul>
                <i class="fa-regular fa-clock"></i><strong>20 Preguntas</strong>
            </ul>
            <div class="card-body">
            <a href="../../formulariosiniciomodulos/formulariodelaspruebas.php?modulo=ingles" class="card-link">Realizar Prueba</a>
            </div>
        </div>
    </div>
</section>


<?php include '../vista/footer.php'; ?> <!-- Incluye el footer aquí -->