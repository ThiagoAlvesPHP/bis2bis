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
        <h3>Registro</h3>
        <form action="<?= BASE ?>admin/users/action" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Nome</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <div class="d-grid gap-2 d-md-block">
                <button class="btn btn-success">Salvar</button>
            </div>
        </form>
    </div>
    <div class="col">
        <h3>Lista</h3>
        <?php if (!empty($list)) : ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nome</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <?php foreach ($list as $item) : ?>
                        <tbody>
                            <tr>
                                <th scope="row">
                                    <i class="far fa-edit btn btn-primary" data-bs-toggle="modal" data-bs-target="#edit<?= $item['id']; ?>"></i>

                                    <div class="modal fade" id="edit<?= $item['id']; ?>" tabindex="-1" aria-labelledby="modal" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="modal">Editar</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="<?= BASE ?>admin/users/action?id=<?= $item['id']; ?>" method="POST">
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="name" class="form-label">Nome</label>
                                                            <input type="text" value="<?= $item['name']; ?>" class="form-control" id="name" name="name">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="email" class="form-label">E-mail</label>
                                                            <input type="email" value="<?= $item['email']; ?>" class="form-control" id="email" name="email">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="password" class="form-label">Senha</label>
                                                            <input type="password" class="form-control" id="password" name="password">
                                                        </div>

                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" <?= $item['is_active'] ? "checked" : ""; ?> type="checkbox" role="switch" name="is_active" id="is_active<?= $item['id']; ?>">
                                                            <label class="form-check-label" for="is_active<?= $item['id']; ?>">Status</label>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-success">Salvar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                                <td><?= $item['name']; ?></td>
                                <td><?= $item['email']; ?></td>
                                <td><?= $item['is_active'] ? "Ativo" : "Inativo"; ?></td>
                            </tr>
                        </tbody>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>