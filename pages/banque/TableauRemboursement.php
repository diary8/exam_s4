<?php include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/header.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/topstrip.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/sidebar.php'; ?>

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

  <div class="container-fluid mt-5">
    <div class="card shadow-sm border-0">
      <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0">📋 Table de remboursement du client <span id="client-span"></span> </h5>
        <button type="button" onclick="exportTableauEnPDF()" >exporter PDF</button>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table id="pret-table" class="table table-striped table-bordered align-middle">
            <thead class="table-light">
              <tr>
                <th>Mois</th>
                <th>Date prévue</th>
                <th>Montant</th>
                <th>satuts</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form id="paymentForm" class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="confirmationModalLabel">Confirmation du paiement</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="paymentDate" class="form-label">Date de paiement</label>
          <input type="date" class="form-control" id="paymentDate" name="paymentDate" required>
        </div>
        <input type="hidden" id="pretIdInput" name="pretId">
        <input type="hidden" id="moisInput" name="mois">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="submit" class="btn btn-success">Confirmer le paiement</button>
      </div>
    </form>
  </div>
</div>

<?php include include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/footer.php'; ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
<script src="http://localhost/exam_s4/assets/js/ajaxFunc.js"></script>
<script>
  const pret_table_body = document.querySelector("#pret-table tbody");
  const params = new URLSearchParams(window.location.search);
  const idPret = params.get("idPret");
  const clientSpan = document.getElementById("client-span");

  ajax("GET", "/pret_client/" + idPret, null, function(data) {
    console.log(data);
    clientSpan.innerText = data.pret.nom + "/" + data.pret.email;
  });

  ajax("GET", "/banque/tableau_remboursement?idPret=" + idPret, null, function(data) {
    console.log(data.echeance);
    pret_table_body.innerHTML = ""; // Clear previous rows

    Object.entries(data.echeance).forEach(([mois, element]) => {
      const tableRow = document.createElement("tr");

      tableRow.innerHTML = `
      <td>${mois}</td>
      <td>${element.date}</td>
      <td>${element.montant.toFixed(2)} Ar</td>
      <td>${element.statut}</td>
      <td>
      <button class="btn btn-sm btn-success pay-btn" data-pret-id="${idPret}"
      data-mois="${mois}">
        Payer
      </button>
      </td>
    `;

      pret_table_body.appendChild(tableRow);
    });
  });
  document.addEventListener("DOMContentLoaded", function() {
    const paymentForm = document.getElementById("paymentForm");
    const pretIdInput = document.getElementById("pretIdInput");
    const moisInput = document.getElementById("moisInput");
    const paymentDateInput = document.getElementById("paymentDate");

    document.addEventListener("click", function(e) {
      if (e.target.classList.contains("pay-btn")) {
        const pretId = e.target.dataset.pretId;
        const mois = e.target.dataset.mois;

        pretIdInput.value = pretId;
        moisInput.value = mois;


        const modal = new bootstrap.Modal(document.getElementById("confirmationModal"));
        modal.show();
      }
    });

    paymentForm.addEventListener("submit", function(e) {
      e.preventDefault();

      const [anneeAPaye, moisAPaye] = moisInput.value.split("-");
      console.log(moisInput.value);
      console.log("---------------------------------------------------------------");

      const formData = {
        pretId: pretIdInput.value,
        mois: parseInt(moisAPaye),
        annee: parseInt(anneeAPaye),
        date: paymentDateInput.value
      };

      console.log(formData);

      console.log(anneeAPaye);
      console.log(paymentDateInput.value);
      console.log("Paiement envoyé :", formData);

      ajax("POST", "/banque/rembourser", formData, function(response) {
        // alert("Paiement enregistré !");
        console.log(response);
        location.reload();
      });

      const modalInstance = bootstrap.Modal.getInstance(document.getElementById("confirmationModal"));
      modalInstance.hide();
    });
  });

  function exportTableauEnPDF() {
    const {
      jsPDF
    } = window.jspdf;
    const doc = new jsPDF();

    // Titre
    doc.setFontSize(16);
    doc.text("Tableau de Remboursement", 14, 20);

    const headers = [
      ["Mois", "Date", "Montant", "Statut"]
    ];
    const rows = [];

    document.querySelectorAll("#pret_table_body tr").forEach(tr => {
      const cells = tr.querySelectorAll("td");
      const rowData = [
        cells[0].textContent,
        cells[1].textContent,
        cells[2].textContent,
        cells[3].textContent,
      ];
      rows.push(rowData);
    });

    doc.autoTable({
      head: headers,
      body: rows,
      startY: 30,
      styles: {
        fontSize: 10
      }
    });

    doc.save("tableau_remboursement.pdf");
  }
</script>