document.addEventListener("DOMContentLoaded", function () {
  var swiper = new Swiper(".mySwiper", {
    loop: true,
    autoplay: {
      delay: 3000,
      disableOnInteraction: false,
    },
    effect: "fade",
  });
});
document.addEventListener("DOMContentLoaded", function () {
  // Vérifie si les éléments existent avant d'ajouter des événements
  let openPopupButton = document.getElementById("openPopupButton");
  let closePopupButton = document.getElementById("closePopupButton");
  let organigrammePopup = document.getElementById("organigrammePopup");
  let menuToggle = document.getElementById("menuToggle");
  let activateBtn = document.getElementById("activate-btn");

  if (openPopupButton && organigrammePopup) {
    openPopupButton.addEventListener("click", function () {
      organigrammePopup.style.display = "block";
    });

    organigrammePopup.addEventListener("click", function (e) {
      if (e.target === organigrammePopup) {
        organigrammePopup.style.display = "none";
      }
    });
  }

  if (closePopupButton) {
    closePopupButton.addEventListener("click", function () {
      organigrammePopup.style.display = "none";
    });
  }

  if (menuToggle) {
    menuToggle.addEventListener("click", function () {
      let menu = document.getElementById("profileMenu");
      if (menu) {
        menu.classList.toggle("hidden");
        menu.classList.toggle("opacity-100");
        menu.classList.toggle("scale-100");
      }
    });
  }

  if (activateBtn) {
    activateBtn.addEventListener("click", function () {
      window.location.href = "miner_shop.php";
    });
  }
});

function openInvitePopup() {
  document.getElementById("invitePopup").classList.remove("hidden");
}

function closeInvitePopup() {
  document.getElementById("invitePopup").classList.add("hidden");
}

function shareOnFacebook() {
  let url = encodeURIComponent(document.getElementById("referral-link").value);
  window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, "_blank");
}

function shareOnWhatsApp() {
  let text = encodeURIComponent(
    "Rejoignez CMDB, la tontine en cryptomonnaie et commencez à gagner ! Voici mon lien de parrainage : " +
      document.getElementById("referral-link").value
  );
  window.open(`https://wa.me/?text=${text}`, "_blank");
}

function shareOnTelegram() {
  let text = encodeURIComponent(
    "Rejoignez CMDB, la tontine en cryptomonnaie et commencez à gagner ! Voici mon lien de parrainage : " +
      document.getElementById("referral-link").value
  );
  window.open(`https://t.me/share/url?url=${text}`, "_blank");
}

function shareByEmail() {
  let subject = encodeURIComponent("Invitation à rejoindre CMDB");
  let body = encodeURIComponent(
    "Bonjour,\n\nJe vous invite à rejoindre CMDB, la tontine en cryptomonnaie où vous pouvez investir et générer des revenus passifs. Inscrivez-vous ici : " +
      document.getElementById("referral-link").value
  );
  window.open(`mailto:?subject=${subject}&body=${body}`, "_blank");
}
