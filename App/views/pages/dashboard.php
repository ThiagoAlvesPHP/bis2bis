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
                <i class="fas fa-users"></i> Usuários
            </div>
            <div class="card-body">
                <h5 class="card-title"><?= $this->countUsers; ?></h5>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="<?= BASE; ?>admin/users" class="btn btn-primary">
                        <i class="fas fa-location-arrow"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card">
            <div class="card-header">
                <i class="fas fa-address-card"></i> Posts
            </div>
            <div class="card-body">
                <h5 class="card-title"><?= $this->countPosts; ?></h5>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="<?= BASE; ?>admin/posts" class="btn btn-primary">
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
                <h5 class="card-title" id="time">X</h5>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <?=date('l', strtotime(date('Y-m-d'))) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Função para atualizar a hora no elemento HTML
    function updateTime() {
        // Obtenha a data e hora atual
        var now = new Date();

        // Extraia horas, minutos e segundos
        var hours = ('0' + now.getHours()).slice(-2);
        var minutes = ('0' + now.getMinutes()).slice(-2);
        var seconds = ('0' + now.getSeconds()).slice(-2);

        // Formate a hora como "hh:mm:ss"
        var formattedTime = hours + ':' + minutes + ':' + seconds;

        // Atualize o conteúdo do elemento HTML
        $('#time').text(formattedTime);
    }
    // Atualize a hora a cada segundo
    setInterval(updateTime, 1000);
    // Chame a função inicialmente para exibir a hora imediatamente
    updateTime();
</script>