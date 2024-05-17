<?php
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
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$confirmar_senha = $_POST['confirmar_senha'];

// Verifica se as senhas coincidem
if ($senha !== $confirmar_senha) {
    die("As senhas não coincidem. Por favor, volte e tente novamente.");
}

// Verifica se o email já existe na tabela login
$sql = "SELECT email FROM login WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->close();
    $conn->close();
    die("O email já está registrado. Por favor, use um email diferente.");
}

$stmt->close();

// Armazena os dados na tabela cadastro
$sql = "INSERT INTO cadastro (nome, email, senha, confirmar_senha) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $nome, $email, password_hash($senha, PASSWORD_DEFAULT), password_hash($confirmar_senha, PASSWORD_DEFAULT));
$stmt->execute();
$stmt->close();

// Armazena os dados na tabela login
$sql = "INSERT INTO login (nome, email, senha) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $nome, $email, password_hash($senha, PASSWORD_DEFAULT));
$stmt->execute();
$stmt->close();

$conn->close();

// Redireciona para a página de login
header("Location: login.html");
exit();
?>
