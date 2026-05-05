<?php
$pagina_atual  = 'cad_turma';
$titulo_pagina = 'Cadastro de Turma';
include('./_header.php');

$passo = isset($_POST['passo']) ? $_POST['passo'] : '0';

switch ($passo):

  /* ====== PASSO 0 — Formulário ====== */
  case '0':
    include('./conect.php');

    $disciplinas = mysqli_query($con,
      "SELECT d.iddisciplina, d.nomedisciplina, c.nomecurso, p.nomeprofessor
       FROM disciplina d
       JOIN cursos c ON c.idcurso = d.idcurso
       JOIN professor p ON p.idprofessor = d.idprofessor
       ORDER BY d.nomedisciplina"
    );
?>
<main class="page">
  <div class="page-header">
    <div><h2>Cadastro de Turma</h2><p>Preencha os dados da nova turma</p></div>
    <a href="turmas_lista.php" class="btn btn-outline">← Ver lista</a>
  </div>

  <div class="form-card">
    <div class="form-card-header">🏫 Dados da Turma</div>
    <div class="form-card-body">
      <form method="POST" action="turmacadas.php">
        <input type="hidden" name="passo" value="1">

        <div class="form-row">
          <div class="form-group full">
            <label>Nome da Turma *</label>
            <input type="text" name="nometurma" placeholder="Ex.: Turma A — Banco de Dados" required maxlength="80">
          </div>

          <div class="form-group full">
            <label>Disciplina *</label>
            <select name="iddisciplina" required>
              <option value="">— selecione uma disciplina —</option>
              <?php while ($d = mysqli_fetch_assoc($disciplinas)): ?>
              <option value="<?php echo $d['iddisciplina'] ?>">
                <?php echo htmlspecialchars($d['nomedisciplina']) ?>
                — <?php echo htmlspecialchars($d['nomecurso']) ?>
                (Prof. <?php echo htmlspecialchars($d['nomeprofessor']) ?>)
              </option>
              <?php endwhile; ?>
            </select>
          </div>

          <div class="form-group">
            <label>Semestre *</label>
            <select name="semestre" required>
              <option value="">— selecione —</option>
              <option value="1">1º Semestre</option>
              <option value="2">2º Semestre</option>
            </select>
          </div>

          <div class="form-group">
            <label>Ano *</label>
            <input type="number" name="ano" placeholder="Ex.: 2026" required
                   min="2000" max="2099" value="<?php echo date('Y') ?>">
          </div>
        </div>

        <div class="form-actions">
          <button type="reset" class="btn btn-outline">Limpar</button>
          <button type="submit" class="btn btn-primary">Cadastrar Turma</button>
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

    $nometurma    = mysqli_real_escape_string($con, trim($_POST['nometurma']));
    $iddisciplina = (int) $_POST['iddisciplina'];
    $semestre     = (int) $_POST['semestre'];
    $ano          = (int) $_POST['ano'];

    $query = "INSERT INTO turma (nometurma, iddisciplina, semestre, ano)
              VALUES ('$nometurma', $iddisciplina, $semestre, $ano)";

    $ok  = mysqli_query($con, $query);
    $id  = mysqli_insert_id($con);

    // Busca detalhes para exibir na ficha de confirmação
    $info = mysqli_fetch_assoc(mysqli_query($con,
      "SELECT d.nomedisciplina, c.nomecurso, p.nomeprofessor
       FROM disciplina d
       JOIN cursos c ON c.idcurso = d.idcurso
       JOIN professor p ON p.idprofessor = d.idprofessor
       WHERE d.iddisciplina = $iddisciplina"
    ));
?>
<main class="page">
  <div class="page-header">
    <div><h2>Cadastro de Turma</h2><p>Resultado da operação</p></div>
  </div>

  <?php if ($ok): ?>
  <div class="alert alert-success">✅ Turma cadastrada com sucesso!</div>

  <div class="ficha">
    <div class="ficha-header">
      <div class="ficha-avatar">🏫</div>
      <div>
        <h2><?php echo htmlspecialchars($nometurma) ?></h2>
        <p>ID: <?php echo $id ?> &nbsp;|&nbsp; <?php echo $semestre ?>º Semestre / <?php echo $ano ?></p>
      </div>
    </div>
    <div class="ficha-body">
      <div class="ficha-grid">
        <dl class="ficha-field"><dt>Disciplina</dt><dd><?php echo htmlspecialchars($info['nomedisciplina']) ?></dd></dl>
        <dl class="ficha-field"><dt>Curso</dt><dd><?php echo htmlspecialchars($info['nomecurso']) ?></dd></dl>
        <dl class="ficha-field"><dt>Professor</dt><dd><?php echo htmlspecialchars($info['nomeprofessor']) ?></dd></dl>
        <dl class="ficha-field"><dt>Período</dt><dd><?php echo $semestre ?>º Semestre de <?php echo $ano ?></dd></dl>
      </div>
    </div>
    <div class="ficha-footer">
      <a href="turmacadas.php"  class="btn btn-outline">+ Cadastrar outra</a>
      <a href="turma_ficha.php?id=<?php echo $id ?>" class="btn btn-outline">Ver ficha</a>
      <a href="turmas_lista.php" class="btn btn-primary">Ver lista de turmas</a>
    </div>
  </div>

  <?php else: ?>
  <div class="alert alert-error">❌ Erro ao cadastrar: <?php echo mysqli_error($con) ?></div>
  <div style="text-align:center;margin-top:24px;">
    <a href="turmacadas.php" class="btn btn-primary">← Tentar novamente</a>
  </div>
  <?php endif; ?>

</main>
<?php
  break;
endswitch;
?>
</body>
</html>
