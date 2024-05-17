<?php
session_start();

if (isset($_SESSION['usuario_id'])) {
    header("Location: pagInicial.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formularios</title>
    <link rel="stylesheet" href="estilo.css">
    <link rel="shortcut icon" href="Imagens/icones.png" type="image/x-icon">
</head>
<body>
    <header>
        <h1>Formularios.com</h1>
    </header>
    <nav>
        <div class="opcao">
            <img src="Imagens/cadastro.png">
            <a href="cadastro.html"><button>Cadastro</button></a>
        </div>
        <div class="opcao">
            <img src="Imagens/login.png">
            <a href="login.html"><button>Login</button></a>
        </div>
    </nav>
    <main></main>
    <footer>
        <p>&copy; Formularios.com | Feito em 2024 | Criado por henrique pereira</p>
    </footer>
    <script src="script.js"></script>
</body>
</html>
