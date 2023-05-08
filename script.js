// Datos de ejemplo para los partidos
const partidos = [
    { jornada: 1, local: "Equipo A", versus: "VS", visitante: "Equipo B", fecha: "2023-05-10 20:00" },
    { jornada: 2, local: "Equipo C", versus: "VS", visitante: "Equipo D", fecha: "2023-05-12 18:30" },
    { jornada: 3, local: "Equipo E", versus: "VS",visitante: "Equipo F", fecha: "2023-05-15 19:45" },
    { jornada: 4, local: "Equipo G", versus: "VS", visitante: "Equipo H", fecha: "2023-05-18 21:15" },
    { jornada: 5, local: "Equipo I", versus: "VS", visitante: "Equipo J", fecha: "2023-05-21 17:30" },
    { jornada: 6, local: "Equipo K", versus: "VS", visitante: "Equipo L", fecha: "2023-05-25 19:00" },
];

function generarFilasPartidos(jornadaSeleccionada) {
    const tbody = document.getElementById("calendar-body");
    tbody.innerHTML = ""; // Limpiar contenido anterior
  
    if (jornadaSeleccionada === 0) {
      // Mostrar todos los partidos
      partidos.forEach((partido) => {
        const row = document.createElement("tr");
        const localCell = document.createElement("td");
        localCell.textContent = partido.local;
        const versusCell = document.createElement("td");
        versusCell.textContent = partido.versus;
        const visitanteCell = document.createElement("td");
        visitanteCell.textContent = partido.visitante;
        const fechaCell = document.createElement("td");
        fechaCell.textContent = partido.fecha;
  
        row.appendChild(localCell);
        row.appendChild(versusCell);
        row.appendChild(visitanteCell);
        row.appendChild(fechaCell);
        tbody.appendChild(row);
      });
    } else {
      // Mostrar los partidos de la jornada seleccionada
      const partidosFiltrados = partidos.filter(
        (partido) => partido.jornada === jornadaSeleccionada
      );
  
      partidosFiltrados.forEach((partido) => {
        const row = document.createElement("tr");
        const localCell = document.createElement("td");
        localCell.textContent = partido.local;
        const versusCell = document.createElement("td");
        versusCell.textContent = partido.versus;
        const visitanteCell = document.createElement("td");
        visitanteCell.textContent = partido.visitante;
        const fechaCell = document.createElement("td");
        fechaCell.textContent = partido.fecha;
  
        row.appendChild(localCell);
        row.appendChild(versusCell);
        row.appendChild(visitanteCell);
        row.appendChild(fechaCell);
        tbody.appendChild(row);
      });
    }
  }
  
  function cambiarJornada() {
    const jornadaSelect = document.getElementById("jornada-select");
    const jornadaSeleccionada = parseInt(jornadaSelect.value);
  
    generarFilasPartidos(jornadaSeleccionada);
  }
  
  function mostrarTodasJornadas() {
    const jornadaSelect = document.getElementById("jornada-select");
    jornadaSelect.innerHTML = ""; // Limpiar opciones anteriores
  
    const optionSeleccionar = document.createElement("option");
    optionSeleccionar.value = 0;
    optionSeleccionar.textContent = "Todas las jornadas";
    jornadaSelect.appendChild(optionSeleccionar);
  
    // Obtener todas las jornadas disponibles
    const jornadasDisponibles = Array.from(
      new Set(partidos.map((partido) => partido.jornada))
    );
  
    jornadasDisponibles.forEach((jornada) => {
      const option = document.createElement("option");
      option.value = jornada;
      option.textContent = `Jornada ${jornada}`;
      jornadaSelect.appendChild(option);
    });
  
    generarFilasPartidos(parseInt(jornadaSelect.value));
  }
  
  // Llamada inicial para mostrar todas las jornadas disponibles
  mostrarTodasJornadas();