import { startStimulusApp } from "@symfony/stimulus-bridge";

export const app = startStimulusApp(
  require.context(
    "@symfony/stimulus-bridge/lazy-controller-loader!./controllers",
    true,
    /\.(j|t)sx?$/
  )
);

/*
 ** BRIEF FORM
 */

/** Champ conditionnel choix pack artisan **/

// Récupération des éléments HTML
const packField = document.getElementById("brief_type");
const artisanField = document.getElementById("brief_pack-artisan");
const avocatField = document.getElementById("brief_pack-avocat");

// Fonction de gestion de l'affichage des champs
function toggleFields() {
  switch (packField.value) {
    case "Pack artisan":
      artisanField.style.display = "";
      avocatField.style.display = "none";
      break;
    case "Pack avocat":
      artisanField.style.display = "none";
      avocatField.style.display = "";
      break;
    default:
      artisanField.style.display = "none";
      avocatField.style.display = "none";
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

/**
 * BRIEFS TABLE
 */

// Au clic sur la thead, trie les colonnes du tableau par ordre alphabétique
document.addEventListener("DOMContentLoaded", function () {
  const table = document.querySelector("#briefsTable");
  const headers = table.querySelectorAll("th[data-sort]");

  headers.forEach((header) => {
    header.style.cursor = "pointer";
    header.addEventListener("click", function () {
      const columnIndex = parseInt(header.getAttribute("data-sort"));
      sortTable(table, columnIndex);
    });
  });
});

function sortTable(table, columnIndex) {
  const rows = Array.from(table.querySelectorAll("tbody tr"));
  const sortedRows = rows.sort((a, b) => {
    const cellA = a.cells[columnIndex].textContent.trim();
    const cellB = b.cells[columnIndex].textContent.trim();

    return cellA.localeCompare(cellB);
  });

  const tbody = table.querySelector("tbody");
  sortedRows.forEach((row) => tbody.appendChild(row));
}
