// Función para obtener parámetros de la URL
function obtenerParametroURL(nombre) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(nombre);
}

// Función para cargar los datos de la pregunta
async function cargarDatosPregunta() {
    const idPregunta = obtenerParametroURL('id');
    if (!idPregunta) {
        window.location.href = 'verlaspruebasTYT.php';
        return;
    }

    try {
        const response = await fetch(`../controlador/pregunta.php?accion=obtener&id=${idPregunta}`);
        const data = await response.json();
        
        if (data.success) {
            // Llenar el formulario con los datos
            document.getElementById('idPregunta').value = data.pregunta.idPregunta;
            document.getElementById('pregunta').value = data.pregunta.pregunta;
            document.getElementById('idtipoPregunta').value = data.pregunta.idtipoPregunta;
            document.getElementById('idtemaModulo').value = data.pregunta.idtemaModulo;
            
            // Mostrar imagen actual si existe
            if (data.pregunta.imagen) {
                const imagenActual = document.getElementById('imagenActual');
                imagenActual.innerHTML = `
                    <img src="${data.pregunta.imagen}" alt="Imagen actual" style="max-width: 200px; max-height: 200px;">
                `;
            }
            
            // Llenar las respuestas
            data.respuestas.forEach((respuesta, index) => {
                const letra = ['A', 'B', 'C', 'D'][index];
                document.getElementById(`opcion${letra}-text`).value = respuesta.respuesta;
                if (respuesta.esCorrecta) {
                    document.getElementById(`opcion${letra}`).checked = true;
                }
            });
        } else {
            mostrarMensaje(data.message || 'Error al cargar la pregunta', 'error');
            setTimeout(() => {
                window.location.href = 'verlaspruebasTYT.php';
            }, 2000);
        }
    } catch (error) {
        console.error('Error:', error);
        mostrarMensaje('Error al cargar la pregunta', 'error');
    }
}

// Función para manejar el envío del formulario
async function manejarEnvioFormulario(e) {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    
    // Obtener las opciones seleccionadas
    const opcionesRadio = document.getElementsByName('opciones');
    let respuestaCorrecta = -1;
    
    opcionesRadio.forEach((radio, index) => {
        if (radio.checked) {
            respuestaCorrecta = index;
        }
    });
    
    formData.append('respuestaCorrecta', respuestaCorrecta);
    
    try {
        const response = await fetch('../controlador/pregunta.php?accion=editar', {
            method: 'POST',
            body: formData
        });
        const data = await response.json();
        
        if (data.success) {
            mostrarMensaje('Pregunta actualizada exitosamente', 'success');
            setTimeout(() => {
                window.location.href = 'verlaspruebasTYT.php';
            }, 2000);
        } else {
            mostrarMensaje(data.message || 'Error al actualizar la pregunta', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        mostrarMensaje('Error al actualizar la pregunta', 'error');
    }
}

// Función para mostrar mensajes
function mostrarMensaje(mensaje, tipo) {
    const mensajeDiv = document.getElementById('mensaje');
    mensajeDiv.textContent = mensaje;
    mensajeDiv.className = `mensaje ${tipo}`;
    mensajeDiv.style.display = 'block';
    
    setTimeout(() => {
        mensajeDiv.style.display = 'none';
    }, 3000);
}

// Inicializar cuando el documento esté listo
document.addEventListener('DOMContentLoaded', function() {
    cargarDatosPregunta();
    
    const form = document.getElementById('formEditarPregunta');
    form.addEventListener('submit', manejarEnvioFormulario);
}); 