<!-- Sidebar Backdrop for Mobile -->
<div class="sidebar-backdrop" id="sidebarBackdrop" onclick="toggleSidebar()"></div>

<!-- Sidebar -->
<nav class="sidebar d-flex flex-column" id="sidebar">
    <a href="/dashboard" class="sidebar-brand">
        <i class="fas fa-layer-group me-2"></i> BB PANEL
    </a>
    
    <ul class="nav flex-column flex-grow-1">
        <li class="nav-item">
            <a href="/dashboard" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/dashboard') !== false ? 'active' : '' ?>">
                <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
            </a>
        </li>
        
        <div class="sidebar-heading text-white-50 px-3 mt-3 mb-1 text-uppercase small" style="font-size: 0.7rem;">Gestión</div>
        
        <li class="nav-item">
            <a href="/users" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/users') !== false ? 'active' : '' ?>">
                <i class="fas fa-users"></i> <span>Usuarios</span>
            </a>
        </li>
        <!-- Placeholder for Customers if needed later -->
        <li class="nav-item">
            <a href="/customers" class="nav-link <?= strpos($_SERVER['REQUEST_URI'], '/customers') !== false ? 'active' : '' ?>">
                <i class="fas fa-user-tag"></i> <span>Clientes</span>
            </a>
        </li>
    </ul>

    <div class="p-3 border-top border-secondary">
        <a href="/logout" class="nav-link text-danger bg-white bg-opacity-10 justify-content-center">
            <i class="fas fa-sign-out-alt"></i> <span>Cerrar Sesión</span>
        </a>
    </div>
</nav>

<!-- Main Content Wrapper Starts Here -->
<div class="main-content">
    
    <!-- Topbar -->
    <nav class="topbar mb-4">
        <button class="btn btn-link d-md-none rounded-circle mr-3" onclick="toggleSidebar()">
            <i class="fa fa-bars text-secondary"></i>
        </button>

        <!-- Topbar Search (Optional visual) -->
        <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
                <input type="text" class="form-control border-0 bg-light small" placeholder="Buscar..." aria-label="Search" style="border-radius: 20px;">
            </div>
        </form>

        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto">
            <div class="topbar-divider d-none d-sm-block"></div>
            
            <!-- User Info -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle user-profile" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small text-dark fw-bold"><?= $_SESSION['user_name'] ?? 'Usuario' ?></span>
                    <div class="user-avatar shadow-sm">
                        <?= strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)) ?>
                    </div>
                </a>
                <!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-end shadow animated--grow-in" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="/profile">
                        <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                        Perfil
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="/logout">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Salir
                    </a>
                </div>
            </li>
        </ul>
    </nav>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('show');
        document.getElementById('sidebarBackdrop').classList.toggle('show');
    }
</script>