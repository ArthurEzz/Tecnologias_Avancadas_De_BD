<?php

if (!isset($pagina_atual)) $pagina_atual = '';
$titulo_pagina = isset($titulo_pagina) ? $titulo_pagina : 'Sistema Acadêmico';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo htmlspecialchars($titulo_pagina); ?> — Sistema Acadêmico</title>
  <link rel="stylesheet" href="estilo.css">
</head>
<body>

<header class="topbar">
  <a href="index.php" class="topbar-brand">
    <div class="logo-icon">🎓</div>
    <div>
      <h1>Acadêmico</h1>
      <span>Sistema de Gestão</span>
    </div>
  </a>
  <nav class="topbar-nav">
    <a href="index.php"              class="<?php echo $pagina_atual==='home'       ? 'active':'' ?>">Início</a>
    <a href="alunos_lista.php"       class="<?php echo $pagina_atual==='alunos'     ? 'active':'' ?>">Alunos</a>
    <a href="professores_lista.php"  class="<?php echo $pagina_atual==='professores'? 'active':'' ?>">Professores</a>
    <a href="turmas_lista.php"       class="<?php echo $pagina_atual==='turmas'     ? 'active':'' ?>">Turmas</a>
    <a href="alunocadas.php"         class="<?php echo $pagina_atual==='cad_aluno'  ? 'active':'' ?>">+ Aluno</a>
    <a href="professorcadas.php"     class="<?php echo $pagina_atual==='cad_prof'   ? 'active':'' ?>">+ Professor</a>
    <a href="turmacadas.php"         class="<?php echo $pagina_atual==='cad_turma'  ? 'active':'' ?>">+ Turma</a>
  </nav>
</header>
