<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "kiki2401";
$dbname = "login_cadastro";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtém os dados do formulário
$email = $_POST['email'];
$senha = $_POST['senha'];

// Verifica se o usuário já está na tabela login
$sql = "SELECT id, nome, email, senha FROM login WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $nome, $stored_email, $stored_senha);

if ($stmt->num_rows > 0) {
    // O usuário já está registrado, verifica a senha e redireciona
    $stmt->fetch();
    if (password_verify($senha, $stored_senha)) {
        $_SESSION['usuario_id'] = $id;
        $_SESSION['nome'] = $nome;
        $stmt->close();
        $conn->close();
        header("Location: pagInicial.php");
        exit();
    } else {
        $stmt->close();
        $conn->close();
        die("Senha incorreta. Por favor, tente novamente.");
    }
}

// Verifica se o usuário está na tabela cadastro
$sql = "SELECT id, nome, senha FROM cadastro WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($id, $nome, $stored_senha);

if ($stmt->num_rows > 0) {
    // O usuário está na tabela cadastro, verifica a senha e armazena na tabela login
    $stmt->fetch();
    if (password_verify($senha, $stored_senha)) {
        // Armazena na tabela login
        $sql = "INSERT INTO login (nome, email, senha) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $nome, $email, password_hash($senha, PASSWORD_DEFAULT));
        $stmt->execute();
        $_SESSION['usuario_id'] = $stmt->insert_id;
        $_SESSION['nome'] = $nome;
        $stmt->close();
        
        // Remove o usuário da tabela cadastro
        $sql = "DELETE FROM cadastro WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->close();

        $conn->close();
        header("Location: pagInicial.php");
        exit();
    } else {
        $stmt->close();
        $conn->close();
        die("Senha incorreta. Por favor, tente novamente.");
    }
} else {
    $stmt->close();
    $conn->close();
    die("Usuário não encontrado. Por favor, cadastre-se.");
}
?>
