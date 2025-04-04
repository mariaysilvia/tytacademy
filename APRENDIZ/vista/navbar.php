<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TYT ACADEMY</title>
    <link rel="stylesheet" href="../publico/css/principalAprendiz.css">
    <link rel="stylesheet" href="../publico/css/PRUEBAS.css">
    <link rel="stylesheet" href="../publico/css/lecturacritica.css">
    <link rel="stylesheet" href="../publico/css/razonamiento.css">
    <link rel="stylesheet" href="../publico/css/ciudadana.css">
    <link rel="stylesheet" href="../publico/css/comunicacion.css">
    <link rel="stylesheet" href="../publico/css/ingles.css">
    <link rel="stylesheet" href="../publico/css/nosotros.css">
    <link rel="icon" href="../publico/imagenes/LOGOaprendiz.png" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<header>
    <div class="header_superior">
        <div class="logo">
            <img src="../publico/imagenes/tytacademy.png" alt="TYT Academy Logo">
        </div>
    </div>

<div class="container_menu">
    <div class="menu">
        <nav>
            <ul>
                <li><a href="../vista/principalAprendiz.php" id="selected"></a></li>
                <li><a href="#">Módulos</a>
                    <ul>
                        <li><a href="../vista/lecturacritica.php">Lectura crítica</a></li>
                        <li><a href="../vista/razonamiento.php">Razonamiento cuantitativo</a></li>
                        <li><a href="../vista/ciudadana.php">Competencia ciudadana</a></li>
                        <li><a href="../vista/comunicacion.php">Comunicación</a></li>
                        <li><a href="../vista/ingles.php">Inglés</a></li>
                    </ul>
                </li>
                <li><a href="../vista/PRUEBAS.php">Pruebas</a></li>
                <li><a href="../vista/nosotros.php">Nosotros</a></li>
                <li><a href="#">Mi perfil</a>
                    <ul>
                        <li><a href="#" onclick="abrirModal()">Ver perfil</a></li>
                        <li><a href="#" onclick="confirmarCerrarSesion()">Cerrar sesión</a></li>
                    </ul>
                </li>

                <!-- Modal para Ver Perfil -->
<div class="modal fade" id="perfilModal" tabindex="-1" aria-labelledby="perfilModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="perfilModalLabel">Mi Perfil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="perfil-bolita text-center mb-4">
                    <img id="fotoPerfil">
                </div>
                <form id="formFotoPerfil">
                <input type="file" name="foto" id="inputFoto" accept="image/*" style="display: none;" onchange="mostrarFoto(event);">
                    <button type="file" class="btn btn-primary mt-2" onclick="document.getElementById('inputFoto').click();">Seleccionar Foto</button>
                    <button type="button" class="btn btn-success mt-2" onclick="subirFoto()">Subir Foto</button>
                </form>
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
                <button type="button" class="btn btn-primary" id="btnEditar" onclick="habilitarEdicion()">Editar</button>
                <button type="button" class="btn btn-success" id="btnGuardar" onclick="guardarCambios()"
                    style="display: none;">Guardar</button>
            </div>
        </div>
    </div>
</div>

            </ul>
        </nav>
    </div>
</div>
</header>