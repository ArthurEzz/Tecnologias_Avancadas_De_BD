<?php
$pagina_atual  = 'busca';
$titulo_pagina = 'Busca Avançada';
include('./_header.php');
include('./conect.php');

/* ──────────────────────────────────────────────
   Coleta dos filtros vindos via GET
   ────────────────────────────────────────────── */
$tipo            = isset($_GET['tipo'])        ? $_GET['tipo']              : '';   // 'aluno' | 'professor'
$busca_nome      = isset($_GET['nome'])        ? trim($_GET['nome'])        : '';
$filtro_ano      = isset($_GET['ano'])         ? (int)$_GET['ano']          : 0;
$filtro_semestre = isset($_GET['semestre'])    ? (int)$_GET['semestre']     : 0;
$filtro_disc     = isset($_GET['iddisciplina'])? (int)$_GET['iddisciplina'] : 0;
$filtro_turma    = isset($_GET['idturma'])     ? (int)$_GET['idturma']      : 0;

$pesquisou = isset($_GET['tipo']); // usuário já submeteu o form?

/* ──────────────────────────────────────────────
   Dados para popular os selects de filtro
   ────────────────────────────────────────────── */
$anos_res = mysqli_query($con, "SELECT DISTINCT ano FROM turma ORDER BY ano DESC");
$anos = [];
while ($r = mysqli_fetch_assoc($anos_res)) $anos[] = $r['ano'];

$discs_res = mysqli_query($con,
    "SELECT d.iddisciplina, d.nomedisciplina, c.nomecurso
     FROM disciplina d JOIN cursos c ON c.idcurso = d.idcurso
     ORDER BY d.nomedisciplina"
);
$disciplinas = [];
while ($r = mysqli_fetch_assoc($discs_res)) $disciplinas[] = $r;

$turmas_res = mysqli_query($con,
    "SELECT t.idturma, t.nometurma, t.semestre, t.ano, d.nomedisciplina
     FROM turma t JOIN disciplina d ON d.iddisciplina = t.iddisciplina
     ORDER BY t.ano DESC, t.semestre DESC, t.nometurma"
);
$turmas = [];
while ($r = mysqli_fetch_assoc($turmas_res)) $turmas[] = $r;

/* ──────────────────────────────────────────────
   Execução das queries de resultado
   ────────────────────────────────────────────── */
$resultado_alunos    = [];
$resultado_professores = [];

