// Función para obtener el tipo de prueba de la URL
function obtenerTipoPrueba() {
    const url = window.location.href;
    const tipo = url.split('tipo=')[1];
    return tipo || 'critica';
}

// Función para hacer la petición al servidor
function obtenerTemasDelServidor(tipoPrueba) {
    return new Promise(function(resolve, reject) {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '/trabajos/PruebasTYT/APRENDIZ/controlador/obtenerTemas.php?tipoPrueba=' + tipoPrueba, true);
        
        xhr.onload = function() {
            if (xhr.status === 200) {
                try {
                    const data = JSON.parse(xhr.responseText);
                    resolve(data);
                } catch (e) {
                    reject('Error al procesar la respuesta');
                }
            } else {
                reject('Error en la petición');
            }
        };
        
        xhr.onerror = function() {
            reject('Error de conexión');
        };
        
        xhr.send();
    });
}

// Función para crear las opciones del select
function crearOpcionesTemas(temas) {
    let opciones = '<option value="">Seleccione un tipo de texto</option>';
    
    for (let i = 0; i < temas.length; i++) {
        opciones += `<option value="${temas[i].idtemaModulo}">${temas[i].nombreTema}</option>`;
    }
    
    return opciones;
}

// Función para actualizar el select con los temas
function actualizarSelectTemas(opciones) {
    const select = document.getElementById('temaModulo');
    if (select) {
        select.innerHTML = opciones;
    }
}

// Función para mostrar errores
function mostrarError(mensaje) {
    const select = document.getElementById('temaModulo');
    if (select) {
        select.innerHTML = `<option value="">${mensaje}</option>`;
    }
    console.error(mensaje);
}

// Función principal para cargar los temas
function cargarTemasModulo() {
    const tipoPrueba = obtenerTipoPrueba();
    
    obtenerTemasDelServidor(tipoPrueba)
        .then(function(data) {
            if (data.success) {
                const opciones = crearOpcionesTemas(data.temas);
                actualizarSelectTemas(opciones);
            } else {
                mostrarError(data.error || 'Error al cargar los temas');
            }
        })
        .catch(function(error) {
            mostrarError(error);
        });
}

// Función para manejar el envío del formulario
function manejarEnvioFormulario(event) {
    event.preventDefault();
    
    const form = event.target;
    const temaModulo = form.temaModulo.value;
    const cantidad = form.cantidad.value;
    
    if (!temaModulo) {
        alert('Por favor seleccione un tipo de texto');
        return;
    }
    
    // Enviar el formulario
    form.submit();
}

// Evento cuando el DOM está cargado
document.addEventListener('DOMContentLoaded', function() {
    // Cargar los temas
    cargarTemasModulo();
    
    // Agregar el manejador de eventos al formulario
    const form = document.getElementById('formPrueba');
    if (form) {
        form.addEventListener('submit', manejarEnvioFormulario);
    }
});
