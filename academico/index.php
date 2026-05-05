<?php
$pagina_atual  = 'home';
$titulo_pagina = 'Início';
include('./_header.php');
include('./conect.php');

$total_alunos   = mysqli_fetch_row(mysqli_query($con, "SELECT COUNT(*) FROM alunos WHERE ativo=1"))[0];
$total_profs    = mysqli_fetch_row(mysqli_query($con, "SELECT COUNT(*) FROM professor WHERE ativo=1"))[0];
$total_turmas   = mysqli_fetch_row(mysqli_query($con, "SELECT COUNT(*) FROM turma"))[0];
$total_discs    = mysqli_fetch_row(mysqli_query($con, "SELECT COUNT(*) FROM disciplina"))[0];
?>

<main class="page">

  <div class="page-header">
    <div>
      <h2>Painel Principal</h2>
      <p>Bem-vindo ao Sistema de Gestão Acadêmica</p>
    </div>
  </div>

  <!-- Estatísticas rápidas -->
  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:16px;margin-bottom:36px;">
    <?php
    $stats = [
      ['🎓','Alunos Ativos',   $total_alunos,  'alunos_lista.php'],
      ['👨‍🏫','Professores',    $total_profs,   'professores_lista.php'],
      ['📚','Disciplinas',     $total_discs,   '#'],
      ['🏫','Turmas Abertas',  $total_turmas,  'turmas_lista.php'],
    ];
    foreach ($stats as $s): ?>
    <a href="<?php echo $s[3] ?>" style="text-decoration:none;">
      <div class="card" style="padding:20px;">
        <div style="font-size:2rem;margin-bottom:8px;"><?php echo $s[0] ?></div>
        <div style="font-size:2rem;font-weight:700;color:var(--navy);font-family:'Playfair Display',serif;">
          <?php echo $s[2] ?>
        </div>
        <div style="font-size:.83rem;color:var(--muted);margin-top:2px;"><?php echo $s[1] ?></div>
      </div>
    </a>
    <?php endforeach; ?>
  </div>

  <!-- Módulos -->
  <div class="page-header" style="margin-top:0;">
    <div><h2>Módulos</h2><p>Acesse as funcionalidades do sistema</p></div>
  </div>

  <div class="cards-grid">

    <div class="card">
      <div class="card-icon">👨‍🎓</div>
      <h3>Matrícula de Alunos</h3>
      <p>Registre novos alunos com todos os dados pessoais e acadêmicos.</p>
      <div class="card-actions">
        <a href="alunocadas.php"   class="btn btn-primary">+ Novo Aluno</a>
        <a href="alunos_lista.php" class="btn btn-outline">Consultar</a>
      </div>
    </div>

    <div class="card">
      <div class="card-icon">👨‍🏫</div>
      <h3>Cadastro de Professores</h3>
      <p>Registre professores com titulação, especialidade e contato.</p>
      <div class="card-actions">
        <a href="professorcadas.php"    class="btn btn-primary">+ Novo Professor</a>
        <a href="professores_lista.php" class="btn btn-outline">Consultar</a>
      </div>
    </div>

    <div class="card">
      <div class="card-icon">🏫</div>
      <h3>Cadastro de Turmas</h3>
      <p>Crie turmas vinculando disciplina, professor e período letivo.</p>
      <div class="card-actions">
        <a href="turmacadas.php"   class="btn btn-primary">+ Nova Turma</a>
        <a href="turmas_lista.php" class="btn btn-outline">Consultar</a>
      </div>
    </div>

    <div class="card">
      <div class="card-icon">📋</div>
      <h3>Consulta de Alunos</h3>
      <p>Visualize a lista completa e a ficha detalhada de cada aluno.</p>
      <div class="card-actions">
        <a href="alunos_lista.php" class="btn btn-primary">Ver Lista</a>
      </div>
    </div>

    <div class="card">
      <div class="card-icon">📋</div>
      <h3>Consulta de Professores</h3>
      <p>Visualize a lista e a ficha detalhada de cada professor.</p>
      <div class="card-actions">
        <a href="professores_lista.php" class="btn btn-primary">Ver Lista</a>
      </div>
    </div>

    <div class="card">
      <div class="card-icon">📋</div>
      <h3>Consulta de Turmas</h3>
      <p>Filtre turmas por semestre, ano ou nome e veja os alunos matriculados.</p>
      <div class="card-actions">
        <a href="turmas_lista.php" class="btn btn-primary">Ver Lista</a>
      </div>
    </div>

  </div>
</main>
</body>
</html>
