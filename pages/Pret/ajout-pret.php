<?php include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/header.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] .'/exam_s4/includes/topstrip.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] .'/exam_s4/includes/sidebar.php'; ?>

<div class="body-wrapper">
  <header class="app-header">
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
      <ul class="navbar-nav">
        <li class="nav-item d-block d-xl-none">
          <a class="nav-link sidebartoggler" id="headerCollapse" href="javascript:void(0)">
            <i class="ti ti-menu-2"></i>
          </a>
        </li>
      </ul>
    </nav>
  </header>

  <div class="body-wrapper-inner">
    <div class="container-fluid mt-5">
      <h2 class="mb-4">Nouveau Prêt</h2>
      <form id="formPret">
        <div class="mb-3">
          <label for="date_debut" class="form-label">Date de début</label>
          <input type="date" class="form-control" id="date_debut" name="date_debut" required>
        </div>

        <div class="mb-3">
          <label for="montant" class="form-label">Montant</label>
          <input type="number" step="0.01" class="form-control" id="montant" name="montant" required>
        </div>

        <div class="mb-3">
          <label for="banque" class="form-label">Banque</label>
          <select class="form-select" id="banque" name="banque" required>
          </select>
        </div>

        <div class="mb-3">
          <label for="type_pret" class="form-label">Type de prêt</label>
          <select class="form-select" id="type_pret" name="type_pret" required>
          </select>
        </div>

        <div class="mb-3">
          <label for="client" class="form-label">Client</label>
          <select class="form-select" id="client" name="client" required>
          </select>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
      </form>
    </div>
  </div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] .'/exam_s4/includes/footer.php'; ?>

<script>
  const apiBase = "http://localhost/exam_s4/ws";

  const pretForm = document.getElementById("formPret");

  pretForm.addEventListener("submit", function(event) {
    event.preventDefault();

    const date_debut = document.getElementById("date_debut").value.trim();
    const montant = document.getElementById("montant").value.trim();
    const banque = document.getElementById("banque").value.trim();
    const type_pret = document.getElementById("type_pret").value.trim();
    const client = document.getElementById("client").value.trim();

    fetch(`${apiBase}/pret`, {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({
          date_debut,
          montant,
          banque,
          type_pret,
          client
        })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert("Prêt enregistré avec succès !");
          window.location.href = "liste-pret.php";
        } else {
          alert("Erreur: " + (data.message || "Échec de l'enregistrement"));
        }
      })
      .catch(error => {
        console.error("Erreur lors de la requête :", error);
        alert("Une erreur réseau est survenue");
      });
  });

  function chargerOptions(endpoint, selectId) {
    fetch(`${apiBase}${endpoint}`)
      .then(response => response.json())
      .then(data => {
        const select = document.getElementById(selectId);
        const options = data.data || data;

        options.forEach(option => {
          const opt = document.createElement("option");
          opt.value = option.id;
          opt.textContent = option.nom || `${option.prenom || ''} ${option.nom || ''}`.trim();
          select.appendChild(opt);
        });
      })
      .catch(error => console.error("Erreur de chargement :", error));
  }

  document.addEventListener("DOMContentLoaded", function() {
    chargerOptions("/banques", "banque");
    chargerOptions("/types_pret", "type_pret");
    chargerOptions("/clients", "client");
  });
</script>