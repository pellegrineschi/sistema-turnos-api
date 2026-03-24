function cargarHorarios() {
  fetch(
    "http://localhost/sistema-turnos-api/api/profesionales/disponibilidad.php?profesional_id=1&fecha=2026-03-25",
  )
    .then((response) => response.json())

    .then((data) => {
      const lista = document.getElementById("lista-horarios");

      lista.innerHTML = "";

      data.horarios_disponibles.forEach((hora) => {

        const boton = document.createElement("button");

        boton.classList.add("btn", "btn-outline-primary", "m-1");

        boton.textContent = hora;

        //evento click
        boton.addEventListener("click", ()=>{
          reservarTurno(hora);
        });

        lista.appendChild(boton);
        // const li = document.createElement("li");

        // li.classList.add("list-group-item");

        // li.textContent = hora;

        // lista.appendChild(li);
      });
    })

    .catch((error) => {
      console.error("Error al cargar horarios:", error);
    });
}

function reservarTurno(hora) {

  const datos = {
    usuario_id: 1,
    profesional_id: document.getElementById("profesional").value,
    fecha_hora: `2026-03-25 ${hora}:00`,      
  };

  fetch("http://localhost/sistema-turnos-api/api/turnos/crear.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(datos)

  })  
    .then((response) => response.json())
    
    .then((data) => {
      if (data.success) {
        alert("Turno reservado con éxito");
        
      } else {
        alert("Error al reservar turno: " + data.message);
      }
    })
    .catch((error) => {
      console.error("Error al reservar turno:", error);
    });
}

function cargarProfesionales(){

  fetch("http://localhost/sistema-turnos-api/api/profesionales/listar.php")

  .then((response)=> response.json())
  
  .then(data=>{
    console.log(data);
    const select = document.getElementById("profesional");
    select.innerHTML= "";

    data.forEach( prof => {
      const option = document.createElement("option");
      option.value = prof.id;
      option.textContent =  prof.nombre + " - " + prof.especialidad;

      select.appendChild(option);
    })
  })
  .catch(error => {
    console.error("Error al cargar profesionales:", error);
  })
}

window.onload = function() {
  cargarProfesionales();
}
