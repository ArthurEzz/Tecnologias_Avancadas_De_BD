<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
  <title></title>
</head>


<body>

<form method="POST" action="rel.php" name="f1">
  <div style="text-align: center;"> </div>

  <table style="width: 20%; text-align: left; margin-left: auto; margin-right: auto;" border="1" cellpadding="2" cellspacing="2">

    <tbody>

      <tr>

        <td style="text-align: center;" colspan="3" rowspan="1">Consulta&nbsp;de Clientes</td>

      </tr>

      <tr>

        <td>&nbsp;
         </td>

        <td> <?php
        include('./conect.php');
        $query  = "select * from clientes";
        $qw     = mysqli_query($con,$query);
        
        echo "<select name='id'>";
        while($linha = mysqli_fetch_array($qw))
        {
        echo "<option value='$linha[id]'>$linha[id]&nbsp;$linha[1]</option>";}

        echo "</select></td><td>&nbsp;</td></tr>";
  ?>
      <tr>

        <td>&nbsp;</td>

        <td><input value="&lt;&lt; Enviar &gt;&gt;" type="submit"></td>

        <td>&nbsp;</td>

      </tr>

    </tbody>
  </table>

  <br>

</form>

</body>
</html>
