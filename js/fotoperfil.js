let idAprendiz = null; // Inicializar como null global

// Función para obtener el ID del aprendiz desde el servidor
async function obtenerIdAprendiz() {
    try {
        const response = await fetch('../php/fotoperfil.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=getIdAprendiz'
        });
        const result = await response.json();
        
        if (result.success && result.idAprendiz) {
            idAprendiz = result.idAprendiz;
            return idAprendiz;
        } else {
            console.error('No se pudo obtener el ID del aprendiz:', result.message);
            alert('Error al obtener el ID del aprendiz. Por favor, inicia sesión nuevamente.');
            return null;
        }
    } catch (error) {
        console.error('Error al obtener el ID del aprendiz:', error);
        alert('Error al comunicarse con el servidor para obtener el ID del aprendiz.');
        return null;
    }
}

// Asegurarse de que `idAprendiz` esté definido antes de cualquier acción
async function inicializarIdAprendiz() {
    if (!idAprendiz) {
        return await obtenerIdAprendiz();
    }
    return idAprendiz;
}

// Función para mostrar la foto seleccionada
function mostrarFoto(event) {
    const inputFoto = event.target;
    const fotoPerfil = document.getElementById('fotoPerfil');

    if (inputFoto.files && inputFoto.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            fotoPerfil.src = e.target.result; // Actualiza la imagen con la foto seleccionada
        };
        reader.readAsDataURL(inputFoto.files[0]);
    }
}

// Nueva función para subir foto
async function subirFoto() {
    const inputFoto = document.getElementById('inputFoto');
    
    if (inputFoto.files.length === 0) {
        alert('Por favor, selecciona una foto primero');
        return;
    }

    await subirFotoPerfil(inputFoto.files[0]);
    
    // Limpiar el input de archivo después de subir
    inputFoto.value = '';
}

async function subirFotoPerfil(archivo) {
    // Asegurarse de que `idAprendiz` esté definido
    const id = await inicializarIdAprendiz();
    
    if (!id) {
        console.error('ID de aprendiz no proporcionado');
        alert('Por favor, inicia sesión nuevamente');
        return;
    }

    const formData = new FormData();

    if (archivo) {
        if (archivo.size > 5 * 1024 * 1024) {
            alert('El archivo es demasiado grande. Máximo 5MB.');
            return;
        }

        const tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];
        if (!tiposPermitidos.includes(archivo.type)) {
            alert('Solo se permiten archivos JPG, PNG y GIF');
            return;
        }

        formData.append('foto', archivo);
    }

    try {
        const response = await fetch('../php/fotoperfil.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            console.log('Foto subida correctamente:', result.message);
            
            if (result.rutaFoto) {
                // Usar ruta completa desde la raíz del sitio
                const rutaCompletaImagen = '../' + result.rutaFoto;
                document.getElementById('fotoPerfil').src = rutaCompletaImagen;
                console.log('Ruta de imagen establecida:', rutaCompletaImagen);
            } else {
                document.getElementById('fotoPerfil').src = '../image/fotopredeterminada.jpg';
            }
            
            alert(result.message || 'Foto subida con éxito');
        } else {
            console.error('Error del servidor:', result.message);
            alert(result.message || 'Error desconocido al subir la foto');
        }
    } catch (error) {
        console.error('Error completo al subir la foto:', error);
        alert(`Error al subir la foto: ${error.message}. Revisa la consola para más detalles.`);
    }
}