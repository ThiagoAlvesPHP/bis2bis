<div class="row" style="margin-top: 20px;">
    <div class="col-lg-8">
        <!-- Featured blog post-->
        <?php if (!$name_category && !$search) : ?>
            <div class="card mb-4">
                <a href="<?= BASE . 'post?slug=' . $postRand['slug']; ?>">
                    <img class="card-img-top" src="<?= $postRand['image']; ?>" alt="<?= $postRand['title']; ?>" />
                </a>
                <div class="card-body">
                    <div class="small text-muted"><?= date("F j, Y", strtotime($postRand['created_at'])); ?></div>
                    <div class="small text-muted">Categoria: <?= $postRand['name_category']; ?></div>
                    <h2 class="card-title"><?= $postRand['title']; ?></h2>
                    <p class="card-text"><?= substr($postRand['text'], 0, 100); ?></p>
                    <a class="btn btn-primary" href="<?= BASE . 'post?slug=' . $postRand['slug']; ?>"><i class="fas fa-eye"></i></a>
                </div>
            </div>
        <?php endif; ?>
        <!-- Nested row for non-featured blog posts-->

        <?= $search ? '<h4><i class="fas fa-search"></i> Pesquisa: ' . $search . '<h4>' : ""; ?>
        <?= $name_category ? '<h4><i class="fas fa-search"></i> Categoria: ' . $name_category . '<h4>' : ""; ?>

        <div class="row">
            <?php foreach ($posts as $post) : ?>
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <a href="<?= BASE . 'post?slug=' . $post['slug']; ?>">
                            <img class="card-img-top" src="<?= $post['image']; ?>" alt="..." />
                        </a>
                        <div class="card-body">
                            <div class="small text-muted"><?= date("F j, Y", strtotime($post['created_at'])); ?></div>
                            <div class="small text-muted">Categoria: <?= $post['name_category']; ?></div>
                            <h2 class="card-title h4"><?= $post['title']; ?></h2>
                            <p class="card-text"><?= substr($post['text'], 0, 100); ?></p>
                            <a class="btn btn-primary" href="<?= BASE . 'post?slug=' . $post['slug']; ?>"><i class="fas fa-eye"></i></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <!-- Side widgets-->
    <div class="col-lg-4">
        <!-- Search widget-->
        <div class="card mb-4">
            <div class="card-header">Pesquisar</div>
            <div class="card-body">
                <form action="<?= BASE; ?>" method="GET">
                    <div class="input-group">
                        <input class="form-control" name="search" type="text" placeholder="Procurar post..." aria-label="Enter search term..." aria-describedby="button-search" />
                        <button class="btn btn-primary" id="button-search">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Categories widget-->
        <div class="card mb-4">
            <div class="card-header">Categories</div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <?php foreach ($categories as $value) : ?>
                        <li class="list-group-item"><a href="<?= BASE; ?>?name_category=<?= $value['name']; ?>"><?= $value['name']; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
</div>