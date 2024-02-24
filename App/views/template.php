<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->title ?? 'Minha Aplicação' ?></title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="<?= BASE; ?>App/web/assets/favicon.ico" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="<?= BASE; ?>App/web/css/styles.css" rel="stylesheet" />
    <!-- Fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script>
        const BASE = "<?= BASE; ?>";
    </script>
</head>

<body>
    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= BASE; ?>">Bis2Bis</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#!">
                            Contato
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?= BASE; ?>admin">
                            <?= (!empty($_SESSION['user'])) ? "Admin" : "Login" ?>
                        </a>
                    </li>
                    <?php if (!empty($_SESSION['user'])) : ?>
                        <li class="nav-item">
                            <a class="nav-link" title="Logout" href="<?= BASE; ?>logout">
                                <i class="fas fa-sign-out-alt"></i>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page header with logo and tagline-->
    <header class="py-5 bg-light border-bottom mb-4" style="margin-bottom: 0 !important;">
        <div class="container">
            <div class="text-center my-5">
                <h1 class="fw-bolder">Bem-vindo ao Blog Bis2Bis!</h1>
                <p class="lead mb-0">Atualizando sua mente com notícias do mundo!</p>
            </div>
        </div>
    </header>

    <!-- Conteúdo dinâmico da view -->
    <main class="container">
        <?= $content ?? '' ?>
    </main>

    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; Your Website <?= date('Y'); ?></p>
        </div>
    </footer>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="<?= BASE; ?>App/web/js/scripts.js"></script>
</body>

</html>