<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Consulta de Professor</title>
</head>
<body>

<?php
// Define o passo
$passo = isset($_POST['passo']) ? $_POST['passo'] : '0';

// Conexão com banco (carrega uma vez só)
include('./conect.php');

switch ($passo) {

    // ==============================
    // PASSO 0 - SELECIONAR CLIENTE
    // ==============================
    case '0':
?>

        <form method="POST" action="aulaphpconsulta1.php">
            <table border="1" align="center" width="50%">
                <tr>
                    <td colspan="2" align="center"><strong>Consulta de Professor</strong></td>
                </tr>

                <tr>
                    <td align="center">Selecionar cliente:</td>
                    <td>
                        <select name="id" required>
                            <?php
                            $query = "SELECT * FROM clientes";
                            $resultado = mysqli_query($con, $query);

                            while ($linha = mysqli_fetch_assoc($resultado)) {
                                echo "<option value='{$linha['id']}'>
                                        {$linha['id']} - {$linha['nome']}
                                      </option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" align="center">
                        <input type="hidden" name="passo" value="1">
                        <input type="submit" value="<< Consultar >>">
                    </td>
                </tr>
            </table>
        </form>

<?php
        break;

    // ==============================
    // PASSO 1 - MOSTRAR DADOS
    // ==============================
    case '1':

        $id = $_POST['id'];

        $query = "SELECT * FROM clientes WHERE id = '$id'";
        $resultado = mysqli_query($con, $query);
        $cliente = mysqli_fetch_assoc($resultado);
?>

        <table border="1" align="center" width="50%">
            <tr>
                <td colspan="2" align="center"><strong>Dados do Professor</strong></td>
            </tr>

            <tr>
                <td>Nome:</td>
                <td><input value="<?php echo $cliente['nome']; ?>" disabled></td>
            </tr>

            <tr>
                <td>Endereço:</td>
                <td><input value="<?php echo $cliente['end']; ?>" disabled></td>
            </tr>

            <tr>
                <td>CPF:</td>
                <td><input value="<?php echo $cliente['tel']; ?>" disabled></td>
            </tr>

            <tr>
                <td>
                    <a href="index.php">Início</a>
                </td>
                <td>
                    <form method="POST" action="aulaphpconsulta1.php">
                        <input type="hidden" name="passo" value="0">
                        <input type="submit" value="<< Nova Consulta >>">
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