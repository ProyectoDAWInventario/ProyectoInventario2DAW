// obtiene una referencia al botón de opción "Profesor"
const profesorRadio = document.getElementById("profesorRadio");
// obtiene una referencia al botón de opción "Personal de Mantenimiento"
const personalRadio = document.getElementById("personalRadio");
// obtiene una referencia al botón de opción "Personal de Mantenimiento"
// const adminRadio = document.getElementById("adminRadio");
// obtiene una referencia al elemento select que contiene la lista desplegable
const selectPersonal = document.getElementById("selectPersonal");

// Agrego un controlador de eventos para el botón de opción "Profesor"
profesorRadio.addEventListener("click", function () {
  // verifica si el botón de opción "Profesor" está seleccionado
  if (profesorRadio.checked) {
    // muestra la lista desplegable
    selectPersonal.style.display = "block";
  } else {
    // oculta la lista desplegable
    selectPersonal.style.display = "none";
  }
});

// Agrego un controlador de eventos para el botón de opción "Profesor"
// adminRadio.addEventListener("click", function() {
//     // verifica si el botón de opción "Admin" está seleccionado
//     if (adminRadio.checked) {
//       // muestra la lista desplegable
//       selectPersonal.style.display = "none";
//     } else {
//       // oculta la lista desplegable
//       selectPersonal.style.display = "block";
//     }
// })

// Agrego un controlador de eventos para cuando pulsemos el boton de "Personal de Mantenimiento"
personalRadio.addEventListener("click", function () {
  // verifica si el botón de opción "Profesor" está seleccionado
  if (personalRadio.checked) {
    // muestra la lista desplegable
    selectPersonal.style.display = "none";
  } else {
    // oculta la lista desplegable
    selectPersonal.style.display = "block";
  }
});
