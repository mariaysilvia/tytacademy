// Script para corrección de prueba de lectura crítica
document.getElementById('btnCorregir').addEventListener('click', corregirPrueba);

function corregirPrueba() {
    let respuestasConEstado = {};

    // Validar que se hayan respondido todas las preguntas
    for (let i = 1; i <= 20; i++) {
        let pregunta = `p${i}`;
        let seleccionada = document.querySelector(`input[name="${pregunta}"]:checked`);

        if (!seleccionada) {
            alert(`Debes marcar la respuesta para la pregunta ${i}`);
            return null;
        }

        let respuestaSeleccionada = parseInt(seleccionada.value);
        respuestasConEstado[i] = respuestaSeleccionada;
    }

    // Envío de respuestas al servidor
    fetch('../controlador/corregirpruebacritica.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(respuestasConEstado)
    })
    .then(response => {
        // Manejo de errores de respuesta
        if (!response.ok) {
            return response.text().then(text => {
                console.error('Texto de error:', text);
                throw new Error(`Error HTTP: estado ${response.status}, texto: ${text}`);
            });
        }

        // Parseo de la respuesta
        return response.text().then(text => {
            try {
                return JSON.parse(text);
            } catch (e) {
                console.error('Error de parseo JSON:', e);
                console.error('Texto recibido:', text);
                throw new Error('Respuesta JSON inválida');
            }
        });
    })
    .then(data => {
        // Manejo de errores del servidor
        if (data.error) {
            console.error('Error del servidor:', data.error);
            alert(data.error);
            return null;
        }

        // Mostrar resultados
        const resultadosSpan = document.getElementById('resultados');
        
        if (resultadosSpan) {
            resultadosSpan.textContent = `Aciertos: ${data.aciertos} de ${data.total_preguntas}`;
        }

        return {
            aciertos: data.aciertos,
            totalPreguntas: data.total_preguntas,
            preguntasIncorrectas: data.incorrectas,
            respuestasDetalladas: data.respuestas
        };
    })
    .catch(error => {
        console.error('Error en la solicitud:', error);
        alert('Hubo un problema al procesar la prueba');
        return null;
    });
}