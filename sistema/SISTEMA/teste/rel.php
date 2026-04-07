<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title></title>
</head>
<body>
<table
 style="width: 20%; text-align: left; margin-left: auto; margin-right: auto;"
 border="1" cellpadding="2" cellspacing="2">
  <tbody>
    <tr align="center">
      <td colspan="2" rowspan="1">Dados do Cliente
cadastrado</td>
<?php
     $id     =  $_POST['id'];
     include('./conect.php');
     $query  = "select * from clientes where id = '$id'";
     $qw     = mysqli_query($con,$query);
     $linha  = mysqli_fetch_array($qw);

?>
    </tr>
    <tr>
      <td>Nome:</td>
      <td><?php echo $linha[1];?></td>
    </tr>
    <tr>
      <td>Endere&ccedil;o:</td>
      <td><input name="end" value="<?php echo $linha[2];?>"></td>
    </tr>
    <tr>
      <td>Telefone:</td>
      <td><input name="tel" value="<?php echo $linha[3];?>"></td>
    </tr>
    <tr>
      <td><input value="&lt;&lt; Voltar &gt;&gt;" type="submit"></td>
      <td></td>
    </tr>
  </tbody>
</table>
<br>
</BODY>
</HTML>
