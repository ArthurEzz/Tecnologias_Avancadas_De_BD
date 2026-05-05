<?php
$pagina_atual  = 'cad_aluno';
$titulo_pagina = 'Cadastro de Aluno';
include('./_header.php');

$passo = isset($_POST['passo']) ? $_POST['passo'] : '0';

switch ($passo):

  /* ====== PASSO 0 — Formulário ====== */
  case '0':
?>
<main class="page">
  <div class="page-header">
    <div><h2>Cadastro de Aluno</h2><p>Preencha os dados do novo aluno</p></div>
    <a href="alunos_lista.php" class="btn btn-outline">← Ver lista</a>
  </div>

  <div class="form-card">
    <div class="form-card-header">👨‍🎓 Dados do Aluno</div>
    <div class="form-card-body">
      <form method="POST" action="alunocadas.php">
        <input type="hidden" name="passo" value="1">

        <div class="form-row">
          <div class="form-group full">
            <label>Nome Completo *</label>
            <input type="text" name="nome" placeholder="Ex.: João Pedro Silva" required maxlength="80">
          </div>

          <div class="form-group">
            <label>CPF *</label>
            <input type="text" name="cpf" placeholder="000.000.000-00" required maxlength="14">
          </div>

          <div class="form-group">
            <label>RA (Registro Acadêmico) *</label>
            <input type="number" name="ra" placeholder="Ex.: 1008" required>
          </div>

          <div class="form-group full">
            <label>E-mail *</label>
            <input type="email" name="email" placeholder="aluno@academico.edu.br" required maxlength="100">
          </div>

          <div class="form-group">
            <label>Telefone</label>
            <input type="text" name="telefone" placeholder="(00) 90000-0000" maxlength="20">
          </div>

          <div class="form-group">
            <label>Data de Nascimento</label>
            <input type="date" name="data_nasc">
          </div>

          <div class="form-group full">
            <label>Endereço</label>
            <input type="text" name="endereco" placeholder="Rua, número, complemento" maxlength="150">
          </div>

          <div class="form-group">
            <label>Cidade</label>
            <input type="text" name="cidade" placeholder="Ex.: São Paulo" maxlength="60">
          </div>

          <div class="form-group">
            <label>UF</label>
            <select name="uf">
              <option value="">— selecione —</option>
              <?php
              $ufs = ['AC','AL','AP','AM','BA','CE','DF','ES','GO','MA','MT','MS',
                      'MG','PA','PB','PR','PE','PI','RJ','RN','RS','RO','RR','SC',
                      'SP','SE','TO'];
              foreach ($ufs as $u) echo "<option value='$u'>$u</option>";
              ?>
            </select>
          </div>
        </div>

        <div class="form-actions">
          <button type="reset" class="btn btn-outline">Limpar</button>
          <button type="submit" class="btn btn-primary">Cadastrar Aluno</button>
        </div>
      </form>
    </div>
  </div>
</main>

<?php
  break;

  /* ====== PASSO 1 — Processamento ====== */
  case '1':
    include('./conect.php');

    $ra        = (int)   $_POST['ra'];
    $nome      = mysqli_real_escape_string($con, trim($_POST['nome']));
    $cpf       = mysqli_real_escape_string($con, trim($_POST['cpf']));
    $email     = mysqli_real_escape_string($con, trim($_POST['email']));
    $telefone  = mysqli_real_escape_string($con, trim($_POST['telefone'] ?? ''));
    $data_nasc = mysqli_real_escape_string($con, trim($_POST['data_nasc'] ?? ''));
    $endereco  = mysqli_real_escape_string($con, trim($_POST['endereco'] ?? ''));
    $cidade    = mysqli_real_escape_string($con, trim($_POST['cidade'] ?? ''));
    $uf        = mysqli_real_escape_string($con, trim($_POST['uf'] ?? ''));

    $dn_sql    = $data_nasc !== '' ? "'$data_nasc'" : "NULL";

    $query = "INSERT INTO alunos (ra, nome, cpf, email, telefone, data_nasc, endereco, cidade, uf)
              VALUES ($ra, '$nome', '$cpf', '$email', '$telefone', $dn_sql, '$endereco', '$cidade', '$uf')";

    $ok = mysqli_query($con, $query);
?>
<main class="page">
  <div class="page-header">
    <div><h2>Cadastro de Aluno</h2><p>Resultado da operação</p></div>
  </div>

  <?php if ($ok): ?>
  <div class="alert alert-success">✅ Aluno cadastrado com sucesso!</div>

  <div class="ficha">
    <div class="ficha-header">
      <div class="ficha-avatar">👨‍🎓</div>
      <div>
        <h2><?php echo htmlspecialchars($nome) ?></h2>
        <p>RA: <?php echo $ra ?> &nbsp;|&nbsp; <?php echo htmlspecialchars($cpf) ?></p>
      </div>
    </div>
    <div class="ficha-body">
      <div class="ficha-grid">
        <dl class="ficha-field"><dt>E-mail</dt><dd><?php echo htmlspecialchars($email) ?></dd></dl>
        <dl class="ficha-field"><dt>Telefone</dt><dd><?php echo htmlspecialchars($telefone) ?: '—' ?></dd></dl>
        <dl class="ficha-field"><dt>Nascimento</dt><dd><?php echo $data_nasc ? date('d/m/Y', strtotime($data_nasc)) : '—' ?></dd></dl>
        <dl class="ficha-field"><dt>Cidade / UF</dt><dd><?php echo htmlspecialchars($cidade) ?><?php echo $uf ? " / $uf" : '' ?></dd></dl>
        <dl class="ficha-field full" style="grid-column:1/-1"><dt>Endereço</dt><dd><?php echo htmlspecialchars($endereco) ?: '—' ?></dd></dl>
      </div>
    </div>
    <div class="ficha-footer">
      <a href="alunocadas.php" class="btn btn-outline">+ Cadastrar outro</a>
      <a href="alunos_lista.php" class="btn btn-primary">Ver lista de alunos</a>
    </div>
  </div>

  <?php else: ?>
  <div class="alert alert-error">❌ Erro ao cadastrar: <?php echo mysqli_error($con) ?></div>
  <div style="text-align:center;margin-top:24px;">
    <a href="alunocadas.php" class="btn btn-primary">← Tentar novamente</a>
  </div>
  <?php endif; ?>

</main>
<?php
  break;
endswitch;
?>
</body>
</html>
