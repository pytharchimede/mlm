function payer(amount, packName) {
  // Masquer tous les packs
  const packs = document.querySelectorAll(".pack");
  packs.forEach((pack) => {
    pack.style.display = "none";
  });

  // Afficher uniquement le pack sélectionné
  const selectedPack = document.querySelector(`.pack[data-pack="${packName}"]`);
  if (selectedPack) {
    selectedPack.style.display = "block";
  }

  // Désactiver le bouton et afficher un indicateur de chargement
  const btn = selectedPack.querySelector("button");
  btn.disabled = true;
  btn.innerHTML =
    'Chargement... <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';

  // Faire l'appel pour la création du paiement
  fetch("request/create_paiement.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      price_amount: amount,
      price_currency: "XOF",
      pay_currency: "usdttrc20",
      order_id: packName + "_" + Date.now(),
      success_url: "https://ifmap.ci/test/success.php",
      cancel_url: "https://ifmap.ci/test/cancel.php",
    }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.pay_address && data.pay_amount) {
        // Affichage des informations de paiement
        document.getElementById("payment-info").style.display = "block";
        document.getElementById("amount-to-pay").innerText = data.pay_amount;
        document.getElementById("payment-address").innerText = data.pay_address;
      } else {
        document.getElementById("error-message").innerText =
          data.error || "Erreur inconnue.";
        document.getElementById("error-message").style.display = "block";
        document.getElementById("success-message").style.display = "none";
      }
    })
    .catch((error) => {
      console.error("Erreur:", error);
      document.getElementById("error-message").innerText =
        "Une erreur s'est produite.";
      document.getElementById("error-message").style.display = "block";
    })
    .finally(() => {
      // Réactiver le bouton et enlever l'indicateur de chargement
      btn.disabled = false;
      btn.innerHTML = "Regénérer lien de paiement";
    });
}

function openPopup(mode, amount, depositNumber) {
  const paymentDetails = {
    "Orange Money": {
      icon: "payment_icon/logo_om.png",
      phone: "+225 07 00 00 00",
    },
    "MTN Money": {
      icon: "payment_icon/logo_momo.png",
      phone: "+225 05 00 00 00",
    },
    "Moov Money": {
      icon: "payment_icon/logo_flooz.png",
      phone: "+225 01 00 00 00",
    },
    Wave: {
      icon: "payment_icon/logo_wave.png",
      phone: "+225 08 00 00 00",
    },
  };

  // Vérifie si le mode de paiement existe dans les détails
  if (paymentDetails[mode]) {
    document.getElementById("payment-icon").src =
      paymentDetails[mode].icon ||
      "https://cdn-icons-png.flaticon.com/512/1781/1781106.png";
    document.getElementById("payment-title").textContent = mode;
    document.getElementById("amount").textContent = amount + " FCFA";
    // document.getElementById("deposit-number").textContent = depositNumber;
    document.getElementById("deposit-number").textContent =
      paymentDetails[mode].phone; // Valeur statique de test

    // Affichage du pop-up
    document.getElementById("popup").style.display = "block";
    document.getElementById("overlay").style.display = "block";

    // Log des détails du paiement dans la console
    console.log("Mode de paiement : " + mode);
    console.log("Montant : " + amount + " FCFA");
    console.log("Numéro de dépôt : " + depositNumber);
    console.log("Icône : " + paymentDetails[mode].icon);
    console.log("Numéro téléphone : " + paymentDetails[mode].phone);
  }
}

function closePopup() {
  document.getElementById("popup").style.display = "none";
  document.getElementById("overlay").style.display = "none";
}

function copyDepositNumber() {
  const text = document.getElementById("deposit-number").textContent;
  navigator.clipboard.writeText(text).then(() => {
    alert("Numéro copié : " + text);
  });
}

document.addEventListener("DOMContentLoaded", function () {
  const paymentOptions = document.querySelectorAll(".payment-card input");

  paymentOptions.forEach((option) => {
    option.addEventListener("change", function () {
      if (this.checked) {
        const mode = this.value;
        const amount = 5000; // Exemples de montant
        const depositNumber = "123456789"; // Exemple de numéro de dépôt
        openPopup(mode, amount, depositNumber);
      }
    });
  });

  // Fermer le popup lorsqu'on clique sur l'overlay
  document.getElementById("overlay").addEventListener("click", function () {
    closePopup();
  });
});
