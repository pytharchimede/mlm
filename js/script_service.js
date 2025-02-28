function copyText(text) {
  navigator.clipboard.writeText(text);
  alert("Texte copié !");
}

/*
I- Questions réponses
*/

// Charger les données depuis le fichier JSON
fetch("questions.json")
  .then((response) => response.json())
  .then((data) => {
    const cardsSection = document.getElementById("cards-section");

    // Boucle sur chaque élément dans les questions
    data.questions.forEach((question) => {
      // Créer un élément div pour chaque carte
      const card = document.createElement("div");
      card.classList.add(
        "bg-gray-800",
        "p-6",
        "rounded-lg",
        "shadow-lg",
        "transform",
        "hover:scale-105",
        "transition",
        "duration-300",
        "ease-in-out"
      );

      // Ajouter l'icône
      const iconDiv = document.createElement("div");
      iconDiv.classList.add("flex", "items-center", "justify-center", "mb-4");
      const icon = document.createElement("i");
      icon.classList.add("fas", question.icon, "text-4xl", question.color);
      iconDiv.appendChild(icon);

      // Ajouter le titre
      const title = document.createElement("h3");
      title.classList.add(
        "text-xl",
        "font-bold",
        "text-center",
        "text-white",
        "mb-4"
      );
      title.textContent = question.title;

      // Ajouter le texte
      const text = document.createElement("p");
      text.classList.add("text-center", "text-lg", "text-gray-300");
      text.textContent = question.text;

      // Ajouter le bouton de copie
      const button = document.createElement("button");
      button.classList.add(
        "bg-blue-500",
        "px-4",
        "py-2",
        "rounded-lg",
        "shadow",
        "hover:bg-blue-700",
        "transition",
        "w-full",
        "mt-4"
      );
      button.textContent = "📋 Copier";
      button.onclick = function () {
        copyText(question.text);
      };

      // Ajouter tous les éléments à la carte
      card.appendChild(iconDiv);
      card.appendChild(title);
      card.appendChild(text);
      card.appendChild(button);

      // Ajouter la carte à la section des cartes
      cardsSection.appendChild(card);
    });
  })
  .catch((err) => console.error("Erreur de chargement du JSON :", err));

/*
II- Images, textes et vdéos de motivation
*/

fetch("mediaSections.json")
  .then((response) => response.json())
  .then((data) => {
    const container = document.getElementById("media-section");
    let sectionHTML = '<div class="media-container">';

    data.sections.forEach((section) => {
      let content = "";
      let previewButton = "";

      if (section.type === "image") {
        content = `<img src="${section.media}" alt="${section.alt}">`;
        previewButton = `<div class="preview-icon" onclick="openPreview('${section.media}', 'image')">
                          <i class="fas fa-search-plus"></i>
                        </div>`;
      } else if (section.type === "video") {
        content = `<video><source src="${section.media}" type="video/mp4"></video>`;
        previewButton = `<div class="preview-icon" onclick="openPreview('${section.media}', 'video')">
                          <i class="fas fa-play"></i>
                        </div>`;
      } else if (section.type === "text") {
        content = `<p>${section.text}</p>`;
      }

      sectionHTML += `
        <div class="media-item">
          ${content}
          ${previewButton}
          <div class="share-buttons">
            <a href="#" onclick="shareOnFacebook()" class="bg-blue-600 p-3 rounded-full text-white text-lg">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" onclick="shareOnWhatsApp()" class="bg-green-500 p-3 rounded-full text-white text-lg">
              <i class="fab fa-whatsapp"></i>
            </a>
            <a href="#" onclick="shareOnTelegram()" class="bg-blue-400 p-3 rounded-full text-white text-lg">
              <i class="fab fa-telegram-plane"></i>
            </a>
            <a href="#" onclick="shareByEmail()" class="bg-red-500 p-3 rounded-full text-white text-lg">
              <i class="fas fa-envelope"></i>
            </a>
          </div>
        </div>
      `;
    });

    sectionHTML += "</div>";
    container.innerHTML = sectionHTML;
  })
  .catch((error) =>
    console.error("Erreur lors du chargement du fichier JSON:", error)
  );

// Fonction d'aperçu
function openPreview(mediaUrl, type) {
  let previewHTML = "";

  if (type === "image") {
    previewHTML = `<img src="${mediaUrl}" class="w-full rounded-md">`;
  } else if (type === "video") {
    previewHTML = `<video controls class="w-full"><source src="${mediaUrl}" type="video/mp4"></video>`;
  }

  const previewModal = document.createElement("div");
  previewModal.innerHTML = `
    <div class="fixed inset-0 bg-black bg-opacity-75 flex justify-center items-center">
      <div class="bg-white p-4 rounded-lg max-w-lg w-full">
        ${previewHTML}
        <button onclick="closePreview()" class="mt-4 px-4 py-2 bg-red-500 text-white rounded-lg">Fermer</button>
      </div>
    </div>
  `;
  previewModal.id = "preview-modal";
  document.body.appendChild(previewModal);
}

// Fermer l'aperçu
function closePreview() {
  document.getElementById("preview-modal").remove();
}

// Fonction d'aperçu
function openPreview(mediaUrl, type) {
  let previewHTML = "";

  if (type === "image") {
    previewHTML = `<img src="${mediaUrl}" class="w-full rounded-md">`;
  } else if (type === "video") {
    previewHTML = `<video controls class="w-full"><source src="${mediaUrl}" type="video/mp4"></video>`;
  }

  const previewModal = document.createElement("div");
  previewModal.innerHTML = `
    <div class="fixed inset-0 bg-black bg-opacity-75 flex justify-center items-center">
      <div class="bg-white p-4 rounded-lg max-w-lg w-full">
        ${previewHTML}
        <button onclick="closePreview()" class="mt-4 px-4 py-2 bg-red-500 text-white rounded-lg">Fermer</button>
      </div>
    </div>
  `;
  previewModal.id = "preview-modal";
  document.body.appendChild(previewModal);
}

// Fermer l'aperçu
function closePreview() {
  document.getElementById("preview-modal").remove();
}

/*
III- TEXTES INSPIRANTS
*/

// Charger le fichier JSON et insérer dynamiquement les textes dans le carrousel
fetch("inspirationalTexts.json")
  .then((response) => response.json())
  .then((data) => {
    const container = document.getElementById("carousel-text-container");
    data.texts.forEach((text, index) => {
      let isActive = index === 0 ? "active" : ""; // Le premier texte est actif
      let carouselItem = `
                <div class="carousel-item ${isActive}">
                    <p class="text-lg text-gray-300 mb-4">${text.content}</p>
                    <button onclick="copyText('${text.copyText}')" class="bg-blue-500 px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">📋 Copier</button>
                </div>
            `;
      container.innerHTML += carouselItem;
    });
  })
  .catch((error) => {
    console.error("Erreur lors du chargement du JSON:", error);
  });
