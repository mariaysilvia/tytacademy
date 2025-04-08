// Función para cargar los tipos de pregunta y temas al iniciar
function cargarDatosIniciales() {
    // Cargar tipos de pregunta
    fetch('../controlador/pregunta.php')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const select = document.getElementById('idtipoPregunta');
                data.tipos.forEach(tipo => {
                    const option = document.createElement('option');
                    option.value = tipo.id;
                    option.textContent = tipo.nombre;
                    select.appendChild(option);
                });
            } else {
                mostrarMensaje('Error al cargar tipos de pregunta', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarMensaje('Error al cargar tipos de pregunta', 'error');
        });

    // Cargar temas de módulo
    fetch('../controlador/pregunta.php?accion=temas')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const select = document.getElementById('idtemaModulo');
                data.temas.forEach(tema => {
                    const option = document.createElement('option');
                    option.value = tema.id;
                    option.textContent = tema.nombre;
                    select.appendChild(option);
                });
            } else {
                mostrarMensaje('Error al cargar temas de módulo', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            mostrarMensaje('Error al cargar temas de módulo', 'error');
        });
}

// Función para manejar el envío del formulario
function manejarEnvioFormulario(e) {
    e.preventDefault();
    
    const formData = new FormData();
    formData.append('pregunta', document.getElementById('pregunta').value);
    formData.append('idtipoPregunta', document.getElementById('idtipoPregunta').value);
    formData.append('idtemaModulo', document.getElementById('idtemaModulo').value);
    
    const imagenPregunta = document.getElementById('imagenPregunta').files[0];
    if (imagenPregunta) {
        formData.append('imagenPregunta', imagenPregunta);
    }
    
    // Obtener las opciones seleccionadas
    const opciones = [];
    const opcionesRadio = document.getElementsByName('opciones');
    let respuestaCorrecta = -1;
    
    opcionesRadio.forEach((radio, index) => {
        if (radio.checked) {
            respuestaCorrecta = index;
        }
    });
    
    // Agregar las opciones A, B, C, D
    formData.append('opcionA', document.getElementById('opcionA-text').value);
    formData.append('opcionB', document.getElementById('opcionB-text').value);
    formData.append('opcionC', document.getElementById('opcionC-text').value);
    formData.append('opcionD', document.getElementById('opcionD-text').value);
    formData.append('respuestaCorrecta', respuestaCorrecta);
    
    fetch('../controlador/pregunta.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            mostrarMensaje('Pregunta guardada exitosamente', 'success');
            document.getElementById('formPregunta').reset();
        } else {
            mostrarMensaje(data.message || 'Error al guardar la pregunta', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mostrarMensaje('Error al guardar la pregunta', 'error');
    });
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
    cargarDatosIniciales();
    
    const form = document.getElementById('formPregunta');
    form.addEventListener('submit', manejarEnvioFormulario);
}); 