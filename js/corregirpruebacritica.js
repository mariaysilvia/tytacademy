document.getElementById('btnCorregir').addEventListener('click', function () {
    let respuestasCorrectas = {
        p1: 4, // Respuesta correcta para la pregunta 1
        p2: 3, // Respuesta correcta para la pregunta 2
        p3: 3, // Respuesta correcta para la pregunta 3
        p4: 3, // Respuesta correcta para la pregunta 4
        p5: 2, // Respuesta correcta para la pregunta 5
        p6: 2, // Respuesta correcta para la pregunta 6
        p7: 4, // Respuesta correcta para la pregunta 7
        p8: 4, // Respuesta correcta para la pregunta 8
        p9: 1, // Respuesta correcta para la pregunta 9
        p10: 3 // Respuesta correcta para la pregunta 10
    };

    let totalCorrectas = 0; // Contador para respuestas correctas
    let totalIncorrectas = 0; // Contador para respuestas incorrectas
    let respuestasIncorrectas = []; // Array para almacenar las respuestas incorrectas
    let respuestasCorrectasList = []; // Array para almacenar las respuestas correctas
    let todasPreguntasRespondidas = true; // Variable para verificar si todas las preguntas han sido respondidas

    // Recorremos cada pregunta del 1 al 10
    for (let i = 1; i <= 10; i++) {
        let pregunta = `p${i}`;
        let seleccionada = document.querySelector(`input[name="${pregunta}"]:checked`);
        
        if (!seleccionada) {
            todasPreguntasRespondidas = false; // Si alguna pregunta no está respondida, cambiamos a false
            break;
        }

        let respuestaSeleccionada = parseInt(seleccionada.value);

        // Comprobamos si la respuesta es correcta
        if (respuestaSeleccionada === respuestasCorrectas[pregunta]) {
            totalCorrectas++; // Aumentamos el contador de respuestas correctas
            respuestasCorrectasList.push(`Pregunta ${i}: Respuesta correcta seleccionada: ${respuestaSeleccionada}`); // Almacenamos la respuesta correcta
        } else {
            totalIncorrectas++; // Aumentamos el contador de respuestas incorrectas
            respuestasIncorrectas.push(`Pregunta ${i}: Respuesta seleccionada: ${respuestaSeleccionada}`); // Almacenamos las respuestas incorrectas con su número
        }
    }

    // Si no se han respondido todas las preguntas, se muestra un mensaje de alerta 
    if (!todasPreguntasRespondidas) {
        alert("Lo siento, debes marcar todas las preguntas.");
        return; // Detenemos la ejecución del código para evitar mostrar resultados si no se han marcado todas las preguntas
    }

    // Mostramos los resultados en el HTML
    document.getElementById('resultados').textContent = `Preguntas acertadas: ${totalCorrectas}`;
    document.getElementById('incorrectas').textContent = `Preguntas incorrectas: ${totalIncorrectas}`;

    // Mostramos las respuestas correctas
    console.log("Respuestas correctas:");
    respuestasCorrectasList.forEach(function(correcta) {
        console.log(correcta); // Esto se puede mostrar en el html 
    });

    // Mostramos las respuestas incorrectas
    console.log("Respuestas incorrectas:");
    respuestasIncorrectas.forEach(function(incorrecta) {
        console.log(incorrecta); // Esto se puede mostrar en el html 
    });
});
