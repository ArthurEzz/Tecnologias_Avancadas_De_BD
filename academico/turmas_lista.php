<?php
$pagina_atual  = 'turmas';
$titulo_pagina = 'Consulta de Turmas';
include('./_header.php');
include('./conect.php');

$busca = isset($_GET['busca']) ? mysqli_real_escape_string($con, trim($_GET['busca'])) : '';
$filtro_semestre = isset($_GET['semestre']) ? (int)$_GET['semestre'] : 0;
$filtro_ano      = isset($_GET['ano'])      ? (int)$_GET['ano']      : 0;

$where = "WHERE 1=1";
if ($busca !== '')    $where .= " AND (t.nometurma LIKE '%$busca%' OR d.nomedisciplina LIKE '%$busca%' OR p.nomeprofessor LIKE '%$busca%' OR c.nomecurso LIKE '%$busca%')";
if ($filtro_semestre) $where .= " AND t.semestre = $filtro_semestre";
if ($filtro_ano)      $where .= " AND t.ano = $filtro_ano";

$query = "SELECT t.idturma, t.nometurma, t.semestre, t.ano,
                 d.nomedisciplina, c.nomecurso, p.nomeprofessor,
                 COUNT(it.ra) AS total_alunos
          FROM turma t
          JOIN disciplina d ON d.iddisciplina = t.iddisciplina
          JOIN cursos c     ON c.idcurso = d.idcurso
          JOIN professor p  ON p.idprofessor = d.idprofessor
          LEFT JOIN itemturma it ON it.idturma = t.idturma
          $where
          GROUP BY t.idturma
          ORDER BY t.ano DESC, t.semestre DESC, t.nometurma";

$resultado = mysqli_query($con, $query);
$total     = mysqli_num_rows($resultado);

// Anos disponíveis para filtro
$anos_res = mysqli_query($con, "SELECT DISTINCT ano FROM turma ORDER BY ano DESC");
?>
<main class="page">

  <div class="page-header">
    <div>
      <h2>Turmas</h2>
      <p><?php echo $total ?> turma(s) encontrada(s)</p>
    </div>
    <a href="turmacadas.php" class="btn btn-primary">+ Nova Turma</a>
  </div>

  <!-- Filtros -->
  <form method="GET" action="turmas_lista.php" style="margin-bottom:24px;display:flex;gap:10px;flex-wrap:wrap;">
    <input type="text" name="busca" value="<?php echo htmlspecialchars($busca) ?>"
           placeholder="Buscar por turma, disciplina, professor ou curso…"
           style="flex:1;min-width:200px;padding:10px 14px;border:1.5px solid var(--border);border-radius:8px;
                  font-family:'DM Sans',sans-serif;font-size:.9rem;outline:none;">

    <select name="semestre"
            style="padding:10px 14px;border:1.5px solid var(--border);border-radius:8px;
                   font-family:'DM Sans',sans-serif;font-size:.9rem;outline:none;background:#fff;">
      <option value="0">Todos os semestres</option>
      <option value="1" <?php echo $filtro_semestre===1 ? 'selected':'' ?>>1º Semestre</option>
      <option value="2" <?php echo $filtro_semestre===2 ? 'selected':'' ?>>2º Semestre</option>
    </select>

    <select name="ano"
            style="padding:10px 14px;border:1.5px solid var(--border);border-radius:8px;
                   font-family:'DM Sans',sans-serif;font-size:.9rem;outline:none;background:#fff;">
      <option value="0">Todos os anos</option>
      <?php while ($a = mysqli_fetch_assoc($anos_res)): ?>
      <option value="<?php echo $a['ano'] ?>" <?php echo $filtro_ano===$a['ano'] ? 'selected':'' ?>>
        <?php echo $a['ano'] ?>
      </option>
      <?php endwhile; ?>
    </select>

    <button type="submit" class="btn btn-primary">🔍 Buscar</button>
    <?php if ($busca || $filtro_semestre || $filtro_ano): ?>
    <a href="turmas_lista.php" class="btn btn-outline">✕ Limpar</a>
    <?php endif; ?>
  </form>

  <div class="table-card">
    <div class="table-toolbar">
      <h3>Lista de Turmas</h3>
      <span style="font-size:.82rem;color:var(--muted);"><?php echo $total ?> registro(s)</span>
    </div>

    <?php if ($total === 0): ?>
    <div class="empty-state">
      <div class="icon">🔍</div>
      <p>Nenhuma turma encontrada<?php echo $busca ? " para \"$busca\"" : '' ?>.</p>
    </div>
    <?php else: ?>
    <div style="overflow-x:auto;">
      <table class="data-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Turma</th>
            <th>Disciplina</th>
            <th>Curso</th>
            <th>Professor</th>
            <th>Período</th>
            <th>Alunos</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($t = mysqli_fetch_assoc($resultado)): ?>
          <tr>
            <td><strong><?php echo $t['idturma'] ?></strong></td>
            <td><?php echo htmlspecialchars($t['nometurma']) ?></td>
            <td style="font-size:.85rem;"><?php echo htmlspecialchars($t['nomedisciplina']) ?></td>
            <td style="font-size:.85rem;"><?php echo htmlspecialchars($t['nomecurso']) ?></td>
            <td style="font-size:.85rem;"><?php echo htmlspecialchars($t['nomeprofessor']) ?></td>
            <td>
              <span class="badge badge-blue"><?php echo $t['semestre'] ?>º/<?php echo $t['ano'] ?></span>
            </td>
            <td style="text-align:center;">
              <span class="badge <?php echo $t['total_alunos']>0 ? 'badge-green' : 'badge-red' ?>">
                <?php echo $t['total_alunos'] ?>
              </span>
            </td>
            <td>
              <a href="turma_ficha.php?id=<?php echo $t['idturma'] ?>" class="btn btn-sm btn-primary">Ver ficha</a>
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
