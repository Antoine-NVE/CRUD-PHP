const supprimer = document.getElementsByClassName("supprimer");

for (i = 0; i < supprimer.length; i++) {
  const supprimerId = document.getElementById(supprimer[i].id);
  supprimerId.addEventListener("click", () => {
    if (confirm("Supprimer ce membre ?")) {
      window.location = "./php/traitementdelete.php?id=" + supprimerId.id;
    }
  });
}
