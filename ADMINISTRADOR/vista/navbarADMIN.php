<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin TYTACADEMY</title>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@48,400,0,0" />
<link rel="icon" href="../publico/imagenesadmin/logoADMIN1.png" type="image/x-icon">
<link rel="stylesheet" href="../publico/css/adminpanel.css">
<link rel="stylesheet" href="../publico/css/crearinstructor.css">
<link rel="stylesheet" href="../publico/css/listaraprendices.css">
<link rel="stylesheet" href="../publico/css/listarinstructores.css">
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
    <aside>

        <div class="top">
        <div class="logo">
            <h2>Admin <span class="danger">Panel</span></h2>
        </div>
        <div class="close" id="close_btn">
            <span class="material-symbols-sharp">
            close
            </span>
        </div>
        </div>

        <div class="sidebar">

        <a href="../vista/adminpanel.php" class="active">
            <span class="material-symbols-sharp">person_outline </span>
            <h3>Administrador</h3>
        </a>
        <a href="../vista/crearinstructor.php">
            <span class="material-symbols-sharp">groups</span>
            <h3>Crear instructores</h3>
        </a>

        <a href="../vista/listarinstructores.php">
            <span class="material-symbols-sharp">clinical_notes</span>
            <h3>Ver Instructores</h3>
        </a>
        <a href="../vista/listaraprendices.php">
            <span class="material-symbols-sharp">how_to_reg</span>
            <h3>Aprendices</h3>
            <span class="msg_count">2</span>
        </a>
        <a href="#">
            <span class="material-symbols-sharp">file_open</span>
            <h3>Pruebas</h3>
        </a>
        <a href="#">
            <span class="material-symbols-sharp">logout </span>
            <h3>Cerrar sesión</h3>
        </a>
    </div>

    </aside>