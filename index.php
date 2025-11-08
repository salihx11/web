<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Hello — it's me, Marco</title>
  <meta name="description" content="Hello — it's me, Marco. QuickMint — free crypto earning websites." />
  <style>
    :root{
      --bg:#0f1113;        /* very dark gray */
      --card:#15171a;      /* dark card */
      --mint:#27e6b6;      /* mint accent */
      --muted:#9aa0a6;
      --glass: rgba(255,255,255,0.03);
      --radius:16px;
      --mono: "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }
    *{box-sizing:border-box}
    html,body{height:100%}
    body{
      margin:0;
      font-family:var(--mono);
      background:
        radial-gradient(1200px 400px at 10% 10%, rgba(39,230,182,0.06), transparent 12%),
        radial-gradient(900px 300px at 90% 80%, rgba(39,142,230,0.03), transparent 10%),
        var(--bg);
      color:#e6eef0;
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
      display:flex;
      align-items:center;
      justify-content:center;
      padding:32px;
    }

    .card{
      width:100%;
      max-width:920px;
      background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));
      border-radius:var(--radius);
      padding:36px;
      box-shadow: 0 10px 30px rgba(2,6,10,0.6), inset 0 1px 0 rgba(255,255,255,0.02);
      border: 1px solid rgba(255,255,255,0.03);
      display:grid;
      grid-template-columns: 1fr 360px;
      gap:28px;
      align-items:center;
      backdrop-filter: blur(6px) saturate(120%);
    }

    .hero {
      padding:8px 12px;
    }
    h1{
      margin:0 0 8px 0;
      font-size:38px;
      letter-spacing:-0.6px;
      line-height:1.02;
      color: #eaf9f4;
      text-shadow: 0 6px 18px rgba(39,230,182,0.06);
    }
    .accent{
      display:inline-block;
      color:var(--mint);
      font-weight:700;
      padding:6px 10px;
      border-radius:8px;
      background: linear-gradient(90deg, rgba(39,230,182,0.06), rgba(39,230,182,0.02));
      box-shadow: 0 6px 18px rgba(39,230,182,0.08);
      margin-left:8px;
      font-size:18px;
    }
    p.lead{
      margin:12px 0 20px 0;
      color:var(--muted);
      font-size:15px;
      max-width:56ch;
    }
    .cta-row{
      display:flex;
      gap:12px;
      align-items:center;
      flex-wrap:wrap;
    }
    .btn{
      display:inline-flex;
      align-items:center;
      gap:10px;
      padding:10px 14px;
      border-radius:12px;
      cursor:pointer;
      border:1px solid rgba(255,255,255,0.03);
      background:linear-gradient(180deg, rgba(255,255,255,0.015), rgba(255,255,255,0.01));
      color:#eafff8;
      font-weight:600;
      text-decoration:none;
      transition:transform .14s ease, box-shadow .14s ease;
    }
    .btn:hover{ transform:translateY(-4px); box-shadow: 0 10px 30px rgba(8,12,16,0.6) }
    .btn--mint {
      background: linear-gradient(90deg, rgba(39,230,182,0.14), rgba(39,230,182,0.08));
      color: #03221a;
      border: none;
      box-shadow: 0 8px 28px rgba(39,230,182,0.12);
    }

    /* right column */
    .panel{
      background: linear-gradient(180deg, rgba(255,255,255,0.01), rgba(255,255,255,0.015));
      padding:18px;
      border-radius:12px;
      border:1px solid rgba(255,255,255,0.03);
      display:flex;
      flex-direction:column;
      gap:12px;
      align-items:center;
      justify-content:center;
      text-align:center;
    }
    .coins{
      width:100%;
      display:flex;
      gap:10px;
      justify-content:center;
      align-items:center;
      flex-wrap:wrap;
      opacity:0.95;
    }
    .coin{
      width:64px;
      height:64px;
      border-radius:50%;
      background:linear-gradient(180deg, rgba(255,255,255,0.03), rgba(255,255,255,0.01));
      display:grid;
      place-items:center;
      font-weight:700;
      color:#fff;
      box-shadow: 0 6px 18px rgba(2,6,10,0.5);
      border:1px solid rgba(255,255,255,0.04);
      transform: translateY(0);
      transition: transform .3s ease, box-shadow .25s ease;
    }
    .coin:hover{ transform: translateY(-8px) scale(1.06); box-shadow: 0 18px 40px rgba(2,6,10,0.6) }

    footer.small{
      margin-top:8px;
      color:var(--muted);
      font-size:13px;
    }

    /* responsive */
    @media (max-width:920px){
      .card{ grid-template-columns: 1fr; padding:26px; gap:18px; }
      .panel{ order: -1; }
      h1{ font-size:32px }
    }
  </style>
</head>
<body>
  <main class="card" role="main" aria-labelledby="greeting">
    <section class="hero">
      <h1 id="greeting">Hello — it's me, <span class="accent">Marco</span></h1>
      <p class="lead">Welcome to my page. QuickMint: quick guides and verified free crypto earning websites. Start exploring, claim rewards, and stay safe online.</p>

      <div class="cta-row">
        <a class="btn btn--mint" href="#" onclick="alert('Welcome, Marco!');return false;">
          ▶ Start Watching
        </a>
        <a class="btn" href="#" onclick="navigator.clipboard.writeText(window.location.href).then(()=>alert('Link copied!'));">
          🔗 Copy Link
        </a>
      </div>

      <footer class="small">Made with ❤️ • QuickMint • © <span id="year"></span></footer>
    </section>

    <aside class="panel" aria-label="crypto-icons">
      <div style="font-size:14px;color:var(--muted);">Featured coins</div>
      <div class="coins" role="list">
        <div class="coin" title="Bitcoin">₿</div>
        <div class="coin" title="Litecoin">Ł</div>
        <div class="coin" title="Dogecoin">Ð</div>
        <div class="coin" title="Ethereum">Ξ</div>
        <div class="coin" title="Spark">⚡</div>
      </div>
      <div style="font-size:12px;color:var(--muted);">Dark mint theme • QuickMint</div>
    </aside>
  </main>

  <script>
    document.getElementById('year').textContent = new Date().getFullYear();
    // small subtle animation: particles-like float for coins
    const coins = document.querySelectorAll('.coin');
    coins.forEach((c, i) => {
      const delay = Math.random() * 2;
      c.animate([
        { transform: 'translateY(0)' },
        { transform: 'translateY(' + ( (i % 2 ? -8 : 8) ) + 'px)' },
        { transform: 'translateY(0)' }
      ], { duration: 4000 + Math.random()*2000, iterations: Infinity, easing: 'ease-in-out', delay });
    });
  </script>
</body>
</html>
