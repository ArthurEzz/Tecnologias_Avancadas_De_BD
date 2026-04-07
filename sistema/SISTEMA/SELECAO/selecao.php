<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
  <title>Selecao</title>
</head>


<body>

<form method="GET" action="rel.php" name="f1">
  <div style="text-align: center;"> </div>

  <table style="width: 20%; text-align: left; margin-left: auto; margin-right: auto;" border="1" cellpadding="2" cellspacing="2">

    <tbody>

      <tr>

        <td style="text-align: center;" colspan="3" rowspan="1"><b>CONSULTA DE CLIENTES</b></td>

      </tr>

      <tr>

        <td>&nbsp;
         </td>

        <td>
        <?php
        include('./conect.php');
        $query  = "SELECT * FROM `clientes`;";
        $qw     = mysqli_query($con,$query);
        
        echo "<select name='id'>";
        while($linha = mysqli_fetch_array($qw))
        {
        echo "<option value='$linha[idcliente]'>$linha[idcliente]&nbsp;$linha[nome]</option>";}

        echo "</select></td><td>&nbsp;</td></tr>";
        ?>
      <tr>

        <td>&nbsp;</td>

        <td><input value="&lt;&lt; ENVIAR &gt;&gt;" type="submit"></td>
        <td><a href="index.php" title="INICIO" target="_blank"><font face="Arial" size="3" color="Black"><b>INICIO</b></font></a></td>


      </tr>

    </tbody>
  </table>

  <br>

</form>

</body>
</html>
