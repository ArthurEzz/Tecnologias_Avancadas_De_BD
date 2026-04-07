<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
  <title>Dados Digitados</title>
</head>
<body>
<?php
  $nome = $_POST['nome'];
  $end  = $_POST['end'];
  $fone = $_POST['fone'];
  
 include('./conect.php');

$query = "insert into clientes values(null,'$nome','$end','$fone')";
$q1    = mysqli_query($con,$query);
?>

  <table align="center" style="text-align: left; width: 100px;" border="1" cellpadding="2" cellspacing="2">
    <tbody>
      <tr>
        <td style="text-align: center;" colspan="3" rowspan="1"><b>DADOS DIGITADOS</b></td>
      </tr>
      <tr>
        <td><b>Nome:</b></td>
        <td><input name="nome" value=<?php echo $nome ?>></td>
      </tr>
      <tr>
        <td><b>Endere&ccedil;o:</b></td>
        <td><input maxlength="60" size="20" name="end" value=<?php echo $end ?>></td>
      </tr>
      <tr>
        <td><b>Telefone:</b></td>
        <td><input maxlength="11" size="20" name="fone" value=<?php echo $fone ?>></td>
      </tr>
      <tr>
        <td><form action="incclientes.html" method="POST" name="f2"><!-- form de envio ao voltar --><input type='submit' value='<< VOLTAR >>' ></form></td>
        <td><td><form action="index.php" method="POST" name="f3"><!-- form de envio ao voltar --><input type='submit' value='<< INICIO >>' ></form></td></td>
      </tr>
    </tbody>
  </table>
</body>
</html>
