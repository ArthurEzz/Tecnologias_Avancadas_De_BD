<?php
$pagina_atual  = 'professores';
$titulo_pagina = 'Consulta de Professores';
include('./_header.php');
include('./conect.php');

$busca = isset($_GET['busca']) ? mysqli_real_escape_string($con, trim($_GET['busca'])) : '';

if ($busca !== '') {
  $query = "SELECT * FROM professor WHERE ativo=1
            AND (nomeprofessor LIKE '%$busca%' OR cpf LIKE '%$busca%' OR especialidade LIKE '%$busca%')
            ORDER BY nomeprofessor";
} else {
  $query = "SELECT * FROM professor WHERE ativo=1 ORDER BY nomeprofessor";
}

$resultado = mysqli_query($con, $query);
$total     = mysqli_num_rows($resultado);
?>
<main class="page">

  <div class="page-header">
    <div>
      <h2>Professores</h2>
      <p><?php echo $total ?> professor(es) encontrado(s)</p>
    </div>
    <a href="professorcadas.php" class="btn btn-primary">+ Novo Professor</a>
  </div>

  <!-- Barra de busca -->
  <form method="GET" action="professores_lista.php" style="margin-bottom:24px;display:flex;gap:10px;">
    <input type="text" name="busca" value="<?php echo htmlspecialchars($busca) ?>"
           placeholder="Buscar por nome, CPF ou especialidade…"
           style="flex:1;padding:10px 14px;border:1.5px solid var(--border);border-radius:8px;
                  font-family:'DM Sans',sans-serif;font-size:.9rem;outline:none;">
    <button type="submit" class="btn btn-primary">🔍 Buscar</button>
    <?php if ($busca): ?>
    <a href="professores_lista.php" class="btn btn-outline">✕ Limpar</a>
    <?php endif; ?>
  </form>

  <div class="table-card">
    <div class="table-toolbar">
      <h3>Lista de Professores</h3>
      <span style="font-size:.82rem;color:var(--muted);"><?php echo $total ?> registro(s)</span>
    </div>

    <?php if ($total === 0): ?>
    <div class="empty-state">
      <div class="icon">🔍</div>
      <p>Nenhum professor encontrado<?php echo $busca ? " para \"$busca\"" : '' ?>.</p>
    </div>
    <?php else: ?>
    <div style="overflow-x:auto;">
      <table class="data-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Titulação</th>
            <th>Especialidade</th>
            <th>E-mail</th>
            <th>Admissão</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($p = mysqli_fetch_assoc($resultado)): ?>
          <tr>
            <td><strong><?php echo $p['idprofessor'] ?></strong></td>
            <td><?php echo htmlspecialchars($p['nomeprofessor']) ?></td>
            <td>
              <?php if ($p['titulacao']): ?>
              <span class="badge badge-blue"><?php echo htmlspecialchars($p['titulacao']) ?></span>
              <?php else: echo '—'; endif; ?>
            </td>
            <td style="font-size:.85rem;"><?php echo htmlspecialchars($p['especialidade']) ?: '—' ?></td>
            <td style="font-size:.85rem;"><?php echo htmlspecialchars($p['email']) ?></td>
            <td style="font-size:.85rem;"><?php echo $p['data_admissao'] ? date('d/m/Y', strtotime($p['data_admissao'])) : '—' ?></td>
            <td>
              <a href="professor_ficha.php?id=<?php echo $p['idprofessor'] ?>" class="btn btn-sm btn-primary">Ver ficha</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
    <?php endif; ?>
  </div>

</main>
</body>
</html>
