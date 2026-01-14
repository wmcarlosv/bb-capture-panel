<?php require_once __DIR__ . '/../partials/head.php'; ?>
<?php require_once __DIR__ . '/../partials/navbar.php'; ?>

<div class="container-fluid px-4">
    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Gestión de Usuarios</h1>
        <a href="/users/create" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50 me-1"></i> Nuevo Usuario
        </a>
    </div>

    <div class="row">
        <!-- Main Table Column -->
        <div class="col-lg-9">
            <div class="card card-dashboard shadow mb-4">
                <div class="card-header py-3 bg-white border-bottom-0 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Listado de Usuarios</h6>
                    <!-- Mobile Button -->
                    <a href="/users/create" class="d-sm-none btn btn-sm btn-primary shadow-sm">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle datatable" id="usersTable" width="100%" cellspacing="0">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 5%;">ID</th>
                                    <th>Usuario</th>
                                    <th>Email</th>
                                    <th>Fecha Registro</th>
                                    <th class="text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $u): ?>
                                <tr>
                                    <td><span class="text-muted small">#<?= $u['id'] ?></span></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-light text-primary rounded-circle d-flex justify-content-center align-items-center me-2 border" style="width: 35px; height: 35px; font-weight: bold;">
                                                <?= strtoupper(substr($u['name'], 0, 1)) ?>
                                            </div>
                                            <div>
                                                <span class="fw-bold text-dark"><?= htmlspecialchars($u['name']) ?></span>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="text-muted"><?= htmlspecialchars($u['email']) ?></span></td>
                                    <td><small class="text-muted"><i class="far fa-clock me-1"></i> <?= date('d M, Y', strtotime($u['created_at'])) ?></small></td>
                                    <td class="text-end">
                                        <div class="btn-group" role="group">
                                            <a href="/users/edit/<?= $u['id'] ?>" class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip" title="Editar">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <?php if ($u['id'] != $_SESSION['user_id']): ?>
                                            <button class="btn btn-sm btn-outline-danger btn-delete" data-id="<?= $u['id'] ?>" data-bs-toggle="tooltip" title="Eliminar">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
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
            <div class="card card-dashboard shadow mb-4 border-left-info">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info"><i class="fas fa-info-circle me-2"></i>Tips de Gestión</h6>
                </div>
                <div class="card-body">
                    <p class="small text-muted mb-3">
                        Administra los accesos a tu plataforma de manera segura.
                    </p>
                    <ul class="small text-muted ps-3 mb-0">
                        <li class="mb-2">Verifica los correos antes de crear usuarios.</li>
                        <li class="mb-2">Elimina cuentas inactivas regularmente.</li>
                        <li>Los administradores tienen acceso total al sistema.</li>
                    </ul>
                </div>
            </div>
            
            <div class="card card-dashboard shadow mb-4 bg-primary text-white">
                <div class="card-body text-center">
                    <i class="fas fa-users-cog fa-3x mb-3 text-white-50"></i>
                    <h6 class="font-weight-bold">¿Necesitas ayuda?</h6>
                    <p class="small text-white-50 mb-0">Contacta al soporte técnico si tienes problemas con los permisos.</p>
                </div>
            </div>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/../partials/scripts.php'; ?>
<script>
    $(document).ready(function() {
        // Initialize Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl)
        })

        $('.btn-delete').click(function() {
            var id = $(this).data('id');
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74a3b',
                cancelButtonColor: '#858796',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post('/users/delete/' + id, function(res) {
                        if (res.success) {
                            Swal.fire(
                                '¡Eliminado!',
                                'El usuario ha sido eliminado.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error',
                                res.message || 'Hubo un problema.',
                                'error'
                            );
                        }
                    }, 'json');
                }
            })
        });
    });
</script>