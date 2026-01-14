<?php require_once __DIR__ . '/../partials/head.php'; ?>

<body class="auth-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card card-auth">
                    <div class="card-header">
                        <div class="auth-icon text-warning">
                            <i class="fas fa-lock-open"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-0">Recuperar Clave</h4>
                        <p class="text-muted small">Te enviaremos las instrucciones</p>
                    </div>
                    <div class="card-body p-4">
                        <form action="/forgot-password" method="POST">
                            <div class="form-floating mb-4">
                                <input type="email" class="form-control" id="email" name="email" placeholder="nombre@ejemplo.com" required>
                                <label for="email"><i class="fas fa-envelope me-2 text-muted"></i>Email registrado</label>
                            </div>
                            
                            <div class="d-grid gap-2 mb-3">
                                <button type="submit" class="btn btn-primary shadow-sm">
                                    ENVIAR ENLACE <i class="fas fa-paper-plane ms-2"></i>
                                </button>
                            </div>
                        </form>
                        
                        <div class="text-center border-top pt-3">
                            <a href="/login" class="btn btn-link btn-sm">
                                <i class="fas fa-arrow-left me-1"></i> Volver al Login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php require_once __DIR__ . '/../partials/scripts.php'; ?>