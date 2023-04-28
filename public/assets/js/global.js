

// /** CLIENT-SIDE VALIDATION FORM */

// // Récupération du formulaire
// const form = document.querySelector("brief-form");

// // Écouteur d'événements sur le formulaire pour la soumission
// form.addEventListener("submit", function (event) {
//   // Annulation de l'envoi du formulaire par défaut pour pouvoir le valider avec JavaScript
//   event.preventDefault();

//   // Récupération des champs du formulaire à valider
//   const customerName = document.querySelector("#customer-name");
//   const customerLastname = document.querySelector("#customer-lastname");
//   const company = document.querySelector("#company");
//   const phone = document.querySelector("#phone");
//   // Ajoutez d'autres champs selon les besoins

//   // Validation du champ 1
//   if (input1.value === "") {
//     input1.classList.add("is-invalid");
//     input1.classList.remove("is-valid");
//     input1.nextElementSibling.classList.add("invalid-feedback");
//     input1.nextElementSibling.innerText = "Le champ 1 est requis.";
//   } else {
//     input1.classList.remove("is-invalid");
//     input1.classList.add("is-valid");
//     input1.nextElementSibling.classList.add("valid-feedback");
//     input1.nextElementSibling.innerText = "Le champ 1 est valide.";
//   }

//   // Validation du champ 2 (exemple de validation d'un email)
//   const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
//   if (!emailRegex.test(input2.value)) {
//     input2.classList.add("is-invalid");
//     input2.classList.remove("is-valid");
//     input2.nextElementSibling.classList.add("invalid-feedback");
//     input2.nextElementSibling.innerText =
//       "Le champ 2 doit être une adresse email valide.";
//   } else {
//     input2.classList.remove("is-invalid");
//     input2.classList.add("is-valid");
//     input2.nextElementSibling.classList.add("valid-feedback");
//     input2.nextElementSibling.innerText = "Le champ 2 est valide.";
//   }

//   // Ajoutez d'autres validations selon les besoins
// });

// Add website button
const addWebsiteLink = document.querySelector(".add_website_link");
const websitesCollection = document.querySelector(".websites");

console.log("test");

// addWebsiteLink.addEventListener("click", () => {
//   console.log("cc");
//   const index = websitesCollection.children.length;
//   const newWebsite = briefForm.websites.add();
//   const newWebsiteHtml = websitesCollection.dataset.prototype.replace(
//     /__name__/g,
//     index
//   );

//   newWebsiteHtml.querySelectorAll("input").forEach((input, i) => {
//     input.name = input.name.replace(/__name__/g, index);
//     input.id = input.id.replace(/__name__/g, index);
//   });

//   newWebsite.innerHTML = newWebsiteHtml;
// });

// document.querySelectorAll(".add_website_link").forEach((btn) => {
//   btn.addEventListener("click", addFormToCollection);
// });

addWebsiteLink.addEventListener("click", () => {
  console.log("testFunction");
});

const testFunction = () => {
  console.log("testFunction");
};
const addFormToCollection = (e) => {
  console.log("test1");
  const collectionHolder = document.querySelector(
    "." + e.currentTarget.dataset.collectionHolderClass
  );

  const item = document.createElement("div");

  item.innerHTML = collectionHolder.dataset.prototype.replace(
    /__name__/g,
    collectionHolder.dataset.index
  );

  collectionHolder.appendChild(item);

  collectionHolder.dataset.index++;
};
