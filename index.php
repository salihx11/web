<?php
// index.php — QuickMint Faucet List (clean, debugged)
// Requirements: PHP 7+, place favicon.png and image.png in same folder (or change paths).
// Edit $faucets to add/remove entries. Pagination & search work via GET params.

// --- Basic config ---
$year = date('Y');
$per_page = 12;
$coins = ['btc'=>'Bitcoin','doge'=>'Dogecoin','ltc'=>'Litecoin','eth'=>'Ethereum'];

// --- Request params (safe defaults) ---
$selected_coin = strtolower($_GET['coin'] ?? 'btc');
if (!isset($coins[$selected_coin])) $selected_coin = 'btc';
$page = max(1, intval($_GET['page'] ?? 1));
$q = trim((string)($_GET['q'] ?? ''));

// --- Faucet data ---
// Edit/add entries here. Each entry: ['coin'=>'btc','name'=>'SiteName','reward'=>'0.001 satoshi','timer'=>'5 min','url'=>'https://...']
$faucets = [
    ['coin'=>'btc','name'=>'ChessFaucet','reward'=>'0.01772375 satoshi','timer'=>'1 min','url'=>'https://example.com/chessfaucet'],
    ['coin'=>'btc','name'=>'Bitcosite - Earn Simple Coin','reward'=>'0.04154352 satoshi','timer'=>'5 min','url'=>'https://example.com/bitcosite'],
    ['coin'=>'btc','name'=>'Bagi.Co.in - BTC','reward'=>'0.00028647 satoshi','timer'=>'10 min','url'=>'https://example.com/bagi-btc'],
    ['coin'=>'btc','name'=>'Contract-Miner','reward'=>'0.18143042 satoshi','timer'=>'1 min','url'=>'https://example.com/contract-miner'],
    ['coin'=>'doge','name'=>'Bitcosite - Earn Simple Coin','reward'=>'0.04154352 dogetoshi','timer'=>'5 min','url'=>'https://example.com/bitcosite-doge'],
    ['coin'=>'doge','name'=>'Keran.Co - DOGE','reward'=>'0.00022107 dogetoshi','timer'=>'25 min','url'=>'https://example.com/keran-doge'],
    ['coin'=>'ltc','name'=>'NFFaucet-Litecoin-HighPayout','reward'=>'0.00006452 litoshi','timer'=>'5 min','url'=>'https://example.com/nf-ltc'],
    ['coin'=>'eth','name'=>'Earn-Coins.com','reward'=>'0.00547913 gwei','timer'=>'5 min','url'=>'https://example.com/earn-coins'],
    // --- add more rows below ---
];

// --- Filter faucets by coin + search (case-insensitive) ---
$filtered = array_values(array_filter($faucets, function($f) use($selected_coin, $q) {
    if (!isset($f['coin']) || $f['coin'] !== $selected_coin) return false;
    if ($q === '') return true;
    return (stripos($f['name'], $q) !== false) || (stripos($f['reward'], $q) !== false);
}));

$total = count($filtered);
$pages = max(1, (int)ceil($total / $per_page));
if ($page > $pages) $page = $pages;
$start = ($page - 1) * $per_page;
$rows = array_slice($filtered, $start, $per_page);

// Helper to create safe URL for pagination/links
function url_for($params = []) {
    // build base path without query
    $base = strtok($_SERVER['REQUEST_URI'], '?') ?: '/';
    // Merge existing GET with provided params; allow clearing by passing null
    $qs = $_GET;
    foreach ($params as $k => $v) {
        if ($v === null) unset($qs[$k]);
        else $qs[$k] = $v;
    }
    $query = http_build_query($qs);
    return htmlspecialchars($base . ($query ? "?$query" : ''), ENT_QUOTES | ENT_SUBSTITUTE);
}

