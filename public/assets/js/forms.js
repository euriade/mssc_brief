/** CHAMP CONDITIONNEL CHOIX DU PACK **/

// Récupération des éléments HTML
const packField = document.getElementById("brief_type");
const artisanField = document.getElementById("brief_pack-artisan");
const avocatField = document.getElementById("brief_pack-avocat");
const messageField = document.getElementById("message_pack");

// Fonction de gestion de l'affichage des champs
function toggleFields() {
  switch (packField.value) {
    case "Pack artisan":
      artisanField.style.display = "";
      avocatField.style.display = "none";
      messageField.style.display = "none";
      break;
    case "Pack avocat":
      artisanField.style.display = "none";
      avocatField.style.display = "";
      messageField.style.display = "none";
      break;
    default:
      artisanField.style.display = "none";
      avocatField.style.display = "none";
      messageField.style.display = "";
      break;
  }
}

// Appel initial de la fonction pour mettre à jour l'affichage au chargement de la page
toggleFields();

// Ajout d'un écouteur d'événement pour détecter les changements dans le champ "pack"
packField.addEventListener("change", toggleFields);

// Applique un filtre gris selon si l'image bouton radio est checked ou non
const images = document.querySelectorAll(".btn-checkbox label img");
images.forEach((image) => {
  const input = image.previousElementSibling;
  input.addEventListener("change", function () {
    images.forEach((img) => {
      img.style.filter = "grayscale(100%)";
    });
    if (this.checked) {
      image.style.filter = "grayscale(0%)";
    } else {
      image.style.filter = "grayscale(100%)";
    }
  });
});
