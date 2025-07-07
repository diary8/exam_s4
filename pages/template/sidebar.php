<div class="sidebar bg-dark text-white">
    <div class="sidebar-header p-3">
        <h3 class="brand m-0">
            <span class="logo me-2">
                <i class="fas fa-university"></i>
            </span>
            <span>Banque XYZ</span>
        </h3>
    </div>
    
    <div class="sidebar-menu">
        <ul class="list-unstyled">
            <li class="sidebar-item <?php echo $active_page == 'dashboard' ? 'active' : ''; ?>">
                <a href="/banque/dashboard" class="text-white text-decoration-none d-block p-3">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    <span>Tableau de bord</span>
                </a>
            </li>
            <li class="sidebar-item <?php echo $active_page == 'clients' ? 'active' : ''; ?>">
                <a href="/banque/clients" class="text-white text-decoration-none d-block p-3">
                    <i class="fas fa-users me-2"></i>
                    <span>Clients</span>
                </a>
            </li>
            <li class="sidebar-item <?php echo $active_page == 'demandes' ? 'active' : ''; ?>">
                <a href="/banque/demandes-pret" class="text-white text-decoration-none d-block p-3">
                    <i class="fas fa-file-alt me-2"></i>
                    <span>Demandes de prêt</span>
                    <span class="badge bg-danger float-end"><?php echo $pending_loans_count; ?></span>
                </a>
            </li>
            <li class="sidebar-item <?php echo $active_page == 'prets' ? 'active' : ''; ?>">
                <a href="/banque/gestion-prets" class="text-white text-decoration-none d-block p-3">
                    <i class="fas fa-hand-holding-usd me-2"></i>
                    <span>Gestion des prêts</span>
                </a>
            </li>
            <li class="sidebar-item <?php echo $active_page == 'parametres' ? 'active' : ''; ?>">
                <a href="/banque/parametres" class="text-white text-decoration-none d-block p-3">
                    <i class="fas fa-cog me-2"></i>
                    <span>Paramètres</span>
                </a>
            </li>
        </ul>
    </div>
</div>