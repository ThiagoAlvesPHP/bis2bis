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
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z" />
                                    <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z" />
                                </svg>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page header with logo and tagline-->
    <header class="py-5 bg-light border-bottom mb-4">
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