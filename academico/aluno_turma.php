<?php
$pagina_atual  = 'alunos';
$titulo_pagina = 'Gerenciar Turmas do Aluno';
include('./_header.php');
include('./conect.php');

$ra = isset($_GET['ra']) ? (int)$_GET['ra'] : 0;

if ($ra <= 0) {
    header("Location: alunos_lista.php");
    exit;
}

// Busca dados do aluno
$q_aluno = mysqli_query($con, "SELECT ra, nome, cpf FROM alunos WHERE ra = $ra AND ativo = 1");
$aluno   = mysqli_fetch_assoc($q_aluno);

if (!$aluno) {
    header("Location: alunos_lista.php");
    exit;
}

$msg_ok  = '';
$msg_err = '';

/* ============================================================
   Processa ações POST
   ============================================================ */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';

    /* ------ Adicionar nova turma ------ */
    if ($acao === 'adicionar') {
        $idturma = (int)$_POST['idturma_nova'];
        if ($idturma > 0) {
            $ins = mysqli_query($con,
                "INSERT IGNORE INTO itemturma (ra, idturma) VALUES ($ra, $idturma)"
            );
            if ($ins && mysqli_affected_rows($con) > 0)
                $msg_ok  = '✅ Aluno matriculado na turma com sucesso!';
            elseif ($ins)
                $msg_err = '⚠️ O aluno já está matriculado nessa turma.';
            else
                $msg_err = '❌ Erro ao matricular: ' . mysqli_error($con);
        } else {
            $msg_err = '⚠️ Selecione uma turma válida.';
        }
    }

    /* ------ Trocar turma ------ */
    if ($acao === 'trocar') {
        $idturma_antiga = (int)$_POST['idturma_antiga'];
        $idturma_nova   = (int)$_POST['idturma_nova_troca'];
        if ($idturma_antiga > 0 && $idturma_nova > 0) {
            if ($idturma_antiga === $idturma_nova) {
                $msg_err = '⚠️ A turma de destino é igual à turma atual.';
            } else {
                // Verifica se já está na turma de destino
                $chk = mysqli_fetch_row(mysqli_query($con,
                    "SELECT COUNT(*) FROM itemturma WHERE ra=$ra AND idturma=$idturma_nova"
                ));
                if ($chk[0] > 0) {
                    $msg_err = '⚠️ O aluno já está matriculado na turma de destino.';
                } else {
                    $upd = mysqli_query($con,
                        "UPDATE itemturma SET idturma=$idturma_nova
                         WHERE ra=$ra AND idturma=$idturma_antiga"
                    );
                    if ($upd && mysqli_affected_rows($con) > 0)
                        $msg_ok  = '✅ Turma trocada com sucesso!';
                    else
                        $msg_err = '❌ Erro ao trocar turma: ' . mysqli_error($con);
                }
            }
        } else {
            $msg_err = '⚠️ Selecione as turmas de origem e destino.';
        }
    }

    /* ------ Remover matrícula ------ */
    if ($acao === 'remover') {
        $idturma = (int)$_POST['idturma_remover'];
        if ($idturma > 0) {
            $del = mysqli_query($con,
                "DELETE FROM itemturma WHERE ra=$ra AND idturma=$idturma"
            );
            if ($del && mysqli_affected_rows($con) > 0)
                $msg_ok  = '✅ Matrícula removida com sucesso!';
            else
                $msg_err = '❌ Erro ao remover matrícula: ' . mysqli_error($con);
        }
    }
}

/* ============================================================
   Dados atualizados após possíveis alterações
   ============================================================ */

// Turmas em que o aluno JÁ está matriculado
$q_minhas = mysqli_query($con,
    "SELECT t.idturma, t.nometurma, t.semestre, t.ano,
            d.nomedisciplina, c.nomecurso, p.nomeprofessor
     FROM itemturma it
     JOIN turma t      ON t.idturma = it.idturma
     JOIN disciplina d ON d.iddisciplina = t.iddisciplina
     JOIN cursos c     ON c.idcurso = d.idcurso
     JOIN professor p  ON p.idprofessor = d.idprofessor
     WHERE it.ra = $ra
     ORDER BY t.ano DESC, t.semestre DESC, t.nometurma"
);
$minhas_turmas = [];
while ($r = mysqli_fetch_assoc($q_minhas)) $minhas_turmas[] = $r;
$ids_matriculado = array_column($minhas_turmas, 'idturma');

