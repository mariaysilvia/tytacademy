document.getElementById('btnFinalizar').addEventListener('click', () => {
    const respuestas = {};
    const radios = document.querySelectorAll('input[type="radio"]:checked');

    radios.forEach(radio => {
        const nombre = radio.name; // ejemplo: respuesta_25
        const idPregunta = nombre.split('_')[1];
        respuestas[idPregunta] = radio.value;
    });

    fetch('/trabajos/PruebasTYT/APRENDIZ/controlador/corregirPrueba.php', {
        method: 'POST',
        body: JSON.stringify(respuestas),
        headers: { 'Content-Type': 'application/json' }
    })
    .then(res => res.json())
    .then(data => {
        if (data.exito) {
            document.getElementById('resCorrectas').innerText = `Correctas: ${data.aciertos}`;
            document.getElementById('resIncorrectas').innerText = `Incorrectas: ${data.fallos}`;
            document.getElementById('tarjetaResultados').classList.remove('tarjeta-oculta');

            document.getElementById('emojiResultado').textContent = data.aciertos >= radios.length / 2 ? '🎉' : '📚';
        } else {
            alert('Error al corregir: ' + (data.error || 'Desconocido'));
        }
    })
    .catch(err => {
        alert('Error de conexión: ' + err);
    });
});

function cerrarTarjeta() {
    document.getElementById('tarjetaResultados').classList.add('tarjeta-oculta');
}
