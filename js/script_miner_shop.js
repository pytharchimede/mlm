document.addEventListener("DOMContentLoaded", function () {
  fetch("../api/api_get_pack.php")
    .then((response) => response.json())
    .then((data) => {
      const packs = data.map((pack) => ({
        id: pack.id,
        name: pack.name,
        price: pack.price,
        rating: pack.rating,
      }));

      console.log("Packs formatés :", packs);

      // Sélectionner le conteneur HTML
      const container = document.getElementById("packs-container");

      // Injecter les packs dans la page avec un bouton payer
      container.innerHTML = packs
        .map(
          (pack) => `
          <div class="pack bg-gray-800 p-6 rounded-lg shadow-lg text-center" data-pack="${
            pack.name
          }">
              <h3 class="text-xl font-bold">${pack.name}</h3>
              <p class="text-gray-400">${pack.price} FCFA</p>
              <p class="text-yellow-400">${"⭐".repeat(pack.rating)}</p>
              <button class="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                  onclick='payer(${pack.id}, ${pack.price}, "${
            pack.name
          }")'>Payer</button>
          </div>
      `
        )
        .join("");
    })
    .catch((error) =>
      console.error("Erreur lors de la récupération des packs :", error)
    );
});
function payer(id, amount, packName) {
  // Masquer tous les packs
  document.querySelectorAll(".pack").forEach((pack) => {
    pack.style.display = "none";
  });

  // Afficher uniquement le pack sélectionné
  const selectedPack = document.querySelector(`.pack[data-pack="${packName}"]`);
  if (selectedPack) {
    selectedPack.style.display = "block";
  }

  // Récupérer le bouton dans le pack sélectionné
  const btn = selectedPack ? selectedPack.querySelector("button") : null;
  if (btn) {
    btn.disabled = true; // Désactiver le bouton
    btn.innerHTML = `<i class="fa fa-spinner fa-spin"></i> Chargement..`;
  }

  // Envoi de la requête de paiement
  fetch("../request/create_paiement.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      pack_id: id,
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
        const paymentInfo = document.getElementById("payment-info");
        if (paymentInfo) {
          paymentInfo.style.display = "block";
        }
        document.getElementById("amount-to-pay").innerText = data.pay_amount;
        document.getElementById("payment-address").innerText = data.pay_address;
      } else {
        document.getElementById("error-message").innerText =
          data.error || "Erreur inconnue.";
        document.getElementById("error-message").style.display = "block";
      }
    })
    .catch((error) => {
      console.error("Erreur:", error);
      document.getElementById("error-message").innerText =
        "Une erreur s'est produite.";
      document.getElementById("error-message").style.display = "block";
    })
    .finally(() => {
      // Réactiver le bouton après le chargement
      if (btn) {
        btn.disabled = false; // Réactiver le bouton
        btn.innerHTML = "Regénérer lien de paiement";
      }
    });
}

function openPopup(mode, amount, depositNumber) {
  const paymentDetails = {
    "Orange Money": {
      icon: "../payment_icon/logo_om.png",
      phone: "+225 07 00 00 00",
    },
    "MTN Money": {
      icon: "../payment_icon/logo_momo.png",
      phone: "+225 05 00 00 00",
    },
    "Moov Money": {
      icon: "../payment_icon/logo_flooz.png",
      phone: "+225 01 00 00 00",
    },
    Wave: {
      icon: "../payment_icon/logo_wave.png",
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