// Todas as turmas disponíveis (para o select de adicionar)
$q_todas = mysqli_query($con,
    "SELECT t.idturma, t.nometurma, t.semestre, t.ano,
            d.nomedisciplina, c.nomecurso
     FROM turma t
     JOIN disciplina d ON d.iddisciplina = t.iddisciplina
     JOIN cursos c     ON c.idcurso = d.idcurso
     ORDER BY t.ano DESC, t.semestre DESC, t.nometurma"
);
$todas_turmas = [];
while ($r = mysqli_fetch_assoc($q_todas)) $todas_turmas[] = $r;

// Turmas disponíveis = todas MENOS as que já está matriculado
$turmas_disponiveis = array_filter($todas_turmas,
    fn($t) => !in_array($t['idturma'], $ids_matriculado)
);
?>

<main class="page">

  <div class="page-header">
    <div>
      <h2>Gerenciar Turmas</h2>
      <p>Matrícula, troca e remoção de turmas do aluno</p>
    </div>
    <a href="aluno_ficha.php?ra=<?php echo $ra ?>" class="btn btn-outline">← Voltar à ficha</a>
  </div>

  <!-- Cabeçalho do aluno -->
  <div style="background:var(--card);border:1px solid var(--border);border-radius:var(--radius);
              padding:20px 28px;margin-bottom:28px;display:flex;align-items:center;gap:18px;
              box-shadow:var(--shadow);">
    <div style="font-size:2.2rem;width:56px;height:56px;background:linear-gradient(135deg,var(--navy),var(--teal));
                border-radius:50%;display:grid;place-items:center;flex-shrink:0;">👨‍🎓</div>
    <div>
      <div style="font-family:'Playfair Display',serif;font-size:1.3rem;color:var(--navy);font-weight:700;">
        <?php echo htmlspecialchars($aluno['nome']) ?>
      </div>
      <div style="font-size:.87rem;color:var(--muted);margin-top:2px;">
        RA: <strong><?php echo $aluno['ra'] ?></strong> &nbsp;|&nbsp; CPF: <?php echo $aluno['cpf'] ?>
      </div>
    </div>
  </div>

  <!-- Mensagens de feedback -->
  <?php if ($msg_ok):  ?><div class="alert alert-success"><?php echo $msg_ok ?></div><?php endif; ?>
  <?php if ($msg_err): ?><div class="alert alert-error"><?php echo $msg_err ?></div><?php endif; ?>

  <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;align-items:start;">

    <!-- ===================== COLUNA ESQUERDA ===================== -->
    <div style="display:flex;flex-direction:column;gap:24px;">

      <!-- Adicionar nova turma -->
      <div class="form-card" style="max-width:100%;margin:0;">
        <div class="form-card-header">➕ Adicionar Turma</div>
        <div class="form-card-body">
          <?php if (empty($turmas_disponiveis)): ?>
            <p style="color:var(--muted);font-size:.9rem;">O aluno já está matriculado em todas as turmas disponíveis.</p>
          <?php else: ?>
          <form method="POST">
            <input type="hidden" name="acao" value="adicionar">
            <div class="form-group" style="margin-bottom:16px;">
              <label>Selecione a Turma</label>
              <select name="idturma_nova" required>
                <option value="">— escolha uma turma —</option>
                <?php foreach ($turmas_disponiveis as $t): ?>
                <option value="<?php echo $t['idturma'] ?>">
                  <?php echo htmlspecialchars($t['nometurma']) ?>
                  — <?php echo $t['semestre'] ?>º/<?php echo $t['ano'] ?>
                  (<?php echo htmlspecialchars($t['nomedisciplina']) ?>)
                </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div style="text-align:right;">
              <button type="submit" class="btn btn-primary">Matricular</button>
            </div>
          </form>
          <?php endif; ?>
        </div>
      </div>

      <!-- Trocar de turma -->
      <div class="form-card" style="max-width:100%;margin:0;">
        <div class="form-card-header">🔄 Trocar de Turma</div>
        <div class="form-card-body">
          <?php if (empty($minhas_turmas)): ?>
            <p style="color:var(--muted);font-size:.9rem;">O aluno não possui nenhuma matrícula para trocar.</p>
          <?php elseif (empty($turmas_disponiveis)): ?>
            <p style="color:var(--muted);font-size:.9rem;">Não há outras turmas disponíveis como destino.</p>
          <?php else: ?>
          <form method="POST">
            <input type="hidden" name="acao" value="trocar">
            <div class="form-group" style="margin-bottom:16px;">
              <label>Turma Atual (origem)</label>
              <select name="idturma_antiga" required>
                <option value="">— turma a sair —</option>
                <?php foreach ($minhas_turmas as $t): ?>
                <option value="<?php echo $t['idturma'] ?>">
                  <?php echo htmlspecialchars($t['nometurma'] ) ?>
                  — <?php echo $t['semestre'] ?>º/<?php echo $t['ano'] ?>
                </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="form-group" style="margin-bottom:16px;">
              <label>Nova Turma (destino)</label>
              <select name="idturma_nova_troca" required>
                <option value="">— turma de destino —</option>
                <?php foreach ($turmas_disponiveis as $t): ?>
                <option value="<?php echo $t['idturma'] ?>">
                  <?php echo htmlspecialchars($t['nometurma']) ?>
                  — <?php echo $t['semestre'] ?>º/<?php echo $t['ano'] ?>
                  (<?php echo htmlspecialchars($t['nomedisciplina']) ?>)
                </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div style="text-align:right;">
              <button type="submit" class="btn btn-gold"
                      onclick="return confirm('Confirma a troca de turma?')">
                Trocar Turma
              </button>
            </div>
          </form>
          <?php endif; ?>
        </div>
      </div>

    </div><!-- /coluna esquerda -->

    <!-- ===================== COLUNA DIREITA ===================== -->
    <div>
      <div class="table-card">
        <div class="table-toolbar">
          <h3>Turmas Matriculadas</h3>
          <span style="font-size:.82rem;color:var(--muted);">
            <?php echo count($minhas_turmas) ?> turma(s)
          </span>
        </div>

        <?php if (empty($minhas_turmas)): ?>
        <div class="empty-state" style="padding:40px 20px;">
          <div class="icon">📭</div>
          <p>Nenhuma turma matriculada.</p>
        </div>
        <?php else: ?>
        <table class="data-table">
          <thead>
            <tr>
              <th>Turma</th>
              <th>Disciplina</th>
              <th>Período</th>
              <th>Remover</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($minhas_turmas as $t): ?>
            <tr>
              <td>
                <a href="turma_ficha.php?id=<?php echo $t['idturma'] ?>"
                   style="color:var(--teal);text-decoration:none;font-weight:600;">
                  <?php echo htmlspecialchars($t['nometurma']) ?>
                </a>
              </td>
              <td style="font-size:.83rem;color:var(--muted);">
                <?php echo htmlspecialchars($t['nomedisciplina']) ?>
              </td>
              <td>
                <span class="badge badge-blue">
                  <?php echo $t['semestre'] ?>º/<?php echo $t['ano'] ?>
                </span>
              </td>
              <td>
                <form method="POST" style="display:inline;">
                  <input type="hidden" name="acao" value="remover">
                  <input type="hidden" name="idturma_remover" value="<?php echo $t['idturma'] ?>">
                  <button type="submit" class="btn btn-sm btn-danger"
                          onclick="return confirm('Remover matrícula de \'<?php echo addslashes($t['nometurma']) ?>\'?')">
                    ✕
                  </button>
                </form>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <?php endif; ?>
      </div>
    </div><!-- /coluna direita -->

  </div><!-- /grid -->

</main>
</body>
</html>
