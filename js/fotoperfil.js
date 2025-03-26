async function subirFotoPerfil(idAprendiz, archivo) {
    const formData = new FormData();
    formData.append('idAprendiz', idAprendiz);
    if (archivo) {
        formData.append('foto', archivo);
    }

    try {
        const response = await fetch('../php/fotoperfil.php', {
            method: 'POST',
            body: formData,
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const result = await response.json();
        if (result.success) {
            const reader = new FileReader();
            reader.onload = function (e) {
                document.getElementById('fotoPerfil').src = e.target.result;
            };
            if (archivo) {
                reader.readAsDataURL(archivo);
            }
            alert(result.message);
        } else {
            alert(result.message);
        }
    } catch (error) {
        console.error('Error al subir la foto:', error);
        alert('Error al subir la foto. Por favor, inténtalo de nuevo.');
    }
}
