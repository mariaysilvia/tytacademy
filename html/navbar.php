<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TYT ACADEMY</title>
    <link rel="stylesheet" href="../css/principalAprendiz.css">
    <link rel="stylesheet" href="../css/PRUEBAS.css">
    <link rel="stylesheet" href="../css/lecturacritica.css">
    <link rel="stylesheet" href="../css/razonamiento.css">
    <link rel="stylesheet" href="../css/ciudadana.css">
    <link rel="stylesheet" href="../css/comunicacion.css">
    <link rel="stylesheet" href="../css/ingles.css">
    <link rel="stylesheet" href="../css/nosotros.css">
    <link rel="icon" href="../imagenes/computador.png" type="image/x-icon">
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
            <img src="../imagenes/tytacademy.png" alt="TYT Academy Logo">
        </div>
    </div>

<div class="container_menu">
    <div class="menu">
        <nav>
            <ul>
                <li><a href="../html/principalAprendiz.php" id="selected"></a></li>
                <li><a href="#">Módulos</a>
                    <ul>
                        <li><a href="../html/lecturacritica.php">Lectura crítica</a></li>
                        <li><a href="../html/razonamiento.php">Razonamiento cuantitativo</a></li>
                        <li><a href="../html/ciudadana.php">Competencia ciudadana</a></li>
                        <li><a href="../html/comunicacion.php">Comunicación</a></li>
                        <li><a href="../html/ingles.php">Inglés</a></li>
                    </ul>
                </li>
                <li><a href="../html/PRUEBAS.php">Pruebas</a></li>
                <li><a href="../html/nosotros.php">Nosotros</a></li>
                <li><a href="#">Mi perfil</a>
                    <ul>
                        <li><a href="#" onclick="abrirModal()">Ver perfil</a></li>
                        <li><a href="#" onclick="confirmarCerrarSesion()">Cerrar sesión</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>