if ($pesquisou) {

    /* ======= BUSCA DE ALUNOS ======= */
    if ($tipo === 'aluno' || $tipo === '') {

        $nome_esc = mysqli_real_escape_string($con, $busca_nome);

        $where_a  = "WHERE a.ativo = 1";

        if ($busca_nome !== '')
            $where_a .= " AND (a.nome LIKE '%$nome_esc%' OR a.cpf LIKE '%$nome_esc%' OR a.ra LIKE '%$nome_esc%')";

        // Filtros que exigem JOIN com itemturma / turma
        $need_join = ($filtro_ano || $filtro_semestre || $filtro_disc || $filtro_turma);

        if ($need_join) {
            $join_a = "JOIN itemturma it ON it.ra = a.ra
                       JOIN turma t      ON t.idturma = it.idturma
                       JOIN disciplina d ON d.iddisciplina = t.iddisciplina";

            if ($filtro_turma)    $where_a .= " AND t.idturma = $filtro_turma";
            if ($filtro_disc)     $where_a .= " AND d.iddisciplina = $filtro_disc";
            if ($filtro_ano)      $where_a .= " AND t.ano = $filtro_ano";
            if ($filtro_semestre) $where_a .= " AND t.semestre = $filtro_semestre";

            $sql_a = "SELECT DISTINCT a.ra, a.nome, a.email, a.cidade, a.uf,
                             GROUP_CONCAT(DISTINCT t.nometurma ORDER BY t.ano DESC SEPARATOR ' · ') AS turmas_nomes,
                             GROUP_CONCAT(DISTINCT CONCAT(t.semestre,'º/',t.ano) ORDER BY t.ano DESC SEPARATOR ' · ') AS periodos
                      FROM alunos a
                      $join_a
                      $where_a
                      GROUP BY a.ra
                      ORDER BY a.nome";
        } else {
            $sql_a = "SELECT a.ra, a.nome, a.email, a.cidade, a.uf,
                             NULL AS turmas_nomes, NULL AS periodos
                      FROM alunos a
                      $where_a
                      ORDER BY a.nome";
        }

        $res_a = mysqli_query($con, $sql_a);
        while ($r = mysqli_fetch_assoc($res_a)) $resultado_alunos[] = $r;
    }

    /* ======= BUSCA DE PROFESSORES ======= */
    if ($tipo === 'professor' || $tipo === '') {

        $nome_esc = mysqli_real_escape_string($con, $busca_nome);

        $where_p = "WHERE p.ativo = 1";

        if ($busca_nome !== '')
            $where_p .= " AND (p.nomeprofessor LIKE '%$nome_esc%' OR p.cpf LIKE '%$nome_esc%' OR p.especialidade LIKE '%$nome_esc%')";

        $need_join_p = ($filtro_ano || $filtro_semestre || $filtro_disc || $filtro_turma);

        if ($need_join_p) {
            $join_p = "JOIN disciplina d ON d.idprofessor = p.idprofessor
                       JOIN turma t      ON t.iddisciplina = d.iddisciplina";

            if ($filtro_turma)    $where_p .= " AND t.idturma = $filtro_turma";
            if ($filtro_disc)     $where_p .= " AND d.iddisciplina = $filtro_disc";
            if ($filtro_ano)      $where_p .= " AND t.ano = $filtro_ano";
            if ($filtro_semestre) $where_p .= " AND t.semestre = $filtro_semestre";

            $sql_p = "SELECT DISTINCT p.idprofessor, p.nomeprofessor, p.email, p.titulacao, p.especialidade,
                             GROUP_CONCAT(DISTINCT d.nomedisciplina ORDER BY d.nomedisciplina SEPARATOR ' · ') AS disciplinas_nomes,
                             GROUP_CONCAT(DISTINCT t.nometurma      ORDER BY t.nometurma      SEPARATOR ' · ') AS turmas_nomes,
                             GROUP_CONCAT(DISTINCT CONCAT(t.semestre,'º/',t.ano) ORDER BY t.ano DESC SEPARATOR ' · ') AS periodos
                      FROM professor p
                      $join_p
                      $where_p
                      GROUP BY p.idprofessor
                      ORDER BY p.nomeprofessor";
        } else {
            // Sem filtros de turma: ainda traz disciplinas/turmas vinculadas
            $sql_p = "SELECT p.idprofessor, p.nomeprofessor, p.email, p.titulacao, p.especialidade,
                             GROUP_CONCAT(DISTINCT d.nomedisciplina ORDER BY d.nomedisciplina SEPARATOR ' · ') AS disciplinas_nomes,
                             GROUP_CONCAT(DISTINCT t.nometurma      ORDER BY t.nometurma      SEPARATOR ' · ') AS turmas_nomes,
                             GROUP_CONCAT(DISTINCT CONCAT(t.semestre,'º/',t.ano) ORDER BY t.ano DESC SEPARATOR ' · ') AS periodos
                      FROM professor p
                      LEFT JOIN disciplina d ON d.idprofessor = p.idprofessor
                      LEFT JOIN turma t      ON t.iddisciplina = d.iddisciplina
                      $where_p
                      GROUP BY p.idprofessor
                      ORDER BY p.nomeprofessor";
        }

        $res_p = mysqli_query($con, $sql_p);
        while ($r = mysqli_fetch_assoc($res_p)) $resultado_professores[] = $r;
    }
}

$total_alunos = count($resultado_alunos);
$total_profs  = count($resultado_professores);
$total_geral  = $total_alunos + $total_profs;
?>

