p
// result.php
require_once 'db.php';
 
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
  echo "Invalid result id.";
  exit;
}
$stmt = $mysqli->prepare("SELECT name, email, score, max_score, answers, created_at FROM eq_results WHERE id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows === 0) {
  echo "Result not found.";
  exit;
}
$row = $res->fetch_assoc();
$name = $row['name'] ? htmlspecialchars($row['name']) : 'Guest';
$score = (int)$row['score'];
$max = (int)$row['max_score'];
$answers = json_decode($row['answers'], true);
$created_at = $row['created_at'];
$stmt->close();
 
// derive high-level feedback
$percent = round(($score / max(1,$max)) * 100);
$summary="";
if ($percent >= 80) {
  $summary = "Excellent EQ — you show strong awareness and emotional skills.";
} elseif ($percent >= 60) {
  $summary = "Good EQ — you have several strengths and a few places to improve.";
} elseif ($percent >= 40) {
  $summary = "Moderate EQ — you can build on emotional awareness and regulation.";
} else {
  $summary = "Lower EQ — focusing on self-awareness and healthy coping strategies will help.";
}
 
// Suggest tips (simple tailored tips based on average answers)
$avg = $score / max(1, count($answers));
$tips = [];
if ($avg >= 4.2) {
  $tips[] = "Keep practicing active listening and maintain your current emotional habits.";
} elseif ($avg >= 3.2) {
  $tips[] = "Try journaling emotions weekly to boost self-awareness.";
  $tips[] = "Practice mindful breathing when stressed to improve regulation.";
} elseif ($avg >= 2.2) {
  $tips[] = "Work on noticing your emotions; try naming them during the day.";
  $tips[] = "Learn short grounding techniques (5–10 minutes).";
} else {
  $tips[] = "Begin with simple check-ins — ask yourself 'What am I feeling?' several times daily.";
  $tips[] = "Try basic breathing exercises and reflect on small wins.";
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>EQ Test — Results</title>
  <style>
    :root{--bg:#071227;--card:#0b1422;--accent:#7c5cff;--muted:#9fb0c8}
    *{box-sizing:border-box;font-family:Inter,system-ui,Segoe UI,Roboto,Arial}
    body{margin:0;background:linear-gradient(180deg,#031021,#07122a);color:#eaf2ff;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px}
    .container{width:100%;max-width:920px;background:linear-gradient(180deg,rgba(255,255,255,0.02),rgba(255,255,255,0.01));padding:18px;border-radius:14px;border:1px solid rgba(255,255,255,0.03)}
    header{display:flex;justify-content:space-between;align-items:center}
    h1{margin:0;font-size:22px}
    .results{display:grid;grid-template-columns:1fr 320px;gap:18px;margin-top:18px}
    .card{background:linear-gradient(180deg, rgba(255,255,255,0.015), rgba(255,255,255,0.01));padding:16px;border-radius:12px}
    .scoreBox{display:flex;flex-direction:column;align-items:center;justify-content:center;padding:20px;border-radius:10px}
    .big{font-size:44px;font-weight:800}
    .subtitle{color:var(--muted);margin-top:8px}
    ul.tips{margin:10px 0 0;padding-left:18px;color:var(--muted)}
    .btn{display:inline-block;padding:10px 14px;border-radius:10px;border:none;font-weight:700;background:linear-gradient(90deg,var(--accent),#4f46e5);color:white;cursor:pointer;margin-top:12px}
    .meta{color:var(--muted);font-size:13px}
    @media(max-width:820px){.results{grid-template-columns:1fr;}}
  </style>
</head>
<body>
  <div class="container">
    <header>
      <div>
        <h1>Results for <?php echo $name; ?></h1>
        <div class="meta">Taken on <?php echo htmlspecialchars($created_at); ?> • ID: <?php echo $id; ?></div>
      </div>
      <div>
        <button class="btn" onclick="window.location.href='index.php'">Take again</button>
      </div>
    </header>
 
    <div class="results">
      <div class="card">
        <div style="display:flex;justify-content:space-between;align-items:center">
          <div>
            <div class="big"><?php echo $score; ?>/<?php echo $max; ?></div>
            <div class="subtitle"><?php echo $percent; ?>% — <?php echo $summary; ?></div>
          </div>
          <div style="text-align:center">
            <div style="font-size:14px;color:var(--muted)">Quick tips</div>
            <div style="margin-top:8px">
              <?php foreach($tips as $t): ?>
                <div style="background:rgba(255,255,255,0.02);padding:8px;border-radius:8px;margin-bottom:6px;color:var(--muted)"><?php echo htmlspecialchars($t); ?></div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
 
        <hr style="margin:14px 0;border:none;border-top:1px solid rgba(255,255,255,0.03)">
 
        <div>
          <h3 style="margin:0 0 8px">Detailed answers</h3>
          <ol>
            <?php
              foreach(json_decode($row['answers'], true) as $i => $val){
                $qtext = htmlspecialchars($i+1 . ". " . (isset($questions_text[$i]) ? $questions_text[$i] : "Question ".($i+1)));
                // For clarity, show the numeric answer and short label:
                $label = '-';
                if ($val === 1) $label = 'Never';
                elseif ($val === 2) $label = 'Rarely';
                elseif ($val === 3) $label = 'Sometimes';
                elseif ($val === 4) $label = 'Often';
                elseif ($val === 5) $label = 'Always';
                echo "<li style='margin:8px 0;color:var(--muted)'>Q".($i+1).": <strong>".$label."</strong> (".$val." pts)</li>";
              }
            ?>
          </ol>
        </div>
      </div>
 
      <div class="card">
        <h3 style="margin:0 0 8px">Personalized Growth Plan</h3>
        <p class="meta">The following steps are based on your score — try these practical actions over the next 2–4 weeks.</p>
        <ol style="margin-top:10px;color:var(--muted)">
          <li>Daily 5-minute emotion check-ins: name what you feel and why.</li>
          <li>Practice active listening: mirror a friend's words once per conversation.</li>
          <li>Use one breathing technique when you feel stressed (box breathing, 4-4-4-4).</li>
          <li>Journal one situation weekly where you regulated your emotions well.</li>
        </ol>
 
        <div style="margin-top:12px">
          <strong>Share or save results</strong>
          <div style="margin-top:8px">
            <button class="btn" onclick="navigator.clipboard.writeText(window.location.href)">Copy link</button>
          </div>
        </div>
      </div>
    </div>
  </div>
 
  <script>
    // nothing required; everything server-rendered for result
  </script>
</body>
</html>
