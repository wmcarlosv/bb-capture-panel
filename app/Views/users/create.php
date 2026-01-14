<?php require_once __DIR__ . '/../partials/head.php'; ?>
<?php require_once __DIR__ . '/../partials/navbar.php'; ?>

<div class="container-fluid px-4">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Crear Usuario</h1>
        <a href="/users" class="btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left me-1"></i> Volver
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card card-dashboard shadow mb-4">
                <div class="card-header py-3 bg-white border-bottom-0">
                    <h6 class="m-0 font-weight-bold text-primary">Formulario de Registro</h6>
                </div>
                <div class="card-body">
                    <form action="/users/store" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label small text-uppercase fw-bold text-secondary">Nombre</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-user text-muted"></i></span>
                                    <input type="text" class="form-control border-start-0 ps-0" id="name" name="name" required placeholder="Ej: Juan Perez">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label small text-uppercase fw-bold text-secondary">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="fas fa-envelope text-muted"></i></span>
                                    <input type="email" class="form-control border-start-0 ps-0" id="email" name="email" required placeholder="juan@ejemplo.com">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label small text-uppercase fw-bold text-secondary">Contraseña Inicial</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-lock text-muted"></i></span>
                                <input type="password" class="form-control border-start-0 ps-0" id="password" name="password" required>
                            </div>
                            <div class="form-text small"><i class="fas fa-info-circle me-1"></i> Se recomienda usar al menos 8 caracteres.</div>
                        </div>

                        <!-- Demo Select2 -->
                        <div class="mb-4">
                            <label for="roles" class="form-label small text-uppercase fw-bold text-secondary">Asignar Roles</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="fas fa-user-tag text-muted"></i></span>
                                <select class="form-select select2 border-start-0" id="roles" name="roles[]" multiple style="width: 100%;">
                                    <option value="admin" selected>Admin</option>
                                    <option value="editor">Editor</option>
                                    <option value="viewer">Viewer</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary shadow-sm">
                                <i class="fas fa-save me-2"></i> Crear Usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card card-dashboard shadow mb-4 border-left-success">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success"><i class="fas fa-lightbulb me-2"></i>Buenas Prácticas</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted small">Al crear un nuevo usuario:</p>
                    <ul class="small text-muted ps-3">
                        <li class="mb-2">Asegúrate de que el email sea corporativo si aplica.</li>
                        <li class="mb-2">Asigna solo los roles necesarios (Principio de menor privilegio).</li>
                        <li>Comparte la contraseña inicial por un canal seguro.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/scripts.php'; ?>