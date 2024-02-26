<h1 class="text-center"><?= $this->title; ?></h1>

<?php if (!empty($_SESSION['alert'])) : ?>
    <div class="alert alert-<?= $_SESSION['alert']['class'] ?? ""; ?> <?= $_SESSION['alert']['status'] ? "logado" : ""; ?> d-flex align-items-center" role="alert">
        <div>
            <?= $_SESSION['alert']['message'] ?? ""; ?>
        </div>
    </div>
<?php endif; ?>

<div class="text-center">
    <img class="img-fluid" src="<?= $find['image']; ?>" alt="<?= $find['title']; ?>" />
</div>
<div class="text-bg-light p-3">
    <div class="small text-muted"><?= date("F j, Y", strtotime($find['created_at'])); ?></div>
    <div class="small text-muted">Categoria: <?= $find['name_category']; ?></div>
    <p class="card-text"><?= $find['text']; ?></p>
    <div class="small text-muted">Autor: <?= $find['user_name']; ?></div>

    <hr>
    <?php if (!empty($_SESSION['user'])) : ?>
        <div class="row">
            <div class="col">
                <form class="form-comment" action="<?= BASE ?>post?slug=<?= $find['slug']; ?>" method="POST">
                    <textarea name="text" id="" cols="30" rows="10"></textarea>

                    <div class="d-grid gap-2 d-md-block">
                        <button class="btn btn-success">Comentar</button>
                    </div>
                </form>
            </div>
        </div>
        <hr>
    <?php endif; ?>
    <div class="row">
        <div class="col">
            <h3>Comentários</h3>

            <?php foreach ($comments as $value) : ?>
                <div class="card">
                    <div class="card-body">
                        <?= $value['text']; ?>
                        <div class="small text-muted">
                            Autor: <?= $value['user_name']; ?>
                            <?php if (!empty($_SESSION['user']) && $value['user_id'] == $_SESSION['user']) : ?>
                                | <a href="<?= BASE ?>post?slug=<?= $find['slug']; ?>&comment=<?= $value['id']; ?>" class="fas fa-trash-alt btn btn-danger"></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>


<style>
    .text-center {
        margin: 20px 0;
    }

    img.card-img-top {
        max-width: 400px;
    }

    .form-comment textarea {
        padding: 10px;
        width: 100%;
    }
</style>