// Small helper for safe output
function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE); }
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Free Faucet List — QuickMint</title>
  <meta name="description" content="QuickMint — curated list of free crypto faucets (Bitcoin, Dogecoin, Litecoin, Ethereum). Updated, paginated, and optimized for search." />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <link rel="icon" href="favicon.png" type="image/png" />
  <meta name="robots" content="index,follow"/>
  <link rel="canonical" href="<?= e((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? '') . strtok($_SERVER['REQUEST_URI'],'?')) ?>" />
  <!-- OpenGraph -->
  <meta property="og:site_name" content="QuickMint">
  <meta property="og:title" content="Free Faucet List — QuickMint">
  <meta property="og:description" content="Curated faucet list for Bitcoin, Dogecoin, Litecoin, Ethereum. Visit & claim.">
  <meta property="og:image" content="<?= e((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? '') . '/image.png') ?>">
  <meta property="og:type" content="website">
  <meta name="twitter:card" content="summary_large_image">
  <!-- JSON-LD Schema -->
  <script type="application/ld+json">
  {
    "@context":"https://schema.org",
    "@type":"WebSite",
    "name":"QuickMint",
    "url":"<?= e((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? '')) ?>",
    "description":"Free crypto faucet list and resources — QuickMint",
    "potentialAction": { "@type":"SearchAction", "target": "<?= e((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? '') . '/?q={search_term_string}') ?>", "query-input":"required name=search_term_string" }
  }
  </script>

  <style>
    :root{
      --bg:#0f1113; --card:#15171a; --mint:#27e6b6; --muted:#9aa0a6; --accent:#7bdcfa;
      --radius:12px; --glass: rgba(255,255,255,0.02);
      font-family: "Segoe UI", Roboto, Arial, sans-serif;
    }
    *{box-sizing:border-box}
    body{margin:0;background:linear-gradient(180deg,#0c0d0e,#0f1113);color:#e8f6f2;min-height:100vh}
    .container{max-width:1100px;margin:28px auto;padding:20px}
    header{display:flex;gap:18px;align-items:center}
    .brand{display:flex;gap:14px;align-items:center}
    .brand img{width:84px;height:84px;border-radius:12px;object-fit:cover;border:1px solid rgba(255,255,255,0.04)}
    .brand h1{margin:0;font-size:22px;line-height:1;color:#eaf9f4}
    .brand p{margin:0;color:var(--muted);font-size:13px}
    nav{margin-left:auto}
    nav a{color:var(--muted);text-decoration:none;margin-left:12px;padding:8px 10px;border-radius:8px}
    nav a.active{background:rgba(255,255,255,0.02);color:var(--mint);border:1px solid rgba(39,230,182,0.06)}

    .card{display:block;margin-top:18px;padding:14px;border-radius:12px;background:linear-gradient(180deg, rgba(255,255,255,0.01), rgba(255,255,255,0.02));border:1px solid rgba(255,255,255,0.03);box-shadow:0 10px 30px rgba(0,0,0,0.6)}
    .search-row{display:flex;gap:10px;align-items:center;margin-bottom:10px;flex-wrap:wrap}
    .search-row input{flex:1;padding:10px;border-radius:10px;border:1px solid rgba(255,255,255,0.03);background:rgba(255,255,255,0.015);color:#e9f8f3}
    .search-row button{padding:10px 14px;border-radius:10px;border:none;background:var(--mint);color:#04221a;font-weight:700;cursor:pointer}

    table{width:100%;border-collapse:collapse;margin-top:10px}
    th,td{padding:10px 8px;text-align:left;border-bottom:1px solid rgba(255,255,255,0.02);font-size:14px}
    th{color:var(--muted);font-weight:600}
    .coin-icon{width:36px;height:36px;border-radius:50%;display:inline-grid;place-items:center;background:rgba(255,255,255,0.02);margin-right:8px;font-weight:700}
    .visit-btn{background:linear-gradient(90deg, rgba(39,230,182,0.16), rgba(39,230,182,0.06));padding:8px 12px;border-radius:10px;color:#022a20;text-decoration:none;font-weight:700}
    .pager{display:flex;gap:8px;justify-content:center;margin-top:14px}
    .pager a{padding:8px 10px;border-radius:8px;background:rgba(255,255,255,0.02);color:var(--muted);text-decoration:none}
    .pager a.active{background:var(--mint);color:#022a20}

    footer.bottom{display:flex;align-items:center;justify-content:space-between;margin-top:18px;color:var(--muted);font-size:13px}
    .yt{display:flex;align-items:center;gap:8px}
    .yt img{width:36px;height:36px;border-radius:8px}
    .prices{display:flex;gap:10px;align-items:center}
    .price{background:rgba(255,255,255,0.02);padding:8px 10px;border-radius:8px;font-weight:700;color:var(--muted)}
    .price.up{color:#1dd185}
    .price.down{color:#ff6b6b}
    @media(max-width:880px){
      header{flex-direction:column;align-items:flex-start}
      .brand img{width:64px;height:64px}
    }
  </style>
</head>
<body>
  <div class="container">
    <header>
      <div class="brand">
        <img src="image.png" alt="QuickMint logo (replace image.png)" />
        <div>
          <h1>QuickMint — Free Faucet List</h1>
          <p>Curated faucetpay-like list • Updated • Safe-to-check • QuickMint</p>
        </div>
      </div>

      <nav aria-label="coin navigation">
        <?php foreach($coins as $k=>$label): ?>
          <a class="<?= $selected_coin === $k ? 'active' : '' ?>" href="<?= url_for(['coin'=>$k,'page'=>1,'q'=>null]) ?>"><?= e($label) ?></a>
        <?php endforeach; ?>
      </nav>
    </header>

    <div class="card" role="region" aria-labelledby="listTitle">
      <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap">
        <div>
          <strong id="listTitle" style="font-size:15px"><?= e($coins[$selected_coin]) ?> faucets</strong>
          <div style="color:var(--muted);font-size:13px"><?= $total ?> items • page <?= $page ?> / <?= $pages ?></div>
        </div>

        <form method="get" style="margin:0">
          <input type="hidden" name="coin" value="<?= e($selected_coin) ?>">
          <div class="search-row">
            <input name="q" value="<?= e($q) ?>" placeholder="Search site name or reward (e.g. 'Coinpayu')" />
            <button type="submit">Search</button>
          </div>
        </form>
      </div>

      <!-- Table -->
      <table role="table" aria-label="<?= e($coins[$selected_coin]) ?> faucets list">
        <thead>
          <tr>
            <th></th>
            <th>Site</th>
            <th>Reward</th>
            <th>Timer</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($rows)): ?>
            <tr><td colspan="5" style="color:var(--muted)">No results found.</td></tr>
          <?php else: foreach($rows as $r): ?>
            <tr>
              <td><span class="coin-icon" title="<?= e(strtoupper($r['coin'])) ?>"><?= e(strtoupper($r['coin'])) ?></span></td>
              <td><a href="<?= e($r['url']) ?>" target="_blank" rel="noopener noreferrer" style="color:#eaf9f4;text-decoration:none;font-weight:700"><?= e($r['name']) ?></a></td>
              <td style="color:var(--muted)"><?= e($r['reward']) ?></td>
              <td style="color:var(--muted)"><?= e($r['timer']) ?></td>
              <td><a class="visit-btn" href="<?= e($r['url']) ?>" target="_blank" rel="noopener noreferrer">Visit</a></td>
            </tr>
          <?php endforeach; endif; ?>
        </tbody>
      </table>

      <!-- Pagination -->
      <div class="pager" role="navigation" aria-label="pagination">
        <?php if ($pages > 1):
          $startPage = max(1, $page-3);
          $endPage = min($pages, $page+3);
          if ($page > 1): ?>
            <a href="<?= url_for(['page'=>1]) ?>">First</a>
            <a href="<?= url_for(['page'=>$page-1]) ?>">Prev</a>
          <?php endif;
          for($p=$startPage;$p<=$endPage;$p++): ?>
            <a class="<?= $p==$page ? 'active' : '' ?>" href="<?= url_for(['page'=>$p]) ?>"><?= $p ?></a>
          <?php endfor;
          if ($page < $pages): ?>
            <a href="<?= url_for(['page'=>$page+1]) ?>">Next</a>
            <a href="<?= url_for(['page'=>$pages]) ?>">Last</a>
          <?php endif;
        endif; ?>
      </div>
    </div>

    <!-- Footer: YouTube + prices -->
    <footer class="bottom" role="contentinfo">
      <div class="yt">
        <!-- Replace with your channel URL -->
        <a href="https://www.youtube.com/@QuickMint" target="_blank" rel="noopener noreferrer" title="QuickMint on YouTube">
          <img src="https://www.youtube.com/s/desktop/9f0f9b17/img/favicon_144.png" alt="YouTube">
        </a>
        <div style="color:var(--muted)">
          Subscribe to <strong>QuickMint</strong> • Real free crypto earning guides
        </div>
      </div>

      <div class="prices" id="prices" aria-hidden="false">
        <div class="price">Loading prices...</div>
      </div>
    </footer>

    <div style="margin-top:12px;color:var(--muted);font-size:13px">
      <strong>Note:</strong> Faucet listings are for informational purposes. Replace the sample links with verified URLs you trust. QuickMint is not responsible for external sites. © <?= e($year) ?> QuickMint
    </div>
  </div>

  <!-- Live prices via CoinGecko (client-side, free) -->
  <script>
    const coinMap = { 'btc':'bitcoin', 'ltc':'litecoin', 'doge':'dogecoin', 'eth':'ethereum' };
    async function loadPrices() {
      try {
        const ids = Object.values(coinMap).join(',');
        const res = await fetch(`https://api.coingecko.com/api/v3/simple/price?ids=${ids}&vs_currencies=usd&include_24hr_change=true`);
        const data = await res.json();
        const container = document.getElementById('prices');
        container.innerHTML = '';
        for (const [sym,id] of Object.entries(coinMap)) {
          const info = data[id];
          if (!info) continue;
          const price = info.usd;
          const change = info.usd_24h_change || 0;
          const el = document.createElement('div');
          el.className = 'price ' + (change >= 0 ? 'up' : 'down');
          el.innerHTML = `<strong style="margin-right:8px">${sym.toUpperCase()}</strong> $${price.toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:8})} <span style="font-weight:600">(${change>=0?'+':''}${change.toFixed(2)}%)</span>`;
          container.appendChild(el);
        }
      } catch (e) {
        console.error('price error', e);
        document.getElementById('prices').textContent = 'Prices unavailable';
      }
    }
    loadPrices();
    setInterval(loadPrices, 5*60*1000);
  </script>
</body>
</html>
