<?php require_once __DIR__ . '/../partials/head.php'; ?>

<!-- Includes Sidebar and Topbar -->
<?php require_once __DIR__ . '/../partials/navbar.php'; ?>

    <!-- Begin Page Content -->
    <div class="container-fluid px-4">
        
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Mi Perfil</h1>
        </div>

        <div class="row">
            <!-- Left Column: Profile Card -->
            <div class="col-xl-4 col-lg-5">
                <div class="card card-dashboard shadow mb-4">
                    <div class="card-body text-center profile-card pt-5 pb-5">
                        <div class="mb-3">
                            <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center mx-auto shadow" style="width: 100px; height: 100px; font-size: 2.5rem; font-weight: bold;">
                                <?= strtoupper(substr($user['name'], 0, 1)) ?>
                            </div>
                        </div>
                        <h4 class="font-weight-bold text-dark mb-1"><?= htmlspecialchars($user['name']) ?></h4>
                        <p class="text-muted mb-4"><?= htmlspecialchars($user['email']) ?></p>
                        
                        <div class="d-grid gap-2 col-8 mx-auto">
                            <button class="btn btn-outline-primary btn-sm" type="button" disabled>
                                <i class="fas fa-shield-alt me-1"></i> Administrador
                            </button>
                        </div>
                    </div>
                    <div class="card-footer bg-light text-center small text-muted">
                        Miembro desde: <?= date('d M, Y', strtotime($user['created_at'])) ?>
                    </div>
                </div>

                <!-- Tips Card -->
                <div class="card card-dashboard shadow mb-4 border-left-info">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-info"><i class="fas fa-lightbulb me-2"></i>Tips de Seguridad</h6>
                    </div>
                    <div class="card-body">
                        <ul class="small text-muted ps-3 mb-0">
                            <li class="mb-2">Usa una contraseña de al menos 8 caracteres.</li>
                            <li class="mb-2">Incluye números y símbolos para mayor seguridad.</li>
                            <li class="mb-2">No compartas tus credenciales con nadie.</li>
                            <li>Cambia tu clave periódicamente.</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Right Column: Edit Form -->
            <div class="col-xl-8 col-lg-7">
                <div class="card card-dashboard shadow mb-4">
                    <div class="card-header py-3 bg-white border-bottom-0">
                        <h6 class="m-0 font-weight-bold text-primary">Editar Información</h6>
                    </div>
                    <div class="card-body">
                        <form action="/profile" method="POST">
                            
                            <h6 class="heading-small text-muted mb-4">Información de Usuario</h6>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label small text-uppercase fw-bold text-secondary">Nombre Completo</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                                        <input type="text" class="form-control border-start-0 ps-0" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label small text-uppercase fw-bold text-secondary">Correo Electrónico</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                                        <input type="email" class="form-control border-start-0 ps-0" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <h6 class="heading-small text-muted mb-4">Seguridad</h6>

                            <div class="alert alert-light border border-light shadow-sm mb-4" role="alert">
                                <i class="fas fa-info-circle text-primary me-2"></i> 
                                <span class="small">Deja el campo de contraseña <strong>en blanco</strong> si no deseas cambiarla.</span>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="password" class="form-label small text-uppercase fw-bold text-secondary">Nueva Contraseña</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                                        <input type="password" class="form-control border-start-0 ps-0" id="password" name="password" placeholder="********">
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end mt-4">
                                <button type="reset" class="btn btn-light me-2">Cancelar</button>
                                <button type="submit" class="btn btn-primary shadow-sm">
                                    <i class="fas fa-save me-2"></i> Guardar Cambios
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- End Page Content -->

</div> <!-- End Main Content Wrapper -->

<?php require_once __DIR__ . '/../partials/scripts.php'; ?>