<?php
// quiz.php
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>EQ Test — Quiz</title>
  <style>
    /* Internal CSS: dynamic, modern quiz UI */
    :root{--bg:#071025;--card:#0b1320;--accent:#ff7ab6;--accent2:#7c5cff;--muted:#9fb0c8}
    *{box-sizing:border-box;font-family:Inter,system-ui,Segoe UI,Roboto,Arial}
    body{margin:0;background:linear-gradient(180deg,#06111a,#071227);color:#e8f3ff;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px;}
    .container{width:100%;max-width:920px;background:linear-gradient(180deg,rgba(255,255,255,0.02),rgba(255,255,255,0.01));border-radius:14px;padding:18px;box-shadow:0 10px 40px rgba(2,6,23,0.6);border:1px solid rgba(255,255,255,0.03)}
    header{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px}
    header h2{margin:0;font-size:20px}
    .progress{height:10px;background:rgba(255,255,255,0.03);border-radius:6px;overflow:hidden;margin-top:6px}
    .bar{height:10px;border-radius:6px;background:linear-gradient(90deg,var(--accent),var(--accent2));width:0%}
    .question-card{margin-top:14px;background:linear-gradient(180deg, rgba(255,255,255,0.015), rgba(255,255,255,0.01));padding:18px;border-radius:12px;border:1px solid rgba(255,255,255,0.03)}
    .q{font-size:18px;margin-bottom:12px}
    .options{display:flex;flex-direction:column;gap:10px}
    .opt{background:rgba(255,255,255,0.02);padding:12px;border-radius:10px;border:1px solid rgba(255,255,255,0.02);cursor:pointer;transition:transform .12s, box-shadow .12s}
    .opt:hover{transform:translateY(-3px);box-shadow:0 8px 18px rgba(2,6,23,0.5)}
    .opt.selected{outline:2px solid rgba(255,255,255,0.06);box-shadow:0 10px 30px rgba(124,92,255,0.08)}
    .nav{display:flex;justify-content:space-between;margin-top:14px;gap:10px}
    .nav .btn{padding:10px 14px;border-radius:10px;border:none;font-weight:600;cursor:pointer}
    .btn.primary{background:linear-gradient(90deg,var(--accent2),#4f46e5);color:white}
    .btn.ghost{background:transparent;border:1px solid rgba(255,255,255,0.04);color:var(--muted)}
    .meta{display:flex;gap:10px;align-items:center}
    @media(max-width:700px){.container{padding:12px}.q{font-size:16px}}
  </style>
</head>
<body>
  <div class="container">
    <header>
      <div>
        <h2>EQ Test — Quiz</h2>
        <div class="meta"><small style="color:var(--muted)">Answer honestly • 10 questions</small></div>
      </div>
      <div style="width:260px">
        <div class="progress"><div class="bar" id="progressBar"></div></div>
      </div>
    </header>
 
    <div class="question-card" id="quizCard">
      <div class="q" id="qText">Loading question...</div>
      <div class="options" id="options"></div>
 
      <div class="nav">
        <button class="btn ghost" id="prevBtn">Previous</button>
        <div style="display:flex;gap:8px">
          <button class="btn primary" id="nextBtn">Next</button>
          <button class="btn ghost" id="submitBtn" style="display:none">Submit</button>
        </div>
      </div>
    </div>
  </div>
 
  <script>
    // QUESTIONS: 10 sample statements. Each answer maps to points:
    // "Never"=1, "Rarely"=2, "Sometimes"=3, "Often"=4, "Always"=5
    const questions = [
      {id:1, text: "I easily notice how I feel in different situations."},
      {id:2, text: "When someone is upset, I can read their emotions even if they try to hide them."},
      {id:3, text: "I stay calm under pressure and can think clearly."},
      {id:4, text: "I accept constructive feedback without feeling defensive."},
      {id:5, text: "I can adapt my communication style depending on who I’m talking to."},
      {id:6, text: "I find it easy to show empathy toward others."},
      {id:7, text: "When I feel stressed, I use healthy ways to cope."},
      {id:8, text: "I can forgive others and move forward after disagreements."},
      {id:9, text: "I notice the impact my emotions have on my decisions."},
      {id:10, text: "I can help others calm down when they are upset."}
    ];
 
    const optionsList = [
      {text:'Never', value:1},
      {text:'Rarely', value:2},
      {text:'Sometimes', value:3},
      {text:'Often', value:4},
      {text:'Always', value:5},
    ];
 
    let current = 0;
    const answers = Array(questions.length).fill(null); // store value (1-5)
    const qText = document.getElementById('qText');
    const optionsDiv = document.getElementById('options');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const submitBtn = document.getElementById('submitBtn');
    const progressBar = document.getElementById('progressBar');
 
    function renderQuestion(){
      const q = questions[current];
      qText.textContent = (current+1) + '. ' + q.text;
      optionsDiv.innerHTML = '';
      optionsList.forEach(opt => {
        const d = document.createElement('div');
        d.className = 'opt' + (answers[current] === opt.value ? ' selected' : '');
        d.tabIndex = 0;
        d.innerHTML = `<strong>${opt.text}</strong><div style="font-size:12px;color:rgba(255,255,255,0.6)">(${opt.value} pts)</div>`;
        d.addEventListener('click', ()=> {
          answers[current] = opt.value;
          renderQuestion();
        });
        d.addEventListener('keypress', (e)=> { if(e.key==='Enter') { answers[current] = opt.value; renderQuestion(); }});
        optionsDiv.appendChild(d);
      });
 
      prevBtn.style.display = current===0 ? 'none' : 'inline-block';
      nextBtn.style.display = current===questions.length-1 ? 'none' : 'inline-block';
      submitBtn.style.display = current===questions.length-1 ? 'inline-block' : 'none';
      updateProgress();
    }
 
    function updateProgress(){
      const pct = Math.round((current / (questions.length)) * 100);
      progressBar.style.width = pct + '%';
    }
 
    prevBtn.addEventListener('click', ()=> {
      if(current>0){ current--; renderQuestion(); }
    });
 
    nextBtn.addEventListener('click', ()=> {
      if(answers[current] === null){
        if(!confirm('You have not selected an answer. Continue?')) return;
      }
      if(current < questions.length-1){ current++; renderQuestion(); }
    });
 
    submitBtn.addEventListener('click', ()=> {
      if(answers.includes(null)){
        if(!confirm('Some questions are unanswered. Submit anyway?')) return;
      }
      // Prompt for name/email (optional) — quick modal style prompt
      const name = prompt("Enter your name (optional):", "");
      const email = prompt("Enter your email (optional):", "");
      const score = answers.reduce((s,v)=> s + (v? v:0), 0);
      const max = questions.length * 5;
      // send to save_result.php via fetch
      const payload = { name: name || null, email: email || null, score: score, max_score: max, answers: answers };
      fetch('save_result.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
      }).then(r => r.json())
      .then(data => {
        if(data && data.id){
          // redirect to result page with id using JS
          window.location.href = 'result.php?id=' + encodeURIComponent(data.id);
        } else {
          alert('Could not save result. Please try again.');
        }
      }).catch(err => {
        console.error(err);
        alert('Server error when saving result.');
      });
    });
 
    // init
    renderQuestion();
  </script>
</body>
</html>
