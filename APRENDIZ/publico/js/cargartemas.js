// Obtener el módulo actual desde la URL
function obtenerModuloActual() {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get('modulo'); // debe coincidir con ?modulo= en la URL
}

// Cargar los temas desde el servidor según el módulo
function cargarTemas(modulo) {
    console.log(`Iniciando carga de temas para módulo: ${modulo}`);
    
    const select = document.getElementById('temaModulo');
    if (!select) {
        console.error("Elemento select con id 'temaModulo' no encontrado.");
        return;
    }

    select.innerHTML = '<option value="">Cargando temas...</option>';
    select.disabled = true;

    fetch(`/trabajos/PruebasTYT/APRENDIZ/controlador/obtenerTemas.php?modulo=${encodeURIComponent(modulo)}`)
        .then(response => {
            if (!response.ok) {
                throw new Error("Error en la respuesta del servidor");
            }
            return response.json();
        })
        .then(data => {
            console.log("Temas recibidos:", data);
            if (data.success && data.temas.length > 0) {
                select.innerHTML = '<option value="">Seleccione un tema</option>';
                data.temas.forEach(tema => {
                    const option = document.createElement('option');
                    option.value = tema.idtemaModulo;
                    option.textContent = tema.nombreTema;
                    select.appendChild(option);
                });
            } else {
                select.innerHTML = '<option value="">No hay temas disponibles</option>';
            }
            select.disabled = false;
        })
        .catch(error => {
            console.error("Error al cargar temas:", error);
            select.innerHTML = '<option value="">Error al cargar temas</option>';
            select.disabled = false;
        });
}

// Manejador del formulario
function manejarEnvioFormulario(event) {
    event.preventDefault();

    const form = event.target;
    const temaModulo = form.temaModulo.value;

    if (!temaModulo) {
        alert('Por favor seleccione un tema');
        return;
    }

    // Guardar el tema seleccionado en localStorage
    localStorage.setItem('temaModuloSeleccionado', temaModulo);

    form.submit();
}

// Inicializar todo al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    const modulo = obtenerModuloActual();
    console.log("Módulo detectado:", modulo);

    if (modulo) {
        cargarTemas(modulo);

        // Preseleccionar el tema guardado en localStorage si existe
        const temaGuardado = localStorage.getItem('temaModuloSeleccionado');
        if (temaGuardado) {
            const select = document.getElementById('temaModulo');
            if (select) {
                select.value = temaGuardado;
            }
        }
    } else {
        console.error("No se pudo determinar el módulo actual desde la URL");
    }

    const form = document.getElementById('formPrueba');
    if (form) {
        form.addEventListener('submit', manejarEnvioFormulario);
    }
});