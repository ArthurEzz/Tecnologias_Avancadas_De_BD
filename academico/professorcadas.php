<?php
$pagina_atual  = 'cad_prof';
$titulo_pagina = 'Cadastro de Professor';
include('./_header.php');

$passo = isset($_POST['passo']) ? $_POST['passo'] : '0';

switch ($passo):

  /* ====== PASSO 0 — Formulário ====== */
  case '0':
?>
<main class="page">
  <div class="page-header">
    <div><h2>Cadastro de Professor</h2><p>Preencha os dados do novo professor</p></div>
    <a href="professores_lista.php" class="btn btn-outline">← Ver lista</a>
  </div>

  <div class="form-card">
    <div class="form-card-header">👨‍🏫 Dados do Professor</div>
    <div class="form-card-body">
      <form method="POST" action="professorcadas.php">
        <input type="hidden" name="passo" value="1">

        <div class="form-row">
          <div class="form-group full">
            <label>Nome Completo *</label>
            <input type="text" name="nomeprofessor" placeholder="Ex.: Ana Souza" required maxlength="80">
          </div>

          <div class="form-group">
            <label>CPF *</label>
            <input type="text" name="cpf" placeholder="000.000.000-00" required maxlength="14">
          </div>

          <div class="form-group">
            <label>E-mail *</label>
            <input type="email" name="email" placeholder="prof@academico.edu.br" required maxlength="100">
          </div>

          <div class="form-group">
            <label>Telefone</label>
            <input type="text" name="telefone" placeholder="(00) 90000-0000" maxlength="20">
          </div>

          <div class="form-group">
            <label>Titulação</label>
            <select name="titulacao">
              <option value="">— selecione —</option>
              <option>Graduado</option>
              <option>Especialista</option>
              <option>Mestre</option>
              <option>Doutor</option>
              <option>Doutora</option>
              <option>Pós-Doutor</option>
            </select>
          </div>

          <div class="form-group full">
            <label>Especialidade / Área de atuação</label>
            <input type="text" name="especialidade" placeholder="Ex.: Banco de Dados, IA, Redes…" maxlength="100">
          </div>

          <div class="form-group">
            <label>Data de Admissão</label>
            <input type="date" name="data_admissao">
          </div>
        </div>

        <div class="form-actions">
          <button type="reset" class="btn btn-outline">Limpar</button>
          <button type="submit" class="btn btn-primary">Cadastrar Professor</button>
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

    $nome         = mysqli_real_escape_string($con, trim($_POST['nomeprofessor']));
    $cpf          = mysqli_real_escape_string($con, trim($_POST['cpf']));
    $email        = mysqli_real_escape_string($con, trim($_POST['email']));
    $telefone     = mysqli_real_escape_string($con, trim($_POST['telefone'] ?? ''));
    $titulacao    = mysqli_real_escape_string($con, trim($_POST['titulacao'] ?? ''));
    $especialidade= mysqli_real_escape_string($con, trim($_POST['especialidade'] ?? ''));
    $data_adm     = mysqli_real_escape_string($con, trim($_POST['data_admissao'] ?? ''));

    $da_sql = $data_adm !== '' ? "'$data_adm'" : "NULL";

    $query = "INSERT INTO professor (nomeprofessor, cpf, email, telefone, titulacao, especialidade, data_admissao)
              VALUES ('$nome', '$cpf', '$email', '$telefone', '$titulacao', '$especialidade', $da_sql)";

    $ok  = mysqli_query($con, $query);
    $id  = mysqli_insert_id($con);
?>
<main class="page">
  <div class="page-header">
    <div><h2>Cadastro de Professor</h2><p>Resultado da operação</p></div>
  </div>

  <?php if ($ok): ?>
  <div class="alert alert-success">✅ Professor cadastrado com sucesso!</div>

  <div class="ficha">
    <div class="ficha-header">
      <div class="ficha-avatar">👨‍🏫</div>
      <div>
        <h2><?php echo htmlspecialchars($nome) ?></h2>
        <p>ID: <?php echo $id ?> &nbsp;|&nbsp; <?php echo htmlspecialchars($titulacao) ?></p>
      </div>
    </div>
    <div class="ficha-body">
      <div class="ficha-grid">
        <dl class="ficha-field"><dt>CPF</dt><dd><?php echo htmlspecialchars($cpf) ?></dd></dl>
        <dl class="ficha-field"><dt>E-mail</dt><dd><?php echo htmlspecialchars($email) ?></dd></dl>
        <dl class="ficha-field"><dt>Telefone</dt><dd><?php echo htmlspecialchars($telefone) ?: '—' ?></dd></dl>
        <dl class="ficha-field"><dt>Especialidade</dt><dd><?php echo htmlspecialchars($especialidade) ?: '—' ?></dd></dl>
        <dl class="ficha-field"><dt>Admissão</dt><dd><?php echo $data_adm ? date('d/m/Y', strtotime($data_adm)) : '—' ?></dd></dl>
      </div>
    </div>
    <div class="ficha-footer">
      <a href="professorcadas.php"    class="btn btn-outline">+ Cadastrar outro</a>
      <a href="professores_lista.php" class="btn btn-primary">Ver lista de professores</a>
    </div>
  </div>

  <?php else: ?>
  <div class="alert alert-error">❌ Erro ao cadastrar: <?php echo mysqli_error($con) ?></div>
  <div style="text-align:center;margin-top:24px;">
    <a href="professorcadas.php" class="btn btn-primary">← Tentar novamente</a>
  </div>
  <?php endif; ?>

</main>
<?php
  break;
endswitch;
?>
</body>
</html>
