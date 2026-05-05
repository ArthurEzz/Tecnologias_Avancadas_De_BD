<?php
$pagina_atual  = 'turmas';
$titulo_pagina = 'Ficha da Turma';
include('./_header.php');
include('./conect.php');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header("Location: turmas_lista.php");
    exit;
}

$q = mysqli_query($con,
  "SELECT t.idturma, t.nometurma, t.semestre, t.ano,
          d.nomedisciplina, c.nomecurso,
          p.idprofessor, p.nomeprofessor, p.titulacao, p.email AS prof_email
   FROM turma t
   JOIN disciplina d ON d.iddisciplina = t.iddisciplina
   JOIN cursos c     ON c.idcurso = d.idcurso
   JOIN professor p  ON p.idprofessor = d.idprofessor
   WHERE t.idturma = $id"
);
$t = mysqli_fetch_assoc($q);

if (!$t) {
    header("Location: turmas_lista.php");
    exit;
}

// Alunos da turma
$q_alunos = mysqli_query($con,
  "SELECT a.ra, a.nome, a.email, a.cidade, a.uf
   FROM itemturma it
   JOIN alunos a ON a.ra = it.ra
   WHERE it.idturma = $id
   ORDER BY a.nome"
);
$total_alunos = mysqli_num_rows($q_alunos);
?>
<main class="page">

  <div class="page-header">
    <div><h2>Ficha da Turma</h2><p>Detalhes completos e alunos matriculados</p></div>
    <a href="turmas_lista.php" class="btn btn-outline">← Voltar à lista</a>
  </div>

  <div class="ficha" style="max-width:820px;">
    <div class="ficha-header">
      <div class="ficha-avatar">🏫</div>
      <div>
        <h2><?php echo htmlspecialchars($t['nometurma']) ?></h2>
        <p>ID: <?php echo $t['idturma'] ?> &nbsp;|&nbsp;
           <?php echo $t['semestre'] ?>º Semestre de <?php echo $t['ano'] ?></p>
      </div>
    </div>

    <div class="ficha-body">
      <div class="ficha-grid">
        <dl class="ficha-field">
          <dt>Disciplina</dt>
          <dd><?php echo htmlspecialchars($t['nomedisciplina']) ?></dd>
        </dl>
        <dl class="ficha-field">
          <dt>Curso</dt>
          <dd><?php echo htmlspecialchars($t['nomecurso']) ?></dd>
        </dl>
        <dl class="ficha-field">
          <dt>Professor</dt>
          <dd>
            <a href="professor_ficha.php?id=<?php echo $t['idprofessor'] ?>"
               style="color:var(--teal);text-decoration:none;font-weight:600;">
              <?php echo htmlspecialchars($t['nomeprofessor']) ?>
            </a>
            <?php if ($t['titulacao']): ?>
            &nbsp;<span class="badge badge-blue"><?php echo htmlspecialchars($t['titulacao']) ?></span>
            <?php endif; ?>
          </dd>
        </dl>
        <dl class="ficha-field">
          <dt>E-mail do Professor</dt>
          <dd style="font-size:.88rem;"><?php echo htmlspecialchars($t['prof_email']) ?></dd>
        </dl>
        <dl class="ficha-field">
          <dt>Período</dt>
          <dd><?php echo $t['semestre'] ?>º Semestre / <?php echo $t['ano'] ?></dd>
        </dl>
        <dl class="ficha-field">
          <dt>Total de Alunos</dt>
          <dd>
            <span class="badge <?php echo $total_alunos > 0 ? 'badge-green' : 'badge-red' ?>"
                  style="font-size:.9rem;padding:4px 12px;">
              <?php echo $total_alunos ?> aluno(s)
            </span>
          </dd>
        </dl>
      </div>

      <hr style="border:none;border-top:1px solid var(--border);margin:28px 0;">
      <h3 style="font-family:'Playfair Display',serif;font-size:1.05rem;color:var(--navy);margin-bottom:16px;">
        👨‍🎓 Alunos Matriculados
      </h3>

      <?php if ($total_alunos > 0): ?>
      <table class="data-table">
        <thead>
          <tr>
            <th>RA</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Cidade / UF</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($a = mysqli_fetch_assoc($q_alunos)): ?>
          <tr>
            <td><strong><?php echo $a['ra'] ?></strong></td>
            <td><?php echo htmlspecialchars($a['nome']) ?></td>
            <td style="font-size:.83rem;"><?php echo htmlspecialchars($a['email']) ?></td>
            <td style="font-size:.85rem;">
              <?php echo htmlspecialchars($a['cidade']) ?><?php echo $a['uf'] ? ' / '.$a['uf'] : '' ?>
            </td>
            <td>
              <a href="aluno_ficha.php?ra=<?php echo $a['ra'] ?>" class="btn btn-sm btn-outline">Ver ficha</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
      <?php else: ?>
      <p style="color:var(--muted);font-size:.9rem;">Nenhum aluno matriculado nesta turma.</p>
      <?php endif; ?>
    </div>

    <div class="ficha-footer">
      <a href="turmas_lista.php"  class="btn btn-outline">← Lista de Turmas</a>
      <a href="turmacadas.php"    class="btn btn-primary">+ Nova Turma</a>
    </div>
  </div>

</main>
</body>
</html>
