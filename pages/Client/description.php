<?php 
include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/header.php';
include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/topstrip.php'; 
include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/sidebar.php'; 

$clientId = isset($_GET['id']) ? intval($_GET['id']) : 0;
?>

<div class="body-wrapper">
  <div class="content-wrapper container-fluid">
    
    <!-- Section Solde et Info Client -->
    <div class="row mb-4">
      <!-- Carte Solde -->
      <div class="col-md-4">
        <div class="card shadow border-left-primary">
          <div class="card-body">
            <h5 class="card-title">Solde du Compte</h5>
            <div class="d-flex align-items-center">
              <div class="h2 mb-0 font-weight-bold text-gray-800" id="client-solde">Chargement...</div>
            </div>
            <div class="mt-3">
              <button class="btn btn-sm btn-primary mr-2" id="refresh-solde">
                <i class="fas fa-sync-alt"></i> Actualiser
              </button>
              <button class="btn btn-sm btn-success" id="nouvelle-operation">
                <i class="fas fa-plus"></i> Nouvelle opération
              </button>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Carte Info Client -->
      <div class="col-md-8">
        <div class="card shadow">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Informations Client</h6>
          </div>
          <div class="card-body" id="client-info">
            <div class="text-center py-4">
              <div class="spinner-border text-primary" role="status">
                <span class="sr-only"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Section Prêts -->
    <div class="card shadow mb-4">
      <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Prêts en cours</h6>
        <button class="btn btn-sm btn-success" id="nouveau-pret">
          <i class="fas fa-plus"></i> Nouveau prêt
        </button>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-bordered" id="prets-table">
            <thead>
              <tr>
                <th>N° Prêt</th>
                <th>Montant</th>
                <th>Taux</th>
                <th>Durée</th>
                <th>Date Début</th>
                <th>Échéance</th>
                <th>Statut</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody id="prets-list">
              <tr>
                <td colspan="8" class="text-center">Chargement des prêts...</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    
  </div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/exam_s4/includes/footer.php'; ?>

<script src="http://localhost/exam_s4/assets/js/ajaxFunc.js"></script>
<script>
// Configuration de base
const clientId = <?php echo $clientId; ?>;

// Chargement initial
document.addEventListener('DOMContentLoaded', function() {
  if (clientId > 0) {
    loadClientData();
    loadPrets();
  } else {
    showError("ID client invalide");
  }
  
  // Écouteurs d'événements
  document.getElementById('refresh-solde').addEventListener('click', loadClientData);
  document.getElementById('nouvelle-operation').addEventListener('click', () => {
    window.location.href = `nouvelle_operation.php?client_id=${clientId}`;
  });
  document.getElementById('nouveau-pret').addEventListener('click', () => {
    window.location.href = `nouveau_pret.php?client_id=${clientId}`;
  });
});

// Chargement des données client (incluant le solde)
function loadClientData() {
  ajax("GET", `/clients/${clientId}`, null, 
    function(response) {
      if (response.success && response.data) {
        const client = response.data;
        
        // Afficher le solde
        const solde = parseFloat(client.montant || 0);
        const soldeElement = document.getElementById('client-solde');
        soldeElement.textContent = `${solde.toFixed(2)} €`;
        soldeElement.className = `h2 mb-0 font-weight-bold ${
          solde >= 0 ? 'text-success' : 'text-danger'
        }`;
        
        // Afficher les infos client
        document.getElementById('client-info').innerHTML = `
          <div class="row">
            <div class="col-md-6">
              <p><strong>Nom complet:</strong> ${client.nom}</p>
              <p><strong>Email:</strong> ${client.email}</p>
              <p><strong>Téléphone:</strong> ${client.telephone}</p>
            </div>
            <div class="col-md-6">
              <p><strong>Adresse:</strong> ${client.adresse}</p>
              <p><strong>Date de naissance:</strong> ${formatDate(client.date_de_naissance)}</p>
              <p><strong>N° Client:</strong> ${clientId}</p>
              <p><strong>N° Compte:</strong> ${client.compte_client_id}</p>
            </div>
          </div>
          <div class="mt-3">
            <a href="modifier_client.php?id=${clientId}" class="btn btn-sm btn-warning mr-2">
              <i class="fas fa-edit"></i> Modifier
            </a>
            <button class="btn btn-sm btn-danger" id="archiver-client">
              <i class="fas fa-archive"></i> Archiver
            </button>
          </div>
        `;
      } else {
        throw new Error(response.message || "Données client non disponibles");
      }
    },
    handleError
  );
}

// Chargement des prêts (inchangé)
function loadPrets() {
  ajax("GET", `/prets/client/${clientId}`, null,
    function(response) {
      const tbody = document.getElementById('prets-list');
      
      if (response.success && Array.isArray(response.data)) {
        if (response.data.length === 0) {
          tbody.innerHTML = `
            <tr>
              <td colspan="8" class="text-center">Aucun prêt en cours</td>
            </tr>
          `;
          return;
        }
        
        tbody.innerHTML = response.data.map(pret => `
          <tr>
            <td>${pret.id}</td>
            <td>${pret.montant.toFixed(2)} €</td>
            <td>${pret.taux}%</td>
            <td>${pret.duree} mois</td>
            <td>${formatDate(pret.date_debut)}</td>
            <td>${formatDate(pret.date_echeance)}</td>
            <td>
              <span class="badge ${pret.statut === 'actif' ? 'badge-success' : 'badge-warning'}">
                ${pret.statut}
              </span>
            </td>
            <td>
              <a href="details_pret.php?id=${pret.id}&client=${clientId}" class="btn btn-sm btn-info mr-1">
                <i class="fas fa-eye"></i>
              </a>
              <button class="btn btn-sm btn-primary" onclick="rembourserPret(${pret.id})">
                <i class="fas fa-euro-sign"></i>
              </button>
            </td>
          </tr>
        `).join('');
      } else {
        throw new Error(response.message || "Format de réponse inattendu");
      }
    },
    handleError
  );
}

// Fonctions utilitaires (inchangées)
function formatDate(dateString) {
  if (!dateString) return 'N/A';
  const date = new Date(dateString);
  return isNaN(date.getTime()) ? 'N/A' : date.toLocaleDateString();
}

function handleError(error) {
  console.error("Erreur:", error);
  showError(error.message || "Erreur de connexion au serveur");
}

function showError(message) {
  const alertDiv = document.createElement('div');
  alertDiv.className = 'alert alert-danger alert-dismissible fade show';
  alertDiv.innerHTML = `
    ${message}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  `;
  
  const contentWrapper = document.querySelector('.content-wrapper');
  if (contentWrapper.firstChild) {
    contentWrapper.insertBefore(alertDiv, contentWrapper.firstChild);
  } else {
    contentWrapper.appendChild(alertDiv);
  }
  
  setTimeout(() => {
    alertDiv.classList.remove('show');
    setTimeout(() => alertDiv.remove(), 150);
  }, 5000);
}

// Gestion des prêts (inchangée)
window.rembourserPret = function(pretId) {
  if (confirm("Voulez-vous vraiment effectuer un remboursement pour ce prêt ?")) {
    ajax("POST", `/prets/${pretId}/rembourser`, null,
      function(response) {
        if (response.success) {
          showError("Remboursement effectué avec succès");
          loadPrets();
          loadClientData(); // Recharge aussi le solde
        } else {
          throw new Error(response.message || "Erreur lors du remboursement");
        }
      },
      handleError
    );
  }
};
</script>