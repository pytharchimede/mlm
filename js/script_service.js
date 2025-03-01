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
    let sectionHTML = "";

    data.sections.forEach((section) => {
      let content = "";
      let previewButton = "";

      // Construction de l'URL absolue pour le média
      let mediaURL = window.location.origin + "/test" + section.media;

      if (section.type === "image") {
        content = `<img src="${mediaURL}" alt="${section.alt}" class="w-full h-48 object-cover rounded-lg">`;
        previewButton = `<div class="preview-icon absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-black bg-opacity-60 text-white p-2 rounded-full text-lg opacity-0 hover:opacity-100 transition duration-300 cursor-pointer" onclick="openPreview('${section.media}', 'image')">
                          <i class="fas fa-search-plus"></i>
                        </div>`;
      } else if (section.type === "video") {
        content = `<video controls class="w-full h-48 object-cover rounded-lg">
                    <source src="${mediaURL}" type="video/mp4">
                    Votre navigateur ne supporte pas la lecture de vidéos.
                  </video>`;
      } else if (section.type === "text") {
        content = `<div class="bg-gray-700 text-white text-center p-4 rounded-lg shadow-md w-full">
                     <p>${section.text}</p>
                   </div>`;
      }

      sectionHTML += `
        <div class="media-item relative bg-gray-800 p-4 rounded-lg shadow-lg flex flex-col items-center text-center">
          ${content}
          ${previewButton}
          <div class="share-buttons flex justify-center gap-3 mt-4">
            <!-- Facebook Share Button -->
            <a href="#" onclick="shareOnFacebook('${mediaURL}')" class="bg-blue-600 p-3 rounded-full text-white text-lg">
              <i class="fab fa-facebook-f"></i>
            </a>
            
            <!-- WhatsApp Share Button -->
            <a href="#" onclick="shareOnWhatsApp('${mediaURL}')" class="bg-green-500 p-3 rounded-full text-white text-lg">
              <i class="fab fa-whatsapp"></i>
            </a>
            
            <!-- Telegram Share Button -->
            <a href="#" onclick="shareOnTelegram('${mediaURL}')" class="bg-blue-400 p-3 rounded-full text-white text-lg">
              <i class="fab fa-telegram-plane"></i>
            </a>
            
            <!-- Email Share Button -->
            <a href="#" onclick="shareByEmail('${mediaURL}')" class="bg-red-500 p-3 rounded-full text-white text-lg">
              <i class="fas fa-envelope"></i>
            </a>
            
            <!-- Download Button -->
            <a href="${mediaURL}" download class="bg-gray-600 p-3 rounded-full text-white text-lg">
              <i class="fas fa-download"></i>
            </a>
          </div>
        </div>
      `;
    });

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

// 💡 Fonctions de partage
function shareOnFacebook(mediaURL) {
  const shareURL = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(
    mediaURL
  )}`;
  window.open(shareURL, "_blank", "width=600,height=400");
}

function shareOnWhatsApp(mediaURL) {
  const shareURL = `https://wa.me/?text=${encodeURIComponent(mediaURL)}`;
  window.open(shareURL, "_blank");
}

function shareOnTelegram(mediaURL) {
  const shareURL = `https://t.me/share/url?url=${encodeURIComponent(mediaURL)}`;
  window.open(shareURL, "_blank");
}

function shareByEmail(mediaURL) {
  const subject = "Découvrez ce média !";
  const body = `Salut, regarde ce que j'ai trouvé : ${mediaURL}`;
  const mailtoLink = `mailto:?subject=${encodeURIComponent(
    subject
  )}&body=${encodeURIComponent(body)}`;
  window.location.href = mailtoLink;
}

function downloadMedia(mediaURL) {
  const link = document.createElement("a");
  link.href = mediaURL;
  link.download = mediaURL.split("/").pop(); // Nom du fichier à partir de l'URL
  link.click();
}

/*
III- TEXTES INSPIRANTS
*/

// Charger le fichier JSON et insérer dynamiquement les textes dans le carrousel
fetch("inspirationalTexts.json")
  .then((response) => response.json())
  .then((data) => {
    const container = document.getElementById("inspirational-text-container");
    container.innerHTML = ""; // Vider le contenu avant d'ajouter les textes inspirants

    data.texts.forEach((text, index) => {
      let encodedText = encodeURIComponent(text.content); // 🔥 Encodage du texte inspirant
      let textCard = `
        <div class="bg-gray-700 p-6 rounded-lg shadow-md text-white">
            <blockquote class="italic text-lg mb-4">"${text.content}"</blockquote>
            <button class="copy-btn bg-blue-500 px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition" 
                    data-content="${encodedText}" 
                    id="copy-btn-${index}">
                📋 Copier
            </button>
        </div>
      `;
      container.innerHTML += textCard;
    });

    // Ajouter un EventListener à chaque bouton de copie
    document.querySelectorAll(".copy-btn").forEach((button) => {
      button.addEventListener("click", () => {
        let content = decodeURIComponent(button.getAttribute("data-content")); // 🔥 Décodage avant la copie
        navigator.clipboard
          .writeText(content)
          .then(() => {
            alert("Texte inspirant copié !");
          })
          .catch((err) => {
            console.error("Erreur lors de la copie:", err);
          });
      });
    });
  })
  .catch((error) => {
    console.error("Erreur lors du chargement du fichier JSON:", error);
  });

/*
IV- TÉMOIGNAGES
*/

// Charger les données des témoignages et les insérer dans le carrousel
fetch("testimonials.json")
  .then((response) => response.json())
  .then((data) => {
    const container = document.getElementById("testimonials-container");
    container.innerHTML = ""; // Vider avant d'ajouter les témoignages

    data.testimonials.forEach((testimonial, index) => {
      let encodedContent = encodeURIComponent(testimonial.content); // 🔥 Encode le texte
      let testimonialCard = `
        <div class="bg-gray-700 p-6 rounded-lg shadow-md text-white">
            <blockquote class="italic text-lg mb-4">"${testimonial.content}"</blockquote>
            <p class="font-bold">${testimonial.author}</p>
            <button class="copy-btn bg-blue-500 px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition" 
                    data-content="${encodedContent}" 
                    id="copy-btn-${index}">
                📋 Copier
            </button>
        </div>
      `;
      container.innerHTML += testimonialCard;
    });

    // Ajouter un EventListener à chaque bouton de copie
    document.querySelectorAll(".copy-btn").forEach((button) => {
      button.addEventListener("click", () => {
        let content = decodeURIComponent(button.getAttribute("data-content")); // 🔥 Décoder avant la copie
        console.log(content); // Debug
        navigator.clipboard
          .writeText(content)
          .then(() => {
            alert("Témoignage copié !");
          })
          .catch((err) => {
            console.error("Erreur lors de la copie:", err);
          });
      });
    });
  })
  .catch((error) => {
    console.error("Erreur lors du chargement du fichier JSON:", error);
  });
