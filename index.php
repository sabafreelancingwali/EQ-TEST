<?php
// index.php
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>EQ Test — Home</title>
  <style>
    /* Internal CSS — polished, modern look */
    :root{
      --bg:#0f1724; --card:#0b1220; --accent:#7c5cff; --muted:#94a3b8; --glass: rgba(255,255,255,0.03);
    }
    *{box-sizing:border-box;font-family:Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;}
    body{margin:0;background:linear-gradient(180deg,#071025 0%, #0f1a2b 100%);color:#e6eef8;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:32px;}
    .wrap{width:100%;max-width:980px;background:linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01)); border-radius:16px;padding:28px;box-shadow:0 8px 30px rgba(2,6,23,0.6);display:grid;grid-template-columns:1fr 420px;gap:20px;align-items:center}
    .hero{padding:18px}
    h1{margin:0 0 10px;font-size:28px;letter-spacing:-0.4px}
    p.lead{color:var(--muted);line-height:1.6;margin:0 0 18px}
    .features{display:flex;gap:10px;flex-wrap:wrap;margin-top:8px}
    .chip{background:var(--glass);padding:8px 12px;border-radius:10px;font-size:13px;color:var(--muted);border:1px solid rgba(255,255,255,0.02)}
    .card{background:linear-gradient(180deg, rgba(255,255,255,0.015), rgba(255,255,255,0.01));padding:22px;border-radius:12px;box-shadow:inset 0 1px 0 rgba(255,255,255,0.02);border:1px solid rgba(255,255,255,0.03)}
    .cta{display:flex;gap:10px;margin-top:18px}
    .btn{
      background:linear-gradient(90deg,var(--accent), #4f46e5);border:none;padding:12px 18px;border-radius:10px;font-weight:600;color:white;cursor:pointer;box-shadow:0 8px 20px rgba(124,92,255,0.18);
    }
    .btn.ghost{background:transparent;border:1px solid rgba(255,255,255,0.06);color:var(--muted);}
    .right{display:flex;flex-direction:column;gap:12px;align-items:center}
    .progressRing{width:160px;height:160px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:conic-gradient(var(--accent) 0%, rgba(255,255,255,0.02) 0%);position:relative}
    .progressRing .inner{width:120px;height:120px;border-radius:50%;background:linear-gradient(180deg,#071227,#0b1320);display:flex;align-items:center;justify-content:center;flex-direction:column}
    .small{font-size:13px;color:var(--muted)}
    footer{grid-column:1/-1;margin-top:12px;color:var(--muted);font-size:13px;display:flex;justify-content:space-between;align-items:center}
    @media(max-width:880px){.wrap{grid-template-columns:1fr;padding:18px}.right{order:-1}}
  </style>
</head>
<body>
  <div class="wrap">
    <div class="hero">
      <div class="card">
        <h1>Emotional Intelligence (EQ) Test</h1>
        <p class="lead">Understand your emotional strengths and areas to improve. This short test measures self-awareness, empathy, emotional regulation and social skills — and gives personalized feedback to help you grow.</p>
        <div class="features">
          <div class="chip">10–15 min</div>
          <div class="chip">Multiple-choice</div>
          <div class="chip">Instant results</div>
          <div class="chip">Personalized feedback</div>
        </div>
        <div class="cta">
          <button class="btn" id="startBtn">Start Test</button>
          <button class="btn ghost" id="learnBtn">Learn about EQ</button>
        </div>
      </div>
 
      <div style="height:14px"></div>
 
      <div class="card">
        <h3 style="margin:0 0 6px">How the test works</h3>
        <p class="small" style="margin:0 0 8px">Answer honest responses to each statement. There is no single “right” answer — be truthful for the most useful feedback.</p>
        <ul style="margin:0;padding-left:18px;color:var(--muted)">
          <li>10 carefully designed items</li>
          <li>Choose the option that best matches you</li>
          <li>Get a score and tailored tips</li>
        </ul>
      </div>
    </div>
 
    <div class="right">
      <div class="progressRing" id="ring" title="Sample visual">
        <div class="inner">
          <div style="font-size:18px;font-weight:700">EQ</div>
          <div class="small">Quick test</div>
        </div>
      </div>
 
      <div class="card" style="width:100%;text-align:center">
        <div style="font-weight:700">Ready to learn about your emotional strengths?</div>
        <div class="small" style="margin-top:8px">Click Start Test — you'll be redirected to the quiz page.</div>
      </div>
    </div>
 
    <footer>
      <div>Made with ❤️ | EQ Test</div>
      <div>Roll: 175 | Level 1</div>
    </footer>
  </div>
 
  <script>
    // JS redirection (no PHP redirect)
    document.getElementById('startBtn').addEventListener('click', ()=> {
      // Redirect to quiz.php using JS
      window.location.href = 'quiz.php';
    });
    document.getElementById('learnBtn').addEventListener('click', ()=> {
      alert("Emotional intelligence (EQ) is the ability to recognize, understand, and manage your own emotions, and recognize, understand, and influence the emotions of others.");
    });
  </script>
</body>
</html>
