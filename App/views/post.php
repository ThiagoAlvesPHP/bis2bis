<h1 class="text-center"><?= $this->title; ?></h1>

<div class="text-center">
    <img class="img-fluid" src="<?= $find['image']; ?>" alt="<?= $find['title']; ?>" />
</div>
<div class="text-bg-light p-3">
    <div class="small text-muted"><?= date("F j, Y", strtotime($find['created_at'])); ?></div>
    <div class="small text-muted">Categoria: <?= $find['name_category']; ?></div>
    <p class="card-text"><?=$find['text']; ?></p>
    <div class="small text-muted">Autor: <?= $find['user_name']; ?></div>
</div>


<style>
    .text-center {
        margin: 20px 0;
    }

    img.card-img-top {
        max-width: 400px;
    }
</style>