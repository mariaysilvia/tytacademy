document.getElementById('formularioPrueba').addEventListener('submit', function (event) {
    event.preventDefault(); // Evitar el envío predeterminado del formulario

    let respuestasConEstado = [];
    let todasPreguntasRespondidas = true;

    for (let i = 1; i <= 20; i++) {
        let pregunta = `p${i}`;
        let seleccionada = document.querySelector(`input[name="${pregunta}"]:checked`);
        let respuestaSeleccionada = seleccionada ? parseInt(seleccionada.value) : null;

        if (!seleccionada) {
            todasPreguntasRespondidas = false;
            break;
        }

        respuestasConEstado.push({
            pregunta: pregunta,
            respuestaUsuario: respuestaSeleccionada
        });
    }

    if (!todasPreguntasRespondidas) {
        alert("Lo siento, debes marcar todas las preguntas.");
        return;
    }

    // Enviar respuestas al servidor
    fetch('../php/corregirpruebacritica.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(respuestasConEstado)
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert(data.error);
            return;
        }
        document.getElementById('resultados').textContent = `Preguntas acertadas: ${data.aciertos}`;
        document.getElementById('incorrectas').textContent = `Preguntas incorrectas: ${data.incorrectas.length}`;
        console.log("Respuestas con estado:", data.respuestas);
    })
    .catch(error => console.error('Error:', error));
});

document.getElementById('btnCorregir').addEventListener('click', function () {
    let respuestasConEstado = [];
    let todasPreguntasRespondidas = true;

    for (let i = 1; i <= 20; i++) {
        let pregunta = `p${i}`;
        let seleccionada = document.querySelector(`input[name="${pregunta}"]:checked`);
        let respuestaSeleccionada = seleccionada ? parseInt(seleccionada.value) : null;

        if (!seleccionada) {
            todasPreguntasRespondidas = false;
            break;
        }

        respuestasConEstado.push({
            pregunta: pregunta,
            respuestaUsuario: respuestaSeleccionada
        });
    }

    if (!todasPreguntasRespondidas) {
        alert("Lo siento, debes marcar todas las preguntas.");
        return;
    }

    // Enviar respuestas al servidor
    fetch('../php/corregirpruebacritica.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(respuestasConEstado)
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert(data.error);
            return;
        }
        document.getElementById('resultados').textContent = `Preguntas acertadas: ${data.aciertos}`;
        document.getElementById('incorrectas').textContent = `Preguntas incorrectas: ${data.incorrectas.length}`;
        console.log("Respuestas con estado:", data.respuestas);
    })
    .catch(error => console.error('Error:', error));
});
