const autorizar = document.getElementById("autorizar");

const autorizarPermiso = () => {
  fetch("../archivosComunes/gestionUsuariosAdmin.php")
    .then((response) => response.json())
    .then((datos) => console.log(datos));
};

// Quiero hacer las consultas de autorizar denegar y efectuar admin con fetch a ver si soy capaz de hacerlo. Si alguno se atreve, ya sabe AL TAJOOOOOOOOOOOOO
