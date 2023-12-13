const prenom = document.getElementById("prenom");
const nom = document.getElementById("nom");
const retour = document.getElementById("retour");

prenom.addEventListener("input", () => {
  prenom.value =
    prenom.value.charAt(0).toUpperCase() +
    prenom.value.slice(1, prenom.value.length).toLowerCase();
});

nom.addEventListener("input", () => {
  nom.value = nom.value.toUpperCase();
});

retour.addEventListener("click", (e) => {
  e.preventDefault();
  window.location = "../index.php";
});
