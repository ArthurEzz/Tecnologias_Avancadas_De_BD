<?php
$pagina_atual  = 'alunos';
$titulo_pagina = 'Consulta de Alunos';
include('./_header.php');
include('./conect.php');

$busca = isset($_GET['busca']) ? mysqli_real_escape_string($con, trim($_GET['busca'])) : '';

if ($busca !== '') {
  $query = "SELECT * FROM alunos WHERE ativo=1
            AND (nome LIKE '%$busca%' OR cpf LIKE '%$busca%' OR ra LIKE '%$busca%')
            ORDER BY nome";
} else {
  $query = "SELECT * FROM alunos WHERE ativo=1 ORDER BY nome";
}

$resultado = mysqli_query($con, $query);
$total     = mysqli_num_rows($resultado);
?>
<main class="page">

  <div class="page-header">
    <div>
      <h2>Alunos</h2>
      <p><?php echo $total ?> aluno(s) encontrado(s)</p>
    </div>
    <a href="alunocadas.php" class="btn btn-primary">+ Novo Aluno</a>
  </div>

  <!-- Barra de busca -->
  <form method="GET" action="alunos_lista.php" style="margin-bottom:24px;display:flex;gap:10px;">
    <input type="text" name="busca" value="<?php echo htmlspecialchars($busca) ?>"
           placeholder="Buscar por nome, CPF ou RA…"
           style="flex:1;padding:10px 14px;border:1.5px solid var(--border);border-radius:8px;
                  font-family:'DM Sans',sans-serif;font-size:.9rem;outline:none;">
    <button type="submit" class="btn btn-primary">🔍 Buscar</button>
    <?php if ($busca): ?>
    <a href="alunos_lista.php" class="btn btn-outline">✕ Limpar</a>
    <?php endif; ?>
  </form>

  <div class="table-card">
    <div class="table-toolbar">
      <h3>Lista de Alunos</h3>
      <span style="font-size:.82rem;color:var(--muted);"><?php echo $total ?> registro(s)</span>
    </div>

    <?php if ($total === 0): ?>
    <div class="empty-state">
      <div class="icon">🔍</div>
      <p>Nenhum aluno encontrado<?php echo $busca ? " para \"$busca\"" : '' ?>.</p>
    </div>
    <?php else: ?>
    <div style="overflow-x:auto;">
      <table class="data-table">
        <thead>
          <tr>
            <th>RA</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>E-mail</th>
            <th>Cidade / UF</th>
            <th>Status</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($a = mysqli_fetch_assoc($resultado)): ?>
          <tr>
            <td><strong><?php echo $a['ra'] ?></strong></td>
            <td><?php echo htmlspecialchars($a['nome']) ?></td>
            <td style="font-family:monospace;font-size:.85rem;"><?php echo $a['cpf'] ?></td>
            <td style="font-size:.85rem;"><?php echo htmlspecialchars($a['email']) ?></td>
            <td><?php echo htmlspecialchars($a['cidade']) ?><?php echo $a['uf'] ? ' / '.$a['uf'] : '' ?></td>
            <td><span class="badge badge-green">Ativo</span></td>
            <td>
              <a href="aluno_ficha.php?ra=<?php echo $a['ra'] ?>" class="btn btn-sm btn-primary">Ver ficha</a>
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
