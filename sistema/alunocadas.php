<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Aula de PHP</title>
</head>
<body>

<?php
// Define o passo atual (0 = formulário, 1 = processamento)
$passo = isset($_POST['passo']) ? $_POST['passo'] : '0';

switch ($passo) {

    // ==============================
    // PASSO 0 - EXIBE O FORMULÁRIO
    // ==============================
    case '0':
?>
        <form method="POST" action="aulahtmldb.php">
            <table border="1" align="center" width="50%">
                <tr>
                    <td colspan="2" align="center"><strong>Cadastro de Aluno</strong></td>
                </tr>
                <tr>
                    <td>Nome:</td>
                    <td><input type="text" name="nome" required></td>
                </tr>
                <tr>
                    <td>CPF:</td>
                    <td><input type="text" name="cpf" required></td>
                </tr>
                <tr>
                    <td>RA:</td>
                    <td><input type="text" name="ra" required></td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <input type="hidden" name="passo" value="1">
                        <input type="reset" value="<< Limpar >>">
                        <input type="submit" value="<< Enviar >>">
                    </td>
                </tr>
            </table>
        </form>

<?php
        break;

    // ==============================
    // PASSO 1 - PROCESSA OS DADOS
    // ==============================
    case '1':

        // Recebe os dados do formulário
        $nome = $_POST['nome'];
        $cpf  = $_POST['cpf'];
        $ra   = $_POST['ra'];

        // Inclui conexão com banco
        include('./conect.php');

        // Query SQL (atenção: vulnerável a SQL Injection)
        $query = "INSERT INTO clientes VALUES (NULL, '$nome', '$cpf', '$ra')";
        $resultado = mysqli_query($con, $query);
?>

        <table border="1" align="center" width="50%">
            <tr>
                <td colspan="2" align="center"><strong>Cadastro realizado</strong></td>
            </tr>
            <tr>
                <td>Nome:</td>
                <td><input value="<?php echo $nome; ?>" disabled></td>
            </tr>
            <tr>
                <td>CPF:</td>
                <td><input value="<?php echo $cpf; ?>" disabled></td>
            </tr>
            <tr>
                <td>RA:</td>
                <td><input value="<?php echo $ra; ?>" disabled></td>
            </tr>
            <tr>
                <td>
                    <a href="index.php">Início</a>
                </td>
                <td>
                    <form method="POST" action="aulahtmldb.php">
                        <input type="hidden" name="passo" value="0">
                        <input type="submit" value="<< Voltar >>">
                    </form>
                </td>
            </tr>
        </table>

<?php
        break;
}
?>

</body>
</html>