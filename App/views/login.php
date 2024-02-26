<link rel="stylesheet" href="<?= BASE; ?>/../App/web/css/login.css">

<div class="row login">
    <h1 class="text-center"><?= $this->title; ?></h1>

    <form method="POST">
        <?php if (!empty($_SESSION['alert'])) : ?>
            <div class="alert alert-<?= $_SESSION['alert']['class'] ?? ""; ?> <?= $_SESSION['alert']['status'] ? "logado" : ""; ?> d-flex align-items-center" role="alert">
                <div>
                    <?= $_SESSION['alert']['message'] ?? ""; ?>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($url == "register") : ?>
            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input type="text" class="form-control" required name="name" id="name">
            </div>
        <?php endif; ?>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" required id="email" name="email" aria-describedby="emailHelp">
            <div id="emailHelp" class="form-text">Nunca compartilharemos seu e-mail com mais ninguém.</div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input type="password" class="form-control" required name="password" id="password">
        </div>
        <button type="submit" class="btn btn-primary"><?= $this->title; ?></button>
    </form>
</div>

<script defer src="<?= BASE; ?>App/web/js/login.js"></script>