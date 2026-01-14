<?php require_once __DIR__ . '/../partials/head.php'; ?>
<?php require_once __DIR__ . '/../partials/navbar.php'; ?>

<div class="container-fluid px-4">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Editar Usuario</h1>
        <a href="/users" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Volver
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card card-dashboard shadow mb-4">
                <div class="card-header py-3 bg-white border-bottom-0">
                    <h6 class="m-0 font-weight-bold text-primary">Editar Datos: <?= htmlspecialchars($user['name']) ?></h6>
                </div>
                <div class="card-body">
                    <form action="/users/update/<?= $user['id'] ?>" method="POST">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label small text-uppercase fw-bold text-secondary">Nombre</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                                    <input type="text" class="form-control border-start-0 ps-0" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label small text-uppercase fw-bold text-secondary">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                                    <input type="email" class="form-control border-start-0 ps-0" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-light border shadow-sm mb-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-key text-warning me-3 fs-4"></i>
                                <div>
                                    <h6 class="mb-0 fw-bold">Cambiar Contraseña</h6>
                                    <small class="text-muted">Deja este campo vacío si no deseas modificarla.</small>
                                </div>
                            </div>
                            <div class="mt-3">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Nueva contraseña...">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary shadow-sm">
                                <i class="fas fa-sync-alt me-2"></i> Actualizar Usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
             <div class="card card-dashboard shadow mb-4">
                <div class="card-body text-center pt-5 pb-5">
                    <div class="bg-light text-primary rounded-circle d-flex justify-content-center align-items-center mx-auto mb-3 border" style="width: 80px; height: 80px; font-size: 2rem; font-weight: bold;">
                        <?= strtoupper(substr($user['name'], 0, 1)) ?>
                    </div>
                    <h5 class="font-weight-bold"><?= htmlspecialchars($user['name']) ?></h5>
                    <p class="text-muted small">Registrado el <?= date('d/m/Y', strtotime($user['created_at'])) ?></p>
                </div>
            </div>

            <div class="card card-dashboard shadow mb-4 border-left-warning">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-warning"><i class="fas fa-exclamation-triangle me-2"></i>Zona de Peligro</h6>
                </div>
                <div class="card-body">
                    <p class="small text-muted mb-2">Acciones críticas sobre este usuario.</p>
                    <div class="d-grid">
                        <!-- We could implement a real deletion here, but for now just a disabled button as demo or link to delete logic -->
                         <button class="btn btn-outline-danger btn-sm text-start" disabled>
                            <i class="fas fa-ban me-2"></i> Suspender Cuenta
                         </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/scripts.php'; ?>