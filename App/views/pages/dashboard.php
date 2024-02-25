<h1><?= $this->title; ?></h1>
<?php if (!empty($_SESSION['alert'])) : ?>
    <div class="alert alert-<?= $_SESSION['alert']['class'] ?? ""; ?> <?= $_SESSION['alert']['status'] ? "logado" : ""; ?> d-flex align-items-center" role="alert">
        <div>
            <?= $_SESSION['alert']['message'] ?? ""; ?>
        </div>
    </div>
<?php endif; ?>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                Usuários
            </div>
            <div class="card-body">
                <h5 class="card-title">X</h5>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="#" class="btn btn-primary">
                        <i class="fas fa-location-arrow"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-header">
                Usuários
            </div>
            <div class="card-body">
                <h5 class="card-title">X</h5>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="#" class="btn btn-primary">
                        <i class="fas fa-location-arrow"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-header">
                <?= date('d/m/Y'); ?>
            </div>
            <div class="card-body">
                <h5 class="card-title">X</h5>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="#" class="btn btn-primary">
                        <i class="fas fa-location-arrow"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>