<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tableau de bord</title>
    <link rel="shortcut icon" type="image/png" href="../images/logos/favicon.png" />
    <link rel="stylesheet" href="../assets/css/styles.min.css" />
    <style>
        .sidebar-nav ul li a.active {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 3px solid #fff;
        }
        .app-topstrip {
            background-color: #1a237e !important;
        }
        .sidebar-item .sidebar-link {
            transition: all 0.3s ease;
        }
        .sidebar-item .sidebar-link:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }
        .navbar-nav .dropdown-menu {
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <!-- Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">

        <!-- App Topstrip -->
        <div class="app-topstrip bg-primary py-3 px-3 w-100 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-4">
                <a href="#">
                    <img src="../images/logos/logo-sm.png" alt="Logo Bibliothèque" width="40" height="45" style="max-width: 100%; height: auto;" />
                </a>
                <h3 class="text-white mb-0 fs-5 d-none d-md-block">Prêt bancaire</h3>
            </div>

            <div class="d-flex align-items-center gap-3">
                <div class="text-white">
                    <span class="d-none d-md-inline">Bienvenue, </span>
                    <strong><!-- Nom utilisateur ici --></strong>
                </div>
                <a class="btn btn-outline-light btn-sm d-flex align-items-center gap-1" href="#/user/logout">
                    <i class="ti ti-logout fs-4"></i>
                    <span class="d-none d-md-inline">Déconnexion</span>
                </a>
            </div>
        </div>

        <!-- Sidebar Start -->

        <!-- Sidebar End -->

        <!-- Main wrapper -->
        <div class="body-wrapper">
            <!-- Header Start -->
            <header class="app-header">
                <nav class="navbar navbar-expand-lg navbar-light bg-white">
                    <ul class="navbar-nav">
                        <li class="nav-item d-block d-xl-none">
                            <a class="nav-link sidebartoggler" id="headerCollapse" href="javascript:void(0)">
                                <i class="ti ti-menu-2"></i>
                            </a>
                        </li>
                    </ul>

                    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                        <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                            <li class="nav-item dropdown">
                                <a class="nav-link pe-0" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="d-flex align-items-center">
                                        <div class="me-2">
                                            <img src="../images/profile/user-1.jpg" alt="Profil" width="35" height="35" class="rounded-circle" />
                                        </div>
                                        <div class="d-none d-md-block">
                                            <p class="mb-0 fs-3 fw-semibold"><!-- Nom utilisateur ici --></p>
                                            <small class="text-muted">Adhérent</small>
                                        </div>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                                    <div class="message-body">
                                        <a href="#" class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-user fs-6"></i>
                                            <p class="mb-0 fs-3">Mon profil</p>
                                        </a>
                                        <a href="#" class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-book fs-6"></i>
                                            <p class="mb-0 fs-3">Mes emprunts</p>
                                        </a>
                                        <a href="#" class="d-flex align-items-center gap-2 dropdown-item">
                                            <i class="ti ti-list-check fs-6"></i>
                                            <p class="mb-0 fs-3">Mes réservations</p>
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a href="#" class="btn btn-outline-primary mx-3 mt-2 d-block">
                                            <i class="ti ti-logout me-2"></i>Déconnexion
                                        </a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>

            <div class="body-wrapper-inner">
                <div class="container-fluid">
                    <%-- Inclusion dynamique JSP --%>
                    <jsp:include page="${page}.jsp" />
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sidebarmenu.js"></script>
    <script src="../assets/js/app.min.js"></script>
    <script src="../assets/libs/apexcharts/dist/apexcharts.min.js"></script>
    <script src="../assets/libs/simplebar/dist/simplebar.js"></script>

</body>
</html>
