<?php
include 'cadastrar.php';

if($_SERVER ['REQUEST_METHOD'] == POST){
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $senha = $_POST['senha'];
    $conn->query("INSERT INTO Clientes (nome, telefone, email, senha) VALUES ('$nome', '$email', '$telefone', '$senha')");
}
?>
<form method="post">
    <input type="text" value="Digite seu nome">
</form>