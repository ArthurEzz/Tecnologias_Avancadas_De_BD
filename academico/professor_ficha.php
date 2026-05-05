<?php
$pagina_atual  = 'professores';
$titulo_pagina = 'Ficha do Professor';
include('./_header.php');
include('./conect.php');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header("Location: professores_lista.php");
    exit;
}

$q = mysqli_query($con, "SELECT * FROM professor WHERE idprofessor = $id");
$p = mysqli_fetch_assoc($q);

if (!$p) {
    header("Location: professores_lista.php");
    exit;
}

// Disciplinas do professor
$q_discs = mysqli_query($con,
  "SELECT d.nomedisciplina, c.nomecurso,
          GROUP_CONCAT(t.nometurma ORDER BY t.ano DESC SEPARATOR ', ') AS turmas
   FROM disciplina d
   JOIN cursos c ON c.idcurso = d.idcurso
   LEFT JOIN turma t ON t.iddisciplina = d.iddisciplina
   WHERE d.idprofessor = $id
   GROUP BY d.iddisciplina
   ORDER BY d.nomedisciplina"
);
?>
<main class="page">

  <div class="page-header">
    <div><h2>Ficha do Professor</h2><p>Detalhes completos do registro</p></div>
    <a href="professores_lista.php" class="btn btn-outline">← Voltar à lista</a>
  </div>

  <div class="ficha">
    <div class="ficha-header">
      <div class="ficha-avatar">👨‍🏫</div>
      <div>
        <h2><?php echo htmlspecialchars($p['nomeprofessor']) ?></h2>
        <p>
          ID: <?php echo $p['idprofessor'] ?>
          <?php if ($p['titulacao']): ?>&nbsp;|&nbsp; <?php echo htmlspecialchars($p['titulacao']) ?><?php endif; ?>
        </p>
      </div>
    </div>

    <div class="ficha-body">
      <div class="ficha-grid">
        <dl class="ficha-field">
          <dt>CPF</dt>
          <dd style="font-family:monospace;"><?php echo $p['cpf'] ?></dd>
        </dl>
        <dl class="ficha-field">
          <dt>E-mail</dt>
          <dd><?php echo htmlspecialchars($p['email']) ?></dd>
        </dl>
        <dl class="ficha-field">
          <dt>Telefone</dt>
          <dd><?php echo htmlspecialchars($p['telefone']) ?: '—' ?></dd>
        </dl>
        <dl class="ficha-field">
          <dt>Especialidade</dt>
          <dd><?php echo htmlspecialchars($p['especialidade']) ?: '—' ?></dd>
        </dl>
        <dl class="ficha-field">
          <dt>Data de Admissão</dt>
          <dd><?php echo $p['data_admissao'] ? date('d/m/Y', strtotime($p['data_admissao'])) : '—' ?></dd>
        </dl>
        <dl class="ficha-field">
          <dt>Status</dt>
          <dd><span class="badge badge-green">Ativo</span></dd>
        </dl>
      </div>

      <?php if (mysqli_num_rows($q_discs) > 0): ?>
      <hr style="border:none;border-top:1px solid var(--border);margin:28px 0;">
      <h3 style="font-family:'Playfair Display',serif;font-size:1.05rem;color:var(--navy);margin-bottom:16px;">
        📚 Disciplinas Ministradas
      </h3>
      <table class="data-table">
        <thead>
          <tr><th>Disciplina</th><th>Curso</th><th>Turmas</th></tr>
        </thead>
        <tbody>
          <?php while ($d = mysqli_fetch_assoc($q_discs)): ?>
          <tr>
            <td><?php echo htmlspecialchars($d['nomedisciplina']) ?></td>
            <td><?php echo htmlspecialchars($d['nomecurso']) ?></td>
            <td style="font-size:.83rem;color:var(--muted);"><?php echo $d['turmas'] ?: '—' ?></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
      <?php else: ?>
      <p style="color:var(--muted);margin-top:20px;font-size:.9rem;">Nenhuma disciplina atribuída.</p>
      <?php endif; ?>
    </div>

    <div class="ficha-footer">
      <a href="professores_lista.php" class="btn btn-outline">← Lista de Professores</a>
      <a href="professorcadas.php"    class="btn btn-primary">+ Novo Professor</a>
    </div>
  </div>

</main>
</body>
</html>
