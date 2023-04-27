/*
 ** BRIEF FORM
 */

/** Champ conditionnel choix pack artisan **/

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

// Met à jour le texte lorsque l'utilisateur sélectionne un fichier
const fileInput = document.getElementById("brief_files_uploaded");
const fileSelected = document.querySelector(".file-selected");

fileInput.addEventListener("change", (event) => {
  const fileName = event.target.files[0].name;
  fileSelected.textContent = fileName;
});

/** CLIENT-SIDE VALIDATION FORM */

// Récupération du formulaire
const form = document.querySelector("brief-form");

// Écouteur d'événements sur le formulaire pour la soumission
form.addEventListener("submit", function (event) {
  // Annulation de l'envoi du formulaire par défaut pour pouvoir le valider avec JavaScript
  event.preventDefault();

  // Récupération des champs du formulaire à valider
  const customerName = document.querySelector("#customer-name");
  const customerLastname = document.querySelector("#customer-lastname");
  const company = document.querySelector("#company");
  const phone = document.querySelector("#phone");
  // Ajoutez d'autres champs selon les besoins

  // Validation du champ 1
  if (input1.value === "") {
    input1.classList.add("is-invalid");
    input1.classList.remove("is-valid");
    input1.nextElementSibling.classList.add("invalid-feedback");
    input1.nextElementSibling.innerText = "Le champ 1 est requis.";
  } else {
    input1.classList.remove("is-invalid");
    input1.classList.add("is-valid");
    input1.nextElementSibling.classList.add("valid-feedback");
    input1.nextElementSibling.innerText = "Le champ 1 est valide.";
  }

  // Validation du champ 2 (exemple de validation d'un email)
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailRegex.test(input2.value)) {
    input2.classList.add("is-invalid");
    input2.classList.remove("is-valid");
    input2.nextElementSibling.classList.add("invalid-feedback");
    input2.nextElementSibling.innerText =
      "Le champ 2 doit être une adresse email valide.";
  } else {
    input2.classList.remove("is-invalid");
    input2.classList.add("is-valid");
    input2.nextElementSibling.classList.add("valid-feedback");
    input2.nextElementSibling.innerText = "Le champ 2 est valide.";
  }

  // Ajoutez d'autres validations selon les besoins
});

// Add website button
const addWebsiteLink = document.querySelector(".add_website_link");
const websitesCollection = document.querySelector(".websites");

addWebsiteLink.addEventListener("click", () => {
  const index = websitesCollection.children.length;
  const newWebsite = briefForm.websites.add();
  const newWebsiteHtml = websitesCollection.dataset.prototype.replace(
    /__name__/g,
    index
  );

  newWebsiteHtml.querySelectorAll("input").forEach((input, i) => {
    input.name = input.name.replace(/__name__/g, index);
    input.id = input.id.replace(/__name__/g, index);
  });

  newWebsite.innerHTML = newWebsiteHtml;
});
