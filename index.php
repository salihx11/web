<?php
// index.php — QuickMint Intro Page
// You can include sessions, database, or user logic here if needed.
session_start();
$year = date("Y");
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Hello — it's me, Marco</title>
  <meta name="description" content="Hello — it's me, Marco. QuickMint: Free crypto earning websites." />
  <style>
    :root{
      --bg:#0f1113;
      --card:#15171a;
      --mint:#27e6b6;
      --muted:#9aa0a6;
      --radius:16px;
    }
    *{box-sizing:border-box}
    body{
      margin:0;
      font-family: "Segoe UI", Roboto, sans-serif;
      background:
        radial-gradient(1200px 400px at 10% 10%, rgba(39,230,182,0.06), transparent 12%),
        radial-gradient(900px 300px at 90% 80%, rgba(39,142,230,0.03), transparent 10%),
        var(--bg);
      color:#e6eef0;
      display:flex;
      align-items:center;
      justify-content:center;
      min-height:100vh;
      padding:20px;
    }
    .card{
      max-width:900px;
      width:100%;
      background:linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));
      border-radius:var(--radius);
      padding:40px;
      box-shadow:0 10px 30px rgba(2,6,10,0.6);
      border:1px solid rgba(255,255,255,0.04);
      display:grid;
      grid-template-columns:1fr 300px;
      gap:25px;
      align-items:center;
    }
    h1{
      font-size:36px;
      margin:0;
      color:#eaf9f4;
    }
    .accent{
      color:var(--mint);
      font-weight:700;
      background:rgba(39,230,182,0.1);
      padding:5px 10px;
      border-radius:8px;
      margin-left:6px;
    }
    p{
      color:var(--muted);
      margin:15px 0;
      line-height:1.5;
    }
    .btn{
      display:inline-block;
      padding:10px 16px;
      border-radius:10px;
      text-decoration:none;
      font-weight:600;
      margin-top:10px;
      border:1px solid rgba(255,255,255,0.05);
      transition:.2s;
    }
    .btn:hover{transform:translateY(-3px);}
    .mint{background:linear-gradient(90deg, rgba(39,230,182,0.2), rgba(39,230,182,0.1));color:var(--mint);}
    .gray{background:rgba(255,255,255,0.05);color:#e6eef0;}
    footer{margin-top:15px;color:var(--muted);font-size:13px;}
    .coins{
      display:flex;
      flex-wrap:wrap;
      gap:10px;
      justify-content:center;
    }
    .coin{
      width:55px;height:55px;
      border-radius:50%;
      display:grid;
      place-items:center;
      background:rgba(255,255,255,0.03);
      border:1px solid rgba(255,255,255,0.04);
      font-size:22px;
      box-shadow:0 6px 18px rgba(0,0,0,0.4);
      color:#fff;
      transition:.3s;
    }
    .coin:hover{transform:translateY(-6px) scale(1.05);}
    @media(max-width:800px){.card{grid-template-columns:1fr;}}
  </style>
</head>
<body>
  <div class="card">
    <section>
      <h1>Hello — it’s me <span class="accent">Marco</span></h1>
      <p>Welcome to <b>QuickMint</b> — your trusted source for real crypto earning websites, faucets, and tutorials.  
      Claim free rewards, explore new airdrops, and grow your wallet!</p>
      <a href="#" class="btn mint">🚀 Visit QuickMint</a>
      <a href="#" class="btn gray" onclick="navigator.clipboard.writeText(window.location.href);alert('Link copied!');return false;">📋 Copy Link</a>
      <footer>Made with ❤️ by Marco • QuickMint © <?= $year ?></footer>
    </section>
    <aside>
      <div style="text-align:center;color:var(--muted);margin-bottom:8px;">Featured Coins</div>
      <div class="coins">
        <div class="coin" title="Bitcoin">₿</div>
        <div class="coin" title="Litecoin">Ł</div>
        <div class="coin" title="Dogecoin">Ð</div>
        <div class="coin" title="Ethereum">Ξ</div>
        <div class="coin" title="Spark">⚡</div>
      </div>
    </aside>
  </div>
</body>
</html>
