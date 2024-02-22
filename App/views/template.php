<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Minha Aplicação' ?></title>
</head>

<body>
    <!-- Header comum -->
    <header>
        <h1>Meu Site</h1>
        <!-- Outros elementos do header -->
    </header>

    <!-- Conteúdo dinâmico da view -->
    <main>
        <?= $content ?? '' ?>
    </main>

    <!-- Footer comum -->
    <footer>
        <p>&copy; 2024 Meu Site</p>
        <!-- Outros elementos do footer -->
    </footer>
</body>

</html>