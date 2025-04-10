// Evento para cargar las preguntas al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    // Verificar si estamos en la página de preguntas
    const urlParams = new URLSearchParams(window.location.search);
    const temaModulo = urlParams.get('temaModulo');
    const cantidad = urlParams.get('cantidad');

    if (temaModulo && cantidad) {
        cargarPreguntas(temaModulo, cantidad);
    }
});

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
    
    // Crear el formulario para enviar respuestas
    const form = document.createElement('form');
    form.id = 'formRespuestas';
    form.method = 'POST';
    
    // Añadir las preguntas al formulario
    preguntas.forEach((grupo, grupoIndex) => {
        // Crear contenedor para el grupo de preguntas
        const grupoDiv = document.createElement('div');
        grupoDiv.className = 'grupo-preguntas';
        grupoDiv.dataset.grupo = grupoIndex;
        
        // Mostrar la imagen común si existe
        if (grupo.imagen) {
            const imgDiv = document.createElement('div');
            imgDiv.className = 'imagen-pregunta';
            const img = document.createElement('img');
            img.src = `data:image/jpeg;base64,${grupo.imagen}`;
            img.alt = 'Imagen de la pregunta';
            imgDiv.appendChild(img);
            grupoDiv.appendChild(imgDiv);
        }
        
        // Mostrar las preguntas del grupo
        grupo.preguntas.forEach((pregunta, preguntaIndex) => {
            const preguntaDiv = document.createElement('div');
            preguntaDiv.className = 'pregunta';
            preguntaDiv.dataset.pregunta = pregunta.id;
            
            const numeroPregunta = document.createElement('div');
            numeroPregunta.className = 'numero-pregunta';
            numeroPregunta.textContent = `Pregunta ${grupoIndex * 10 + preguntaIndex + 1}`;
            preguntaDiv.appendChild(numeroPregunta);
            
            const textoPregunta = document.createElement('p');
            textoPregunta.className = 'texto-pregunta';
            textoPregunta.textContent = pregunta.pregunta;
            preguntaDiv.appendChild(textoPregunta);
            
            // Mostrar las respuestas
            const respuestasDiv = document.createElement('div');
            respuestasDiv.className = 'respuestas';
            
            pregunta.respuestas.forEach((respuesta, respuestaIndex) => {
                const label = document.createElement('label');
                label.className = 'respuesta-item';
                
                const input = document.createElement('input');
                input.type = 'radio';
                input.name = `pregunta_${pregunta.id}`;
                input.value = respuesta.id;
                input.required = true;
                input.id = `respuesta_${pregunta.id}_${respuesta.id}`;
                
                const span = document.createElement('span');
                span.className = 'texto-respuesta';
                span.textContent = respuesta.texto;
                
                label.appendChild(input);
                label.appendChild(span);
                respuestasDiv.appendChild(label);
            });
            
            preguntaDiv.appendChild(respuestasDiv);
            grupoDiv.appendChild(preguntaDiv);
        });
        
        form.appendChild(grupoDiv);
    });
    
    // Añadir botón para enviar respuestas
    const btnEnviar = document.createElement('button');
    btnEnviar.type = 'submit';
    btnEnviar.className = 'botons';
    btnEnviar.textContent = 'Finalizar prueba';
    form.appendChild(btnEnviar);
    
    // Añadir evento para enviar respuestas
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        enviarRespuestas(form);
    });
    
    contenedor.appendChild(form);
}

// Función para enviar las respuestas
function enviarRespuestas(form) {
    // Recopilar todas las respuestas seleccionadas
    const respuestas = {};
    const inputs = form.querySelectorAll('input[type="radio"]:checked');
    
    inputs.forEach(input => {
        const preguntaId = input.name.replace('pregunta_', '');
        respuestas[preguntaId] = input.value;
    });
    
    // Verificar que todas las preguntas tengan respuesta
    const totalPreguntas = form.querySelectorAll('.pregunta').length;
    
    if (Object.keys(respuestas).length < totalPreguntas) {
        alert('Por favor responde todas las preguntas antes de finalizar');
        return;
    }
    
    // Obtener los parámetros de la URL
    const urlParams = new URLSearchParams(window.location.search);
    const tipo = urlParams.get('tipo');
    
    // Enviar las respuestas al servidor
    fetch('/trabajos/PruebasTYT/APRENDIZ/controlador/guardarRespuestas.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            tipo: tipo,
            respuestas: respuestas
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Redirigir a la página de resultados
            window.location.href = `/trabajos/PruebasTYT/APRENDIZ/vista/resultados.php?idPrueba=${data.idPrueba}`;
        } else {
            alert(`Error: ${data.error}`);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al enviar las respuestas. Por favor intenta nuevamente.');
    });
}