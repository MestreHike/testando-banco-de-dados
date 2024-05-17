<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

$nome = $_SESSION['nome'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial - Formularios.com</title>
    <link rel="stylesheet" href="estilo.css">
    <link rel="shortcut icon" href="Imagens/icones.png" type="image/x-icon">
</head>
<body>
    <header>
        <h1>Bem-vindo ao Formularios.com</h1>
    </header>
    <main>
        <p>Olá, <?php echo htmlspecialchars($nome); ?>! Você está logado com sucesso!</p>
        <form action="logout.php" method="post">
            <button type="submit">Logout</button>
        </form>
    </main>
    <footer>
        <p>&copy; Formularios.com | Feito em 2024 | Criado por henrique pereira</p>
    </footer>
</body>
</html>
