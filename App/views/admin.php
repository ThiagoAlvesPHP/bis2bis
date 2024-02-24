<div class="row admin">
    <div class="col-2">
        <?php include __DIR__ . '/components/navbar.php'; ?>
    </div>
    <div class="col">
        <?php if (file_exists(__DIR__ . '/pages/' . $this->page . '.php')) : ?>
            <?php include __DIR__ . '/pages/' . $this->page . '.php'; ?>
        <?php else : ?>
            <h1>Error 404</h1>
        <?php endif; ?>
    </div>
</div>