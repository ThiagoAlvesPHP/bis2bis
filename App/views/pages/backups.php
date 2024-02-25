<h1><?= $this->title; ?></h1>

<?php if (!empty($_SESSION['alert'])) : ?>
    <div class="alert alert-<?= $_SESSION['alert']['class'] ?? ""; ?> <?= $_SESSION['alert']['status'] ? "logado" : ""; ?> d-flex align-items-center" role="alert">
        <div>
            <?= $_SESSION['alert']['message'] ?? ""; ?>
        </div>
    </div>
<?php endif; ?>

<a href="<?= BASE; ?>admin/backups/action?request=true" class="btn btn-success">Gerar Backup</a>
<hr>
<h3>Lista</h3>
<?php if (!empty($list)) : ?>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">Ação</th>
                    <th scope="col">Link</th>
                    <th scope="col">Criado em</th>
                </tr>
            </thead>
            <?php foreach ($list as $item) : ?>
                <tbody>
                    <tr>
                        <td>
                            <a href="<?= BASE; ?>admin/backups/action?del=<?= $item['id']; ?>" class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                        <td>
                            <a href="<?= BASE . $item['path']; ?>" class="link-success link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Download</a>
                        </td>
                        <td><?= date('d/m/Y H:i:s', strtotime($item['created_at'])); ?></td>
                    </tr>
                </tbody>
            <?php endforeach; ?>
        </table>
    </div>
<?php endif; ?>