<main class="page">

  <div class="page-header">
    <div>
      <h2>Busca Avançada</h2>
      <p>Filtre alunos e professores por período, disciplina e turma</p>
    </div>
  </div>

  <!-- ===================== PAINEL DE FILTROS ===================== -->
  <div class="form-card" style="max-width:100%;margin:0 0 32px;">
    <div class="form-card-header">🔍 Filtros de Pesquisa</div>
    <div class="form-card-body">
      <form method="GET" action="busca_avancada.php" id="formBusca">

        <!-- Linha 1: tipo + nome -->
        <div style="display:grid;grid-template-columns:200px 1fr;gap:16px;margin-bottom:16px;">

          <div class="form-group" style="margin-bottom:0;">
            <label>Buscar por</label>
            <select name="tipo" id="selectTipo" onchange="atualizarLabel()">
              <option value=""   <?php echo $tipo===''          ? 'selected':'' ?>>Todos</option>
              <option value="aluno"     <?php echo $tipo==='aluno'     ? 'selected':'' ?>>👨‍🎓 Alunos</option>
              <option value="professor" <?php echo $tipo==='professor' ? 'selected':'' ?>>👨‍🏫 Professores</option>
            </select>
          </div>

          <div class="form-group" style="margin-bottom:0;">
            <label id="labelNome">Nome / CPF / RA ou Especialidade</label>
            <input type="text" name="nome"
                   value="<?php echo htmlspecialchars($busca_nome) ?>"
                   placeholder="Digite para filtrar…">
          </div>
        </div>

        <!-- Linha 2: filtros contextuais -->
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:16px;margin-bottom:20px;">

          <div class="form-group" style="margin-bottom:0;">
            <label>Ano</label>
            <select name="ano">
              <option value="0">Todos os anos</option>
              <?php foreach ($anos as $a): ?>
              <option value="<?php echo $a ?>" <?php echo $filtro_ano===$a ? 'selected':'' ?>>
                <?php echo $a ?>
              </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group" style="margin-bottom:0;">
            <label>Semestre</label>
            <select name="semestre">
              <option value="0">Todos</option>
              <option value="1" <?php echo $filtro_semestre===1 ? 'selected':'' ?>>1º Semestre</option>
              <option value="2" <?php echo $filtro_semestre===2 ? 'selected':'' ?>>2º Semestre</option>
            </select>
          </div>

          <div class="form-group" style="margin-bottom:0;">
            <label>Disciplina</label>
            <select name="iddisciplina">
              <option value="0">Todas</option>
              <?php foreach ($disciplinas as $d): ?>
              <option value="<?php echo $d['iddisciplina'] ?>"
                      <?php echo $filtro_disc===$d['iddisciplina'] ? 'selected':'' ?>>
                <?php echo htmlspecialchars($d['nomedisciplina']) ?>
              </option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group" style="margin-bottom:0;">
            <label>Turma</label>
            <select name="idturma">
              <option value="0">Todas</option>
              <?php foreach ($turmas as $t): ?>
              <option value="<?php echo $t['idturma'] ?>"
                      <?php echo $filtro_turma===$t['idturma'] ? 'selected':'' ?>>
                <?php echo htmlspecialchars($t['nometurma']) ?>
                (<?php echo $t['semestre'] ?>º/<?php echo $t['ano'] ?>)
              </option>
              <?php endforeach; ?>
            </select>
          </div>

        </div>

        <!-- Ações -->
        <div style="display:flex;gap:10px;padding-top:16px;border-top:1px solid var(--border);">
          <button type="submit" class="btn btn-primary">🔍 Pesquisar</button>
          <a href="busca_avancada.php" class="btn btn-outline">✕ Limpar filtros</a>

          <?php if ($pesquisou && $total_geral > 0): ?>
          <span style="margin-left:auto;font-size:.85rem;color:var(--muted);align-self:center;">
            <?php echo $total_geral ?> resultado(s) encontrado(s)
          </span>
          <?php endif; ?>
        </div>

      </form>
    </div>
  </div>

  <!-- ===================== TAGS DE FILTROS ATIVOS ===================== -->
  <?php if ($pesquisou): ?>
  <?php
    $tags = [];
    if ($tipo === 'aluno')     $tags[] = ['👨‍🎓', 'Alunos'];
    if ($tipo === 'professor') $tags[] = ['👨‍🏫', 'Professores'];
    if ($busca_nome !== '')    $tags[] = ['🔤', '"'.htmlspecialchars($busca_nome).'"'];
    if ($filtro_ano)           $tags[] = ['📅', "Ano: $filtro_ano"];
    if ($filtro_semestre)      $tags[] = ['📆', $filtro_semestre.'º Semestre'];
    if ($filtro_disc) {
        foreach ($disciplinas as $d)
            if ($d['iddisciplina'] === $filtro_disc)
                $tags[] = ['📚', htmlspecialchars($d['nomedisciplina'])];
    }
    if ($filtro_turma) {
        foreach ($turmas as $t)
            if ($t['idturma'] === $filtro_turma)
                $tags[] = ['🏫', htmlspecialchars($t['nometurma'])];
    }
  ?>
  <?php if (!empty($tags)): ?>
  <div style="display:flex;flex-wrap:wrap;gap:8px;margin-bottom:24px;align-items:center;">
    <span style="font-size:.8rem;color:var(--muted);font-weight:600;text-transform:uppercase;letter-spacing:.05em;">Filtros:</span>
    <?php foreach ($tags as $tag): ?>
    <span style="background:var(--navy);color:#fff;border-radius:20px;padding:4px 12px;font-size:.78rem;font-weight:600;">
      <?php echo $tag[0] ?> <?php echo $tag[1] ?>
    </span>
    <?php endforeach; ?>
  </div>
  <?php endif; ?>

  <!-- ===================== SEM RESULTADOS ===================== -->
  <?php if ($total_geral === 0): ?>
  <div class="empty-state" style="background:var(--card);border:1px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow);">
    <div class="icon">🔍</div>
    <p>Nenhum resultado encontrado para os filtros selecionados.</p>
    <a href="busca_avancada.php" class="btn btn-outline" style="margin-top:16px;">Limpar filtros</a>
  </div>

  <?php else: ?>

  <!-- ===================== RESULTADOS: ALUNOS ===================== -->
  <?php if ($total_alunos > 0): ?>
  <div class="table-card" style="margin-bottom:28px;">
    <div class="table-toolbar">
      <h3>👨‍🎓 Alunos</h3>
      <span class="badge badge-green"><?php echo $total_alunos ?> encontrado(s)</span>
    </div>
    <div style="overflow-x:auto;">
      <table class="data-table">
        <thead>
          <tr>
            <th>RA</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Cidade / UF</th>
            <th>Turma(s)</th>
            <th>Período(s)</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($resultado_alunos as $a): ?>
          <tr>
            <td><strong><?php echo $a['ra'] ?></strong></td>
            <td><?php echo htmlspecialchars($a['nome']) ?></td>
            <td style="font-size:.83rem;"><?php echo htmlspecialchars($a['email']) ?></td>
            <td><?php echo htmlspecialchars($a['cidade']) ?><?php echo $a['uf'] ? ' / '.$a['uf'] : '' ?></td>
            <td style="font-size:.82rem;color:var(--muted);">
              <?php echo $a['turmas_nomes'] ? htmlspecialchars($a['turmas_nomes']) : '—' ?>
            </td>
            <td>
              <?php if ($a['periodos']): ?>
              <?php foreach (explode(' · ', $a['periodos']) as $per): ?>
              <span class="badge badge-blue" style="margin:1px;"><?php echo $per ?></span>
              <?php endforeach; ?>
              <?php else: echo '—'; endif; ?>
            </td>
            <td>
              <a href="aluno_ficha.php?ra=<?php echo $a['ra'] ?>" class="btn btn-sm btn-primary">Ver ficha</a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php endif; ?>

  <!-- ===================== RESULTADOS: PROFESSORES ===================== -->
  <?php if ($total_profs > 0): ?>
  <div class="table-card">
    <div class="table-toolbar">
      <h3>👨‍🏫 Professores</h3>
      <span class="badge badge-blue"><?php echo $total_profs ?> encontrado(s)</span>
    </div>
    <div style="overflow-x:auto;">
      <table class="data-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Titulação</th>
            <th>Especialidade</th>
            <th>Disciplina(s)</th>
            <th>Turma(s)</th>
            <th>Período(s)</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($resultado_professores as $p): ?>
          <tr>
            <td><strong><?php echo $p['idprofessor'] ?></strong></td>
            <td><?php echo htmlspecialchars($p['nomeprofessor']) ?></td>
            <td>
              <?php if ($p['titulacao']): ?>
              <span class="badge badge-blue"><?php echo htmlspecialchars($p['titulacao']) ?></span>
              <?php else: echo '—'; endif; ?>
            </td>
            <td style="font-size:.83rem;"><?php echo htmlspecialchars($p['especialidade']) ?: '—' ?></td>
            <td style="font-size:.82rem;color:var(--muted);">
              <?php echo $p['disciplinas_nomes'] ? htmlspecialchars($p['disciplinas_nomes']) : '—' ?>
            </td>
            <td style="font-size:.82rem;color:var(--muted);">
              <?php echo $p['turmas_nomes'] ? htmlspecialchars($p['turmas_nomes']) : '—' ?>
            </td>
            <td>
              <?php if ($p['periodos']): ?>
              <?php foreach (array_unique(explode(' · ', $p['periodos'])) as $per): ?>
              <span class="badge badge-blue" style="margin:1px;"><?php echo $per ?></span>
              <?php endforeach; ?>
              <?php else: echo '—'; endif; ?>
            </td>
            <td>
              <a href="professor_ficha.php?id=<?php echo $p['idprofessor'] ?>" class="btn btn-sm btn-primary">Ver ficha</a>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php endif; ?>

  <?php endif; // fim: tem resultados ?>
  <?php endif; // fim: pesquisou ?>

  <!-- Estado inicial — antes de pesquisar -->
  <?php if (!$pesquisou): ?>
  <div class="empty-state" style="background:var(--card);border:1px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow);">
    <div class="icon">🎓</div>
    <p>Use os filtros acima e clique em <strong>Pesquisar</strong> para ver os resultados.</p>
  </div>
  <?php endif; ?>

</main>

<script>
/* Atualiza label e placeholder do campo nome conforme o tipo selecionado */
function atualizarLabel() {
  const tipo  = document.getElementById('selectTipo').value;
  const label = document.getElementById('labelNome');
  const input = label.closest('.form-group').querySelector('input');

  if (tipo === 'aluno') {
    label.textContent = 'Nome / CPF / RA';
    input.placeholder = 'Ex.: João Silva · 123.456.789-00 · 1042';
  } else if (tipo === 'professor') {
    label.textContent = 'Nome / CPF / Especialidade';
    input.placeholder = 'Ex.: Ana Souza · Banco de Dados';
  } else {
    label.textContent = 'Nome / CPF / RA ou Especialidade';
    input.placeholder = 'Digite para filtrar…';
  }
}
// Aplica na carga da página para manter estado após submit
atualizarLabel();
</script>

</body>
</html>
