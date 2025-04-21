
// Función para cargar preguntas
function cargarPreguntas(temaModulo, cantidad) {
    console.log(`Cargando preguntas: tema=${temaModulo}, cantidad=${cantidad}`);

    // Mostrar indicador de carga
    const contenedor = document.getElementById('preguntas');
    if (contenedor) {
        contenedor.innerHTML = '<div class="cargando">Cargando preguntas...</div>';
    }

    fetch(`/trabajos/PruebasTYT/APRENDIZ/controlador/seleccionarPreguntas.php?temaModulo=${temaModulo}&cantidad=${cantidad}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`Error HTTP: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                mostrarPreguntas(data.preguntas);
            } else {
                console.error('Error:', data.error);
                if (contenedor) {
                    contenedor.innerHTML = `<div class="error">Error: ${data.error}</div>`;
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            if (contenedor) {
                contenedor.innerHTML = `<div class="error">Error al cargar preguntas: ${error.message}</div>`;
            }
        });
}

// Función para mostrar las preguntas
function mostrarPreguntas(preguntas) {
    const contenedor = document.getElementById('preguntas');
    if (!contenedor) {
        console.error('No se encontró el contenedor de preguntas');
        return;
    }

    contenedor.innerHTML = '';

    preguntas.forEach((pregunta, index) => {
        const preguntaDiv = document.createElement('div');
        preguntaDiv.className = 'pregunta';

        const numeroPregunta = document.createElement('h3');
        numeroPregunta.textContent = `Pregunta ${index + 1}`;
        preguntaDiv.appendChild(numeroPregunta);

        const textoPregunta = document.createElement('p');
        textoPregunta.textContent = pregunta.pregunta;
        preguntaDiv.appendChild(textoPregunta);

        const respuestasDiv = document.createElement('div');
        respuestasDiv.className = 'respuestas';

        pregunta.respuestas.forEach(respuesta => {
            const label = document.createElement('label');
            label.className = 'respuesta-item';

            const input = document.createElement('input');
            input.type = 'radio';
            input.name = `pregunta_${pregunta.id}`;
            input.value = respuesta.id;

            const span = document.createElement('span');
            span.textContent = respuesta.texto;

            label.appendChild(input);
            label.appendChild(span);
            respuestasDiv.appendChild(label);
        });

        preguntaDiv.appendChild(respuestasDiv);
        contenedor.appendChild(preguntaDiv);
    });
}