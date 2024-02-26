<h1 class="text-center"><?= $this->title; ?></h1>

<?php if (!empty($_SESSION['alert'])) : ?>
    <div class="alert alert-<?= $_SESSION['alert']['class'] ?? ""; ?> <?= $_SESSION['alert']['status'] ? "logado" : ""; ?> d-flex align-items-center" role="alert">
        <div>
            <?= $_SESSION['alert']['message'] ?? ""; ?>
        </div>
    </div>
<?php endif; ?>

<form action="<?= BASE ?>profile" method="POST">
    <div class="mb-3">
        <label for="name" class="form-label">Nome</label>
        <input type="text" class="form-control" id="name" value="<?= $find['name']; ?>" name="name">
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">E-mail</label>
        <input type="email" class="form-control" id="email" value="<?= $find['email']; ?>" disabled>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Senha</label>
        <input type="password" class="form-control" id="password" name="password">
    </div>

    <div class="d-grid gap-2 d-md-block">
        <button class="btn btn-success">Salvar</button>
    </div>
</form>