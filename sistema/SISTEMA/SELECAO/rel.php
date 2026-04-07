<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title>Dados do cliente</title>
</head>
<body>
<table
 style="width: 20%; text-align: left; margin-left: auto; margin-right: auto;"
 border="1" cellpadding="2" cellspacing="2">
  <tbody>
    <tr align="center">
      <td style="text-align: center;" colspan="3" rowspan="1"><b>DADOS DO CLIENTE</b></td>
<?php
     $id     =  $_GET['id'];
    include('./conect.php');
     $query  = "select * from clientes where idcliente = '$id'";
     $qw     = mysqli_query($con,$query);
     $linha  = mysqli_fetch_array($qw);


?>
    </tr>
    <tr>
      <td><b>Nome:</b></td>
      <td><?php echo $linha['nome'];?></td>
    </tr>
    <tr>
      <td><b>Endere&ccedil;o:</b></td>
      <td><?php echo $linha['end'];?></td>
    </tr>
    <tr>
      <td><b>Telefone:</b></td>
      <td><?php echo $linha['telf'];?></td>
    </tr>
    <tr>
    </tr>
    <td><form action="index.php" method="POST" name="f2"><!-- form de envio ao voltar --><input type='submit' value='<< INICIO >>' ></form></td>
      <td><td><form action="selecao.php" method="POST" name="f3"><!-- form de envio ao voltar --><input type='submit' value='<< VOLTAR >>' ></form></td></td>
  </tbody>
</table>
<br>
</BODY>
</HTML>
