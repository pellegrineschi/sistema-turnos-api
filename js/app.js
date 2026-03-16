function cargarHorarios() {
  fetch(
    "http://localhost/sistema-turnos-api/api/profesionales/disponibilidad.php?profesional_id=1&fecha=2026-03-25",
  )
    .then((response) => response.json())

    .then((data) => {
      const lista = document.getElementById("lista-horarios");

      lista.innerHTML = "";

      data.horarios_disponibles.forEach((hora) => {
        const li = document.createElement("li");

        li.classList.add("list-group-item");

        li.textContent = hora;

        lista.appendChild(li);
      });
    })

    .catch((error) => {
      console.error("Error al cargar horarios:", error);
    });
}
