<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>

  <meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
  <title></title>


</head>
<body>
 <?php
  $passo=(isset($_POST['passo'])? $_POST['passo']:'0');
           include('./conect.php');
 switch ($passo)
{
	case '0':
	{ ?>
<form method="POST" action="aulaphpconsulta1.php" name="form1"><br>

  <table style="width: 50%; text-align: left; margin-left: auto; margin-right: auto;" border="1" cellpadding="2" cellspacing="2">

    <tbody><tr align="center"><td colspan="2" rowspan="1">Consultar Dados
dos Clientes</td></tr>
       <tr><td style="text-align: center;">Selecionar cliente:</td>

        <td> <?php

        $query  = "select * from clientes";
        $qw     = mysqli_query($con,$query);
        echo "<select name='id'>";
        while($linha = mysqli_fetch_array($qw))
        {
        echo "<option value='$linha[id]'>$linha[id]&nbsp;$linha[1]</option>";}
?>
        </select></td> </tr><tr><td></td><input type="hidden" value="1" name="passo">
         <td><input value="&lt;&lt; consultar &gt;&gt;" type="submit"></td></tr></tbody>
  </table></form>
<?php
 	break;
	}
	case '1':
	{
 $id = $_POST['id'];

 include('./conect.php');
   $query = "select * from clientes where id='$id'";
   $qs    = mysqli_query($con,$query);
   $linha = mysqli_fetch_array($qs);
?>
  <table style="text-align: left; width: 50%;" align="center" border="1" cellpadding="2" cellspacing="2">
    <tbody>
      <tr>
        <td colspan="2" rowspan="1">Cadastro de usuário</td>
      </tr>
      <tr>
        <td>nome:</td>
        <td><input name="nome" value="<?php echo $linha['nome'];?>"></td>
      </tr>
      <tr>
        <td>endere&ccedil;o:</td>
        <td><input name="end" value="<?php echo $linha[2];?>"></td>
      </tr>
      <tr>
        <td>telefone:</td>
        <td><input name="tel" value="<?php echo $linha['tel'];?>"></td>
      </tr>
      <tr>
        <td><a href="index.php"  target="_self">Inicio</a></td><form action="aulaphpconsulta1.php" method="POST"  name="f2"><!-- form de envio ao voltar  -->
        <td><input type="hidden" value="0" name="passo">
		<input type='submit'  value='<< Nova Consulta >>'  ></form></td>
      </tr>
    </tbody>
  </table><?php break;
	}
}
?>
</body>
</html>
