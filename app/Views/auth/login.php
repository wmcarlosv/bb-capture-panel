<?php require_once __DIR__ . '/../partials/head.php'; ?>

<body class="auth-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card card-auth">
                    <div class="card-header">
                        <div class="auth-icon">
                            <i class="fas fa-cube"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-0">Bienvenido</h4>
                        <p class="text-muted small">Ingresa a tu cuenta para continuar</p>
                    </div>
                    <div class="card-body p-4">
                        <form action="/login" method="POST">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" name="email" placeholder="nombre@ejemplo.com" required>
                                <label for="email"><i class="fas fa-envelope me-2 text-muted"></i>Email</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                                <label for="password"><i class="fas fa-lock me-2 text-muted"></i>Contraseña</label>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember">
                                    <label class="form-check-label small text-muted" for="remember">Recuérdame</label>
                                </div>
                                <a href="/forgot-password" class="small text-decoration-none">¿Olvidaste tu clave?</a>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary shadow-sm">
                                    INGRESAR <i class="fas fa-sign-in-alt ms-2"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-3 text-white-50 small">
                    &copy; <?= date('Y') ?> BB Capture Panel
                </div>
            </div>
        </div>
    </div>

<?php require_once __DIR__ . '/../partials/scripts.php'; ?>