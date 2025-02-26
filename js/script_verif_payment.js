function verifierTransaction() {
  let hash = $("#hash").val().trim();
  if (hash === "") {
    alert("Veuillez entrer un hash de transaction.");
    return;
  }

  $.ajax({
    url: "../request/verif_payment_request.php",
    type: "POST",
    data: {
      hash: hash,
    },
    success: function (response) {
      $("#resultat").addClass("d-none");
      $("#erreur").addClass("d-none");

      if (response.success) {
        console.log(response);
        $("#status").html(
          '<i class="fas fa-check-circle text-success"></i> Transaction validée'
        );
        $("#montant").text(response.montant_bnb + " BNB");
        $("#montant_usd").text("~ $" + response.montant_usd);
        $("#date_transaction").text(response.date_transaction);
        $("#bscscan_link").attr("href", "https://bscscan.com/tx/" + hash);

        $("#resultat").removeClass("d-none");
        startCountdown();
      } else {
        $("#erreur").text(response.error).removeClass("d-none");
      }
    },
    error: function () {
      $("#erreur")
        .text("Erreur lors de la vérification.")
        .removeClass("d-none");
    },
  });
}

function startCountdown() {
  let seconds = 5;
  $("#countdown").text(seconds);
  let progressBar = new ProgressBar.Circle("#progress-container", {
    strokeWidth: 6,
    easing: "linear",
    duration: 5000,
    color: "#28a745",
    trailColor: "#ddd",
    trailWidth: 6,
    svgStyle: null,
  });
  progressBar.animate(1);

  let interval = setInterval(() => {
    seconds--;
    $("#countdown").text(seconds);
    if (seconds <= 0) {
      clearInterval(interval);
      // Masquer les détails et le compte à rebours
      $("#resultat").addClass("d-none");
      $("#countdown").addClass("d-none");
      // Effectuer la redirection après un petit délai
      setTimeout(() => {
        console.log("Souscription au pack en cours...");

        // Récupérer les informations nécessaires pour la souscription
        let pack_id = 1; // ID du pack auquel l'abonné souhaite souscrire
        let solde = 15;
        let date_souscription = new Date()
          .toISOString()
          .slice(0, 19)
          .replace("T", " "); // Date actuelle
        let date_fin = null;

        // Appel AJAX pour souscrire l'abonné au pack
        $.ajax({
          url: "../request/subscribe_to_pack.php", // Fichier PHP qui gère l'abonnement
          type: "POST",
          data: {
            pack_id: pack_id,
            solde: solde,
            date_souscription: date_souscription,
            date_fin: date_fin,
          },
          success: function (response) {
            console.log("Réponse complète reçue:", response);

            // Vérifiez que response est bien un objet
            if (response && typeof response === "object") {
              console.log("Response.success =", response.success);

              if (response.success === true) {
                console.log("Souscription réussie!");

                setTimeout(() => {
                  console.log("Redirection en cours...");
                  window.location.href = "dashboard.php";
                }, 1000);
              } else {
                console.log(
                  "Échec de l'abonnement: ",
                  response.error || "Erreur inconnue"
                );
              }
            } else {
              console.log("La réponse est mal formée :", response);
            }
          },
          error: function () {
            console.log("Erreur lors de l'appel AJAX.");
          },
        });
      }, 1000);
    }
  }, 1000);
}
