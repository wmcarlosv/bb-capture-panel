<?php require_once __DIR__ . '/../partials/head.php'; ?>
<?php require_once __DIR__ . '/../partials/navbar.php'; ?>

<div class="container-fluid px-4">
    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Cartera de Clientes</h1>
        <button class="d-none d-sm-inline-block btn btn-sm btn-info shadow-sm" onclick="Swal.fire('Info', 'La gestión de clientes se realiza vía API.', 'info')">
            <i class="fas fa-terminal fa-sm text-white-50 me-1"></i> API
        </button>
    </div>

    <div class="row">
        <!-- Main Table Column -->
        <div class="col-lg-9">
            <div class="card card-dashboard shadow mb-4 border-left-success">
                <div class="card-header py-3 bg-white border-bottom-0">
                    <h6 class="m-0 font-weight-bold text-success">Listado de Clientes</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle datatable" width="100%" cellspacing="0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>DNI</th>
                                    <th>Email</th>
                                    <th>Teléfono</th>
                                    <th>Registro</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($customers as $c): ?>
                                <tr>
                                    <td><span class="text-muted small">#<?= $c['id'] ?></span></td>
                                    <td class="fw-bold text-dark"><?= htmlspecialchars($c['dni']) ?></td>
                                    <td><?= htmlspecialchars($c['email']) ?></td>
                                    <td>
                                        <?php if(!empty($c['phone'])): ?>
                                            <i class="fas fa-phone-alt text-muted small me-1"></i> <?= htmlspecialchars($c['phone']) ?>
                                        <?php else: ?>
                                            <span class="text-muted small">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><small class="text-muted"><?= date('d/m/Y', strtotime($c['created_at'])) ?></small></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Tips Column -->
        <div class="col-lg-3">
            <div class="card card-dashboard shadow mb-4 border-left-warning">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning"><i class="fas fa-network-wired me-2"></i>API Endpoint</h6>
                </div>
                <div class="card-body">
                    <p class="small text-muted mb-3">
                        Los clientes se gestionan externamente.
                    </p>
                    <div class="p-2 bg-light rounded mb-3 small border font-monospace text-break">
                        POST /api/customers
                    </div>
                    <ul class="small text-muted ps-3 mb-0">
                        <li class="mb-2">Usa formato JSON.</li>
                        <li class="mb-2">Campos req: dni, email, password.</li>
                        <li>Consulta la documentación para más detalles.</li>
                    </ul>
                </div>
            </div>
            
            <div class="card card-dashboard shadow mb-4 bg-dark text-white">
                <div class="card-body text-center">
                    <i class="fas fa-database fa-3x mb-3 text-white-50"></i>
                    <h6 class="font-weight-bold">Datos Sincronizados</h6>
                    <p class="small text-white-50 mb-0">Esta vista es de solo lectura.</p>
                </div>
            </div>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/../partials/scripts.php'; ?>
