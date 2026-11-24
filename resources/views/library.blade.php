<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ISA Library</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&family=Newsreader:ital,opsz,wght@0,6..72,500;0,6..72,600;1,6..72,500&display=swap" rel="stylesheet">
<style>
  :root {
    --paper: #f2f4f7;
    --surface: #ffffff;
    --ink: #0f1b2d;
    --ink-2: #44505f;
    --ink-3: #7b8696;
    --line: #dfe3ea;
    --accent: #2447d6;
    --accent-ink: #ffffff;
    --accent-soft: #e8edfc;
    --danger: #c0332b;
    --radius: 10px;
    --sans: "Manrope", system-ui, -apple-system, "Segoe UI", sans-serif;
    --serif: "Newsreader", Georgia, "Times New Roman", serif;
  }
  * { box-sizing: border-box; }
  html { -webkit-text-size-adjust: 100%; }
  body { margin: 0; background: var(--paper); color: var(--ink); font: 400 15px/1.5 var(--sans); }
  button, input { font: inherit; color: inherit; }
  :focus-visible { outline: 2px solid var(--accent); outline-offset: 2px; }

  /* ---------- Header ---------- */
  .bar { position: sticky; top: 0; z-index: 10; background: rgba(255,255,255,.92); backdrop-filter: blur(8px); border-bottom: 1px solid var(--line); }
  .bar-in { max-width: 1160px; margin: 0 auto; padding: 12px 24px; display: flex; align-items: center; gap: 24px; }
  .brand { display: flex; align-items: center; gap: 10px; font-weight: 700; font-size: 17px; letter-spacing: -.01em; white-space: nowrap; }
  .brand-mark { width: 30px; height: 30px; border-radius: 7px; background: var(--ink); display: grid; place-items: center; }
  .brand-mark svg { width: 17px; height: 17px; }
  .search { flex: 1; max-width: 460px; position: relative; margin: 0 auto 0 8px; }
  .search svg { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 17px; height: 17px; color: var(--ink-3); pointer-events: none; }
  .search input { width: 100%; height: 40px; padding: 0 14px 0 38px; border: 1px solid var(--line); border-radius: 999px; background: var(--paper); }
  .search input:focus { background: var(--surface); border-color: var(--accent); outline: none; box-shadow: 0 0 0 3px var(--accent-soft); }
  .nav { display: flex; align-items: center; gap: 10px; }
  .who { font-weight: 600; font-size: 14px; color: var(--ink-2); padding-right: 4px; }

  /* ---------- Buttons ---------- */
  .btn { height: 38px; padding: 0 16px; border-radius: 8px; border: 1px solid transparent; font-weight: 600; font-size: 14px; cursor: pointer; background: var(--accent); color: var(--accent-ink); transition: background .15s, border-color .15s; white-space: nowrap; }
  .btn:hover { background: #1b39b0; }
  .btn.quiet { background: transparent; color: var(--ink); border-color: var(--line); }
  .btn.quiet:hover { background: var(--paper); }
  .btn.danger { background: var(--danger); }
  .btn.danger:hover { background: #9d241d; }
  .btn.sm { height: 30px; padding: 0 12px; font-size: 13px; }
  .btn:disabled { opacity: .45; cursor: not-allowed; }

  /* ---------- Page ---------- */
  main { max-width: 1160px; margin: 0 auto; padding: 36px 24px 56px; }
  .head { display: flex; align-items: flex-end; justify-content: space-between; gap: 16px; margin-bottom: 28px; flex-wrap: wrap; }
  .head h1 { margin: 0; font: 600 38px/1.1 var(--serif); letter-spacing: -.02em; }
  .head p { margin: 6px 0 0; color: var(--ink-2); }

  .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(188px, 1fr)); gap: 32px 24px; }

  /* ---------- Book ---------- */
  .book { display: flex; flex-direction: column; gap: 12px; }
  .cover {
    position: relative; aspect-ratio: 2 / 3; border-radius: 3px 8px 8px 3px; padding: 22px 18px 18px 26px;
    display: flex; flex-direction: column; justify-content: space-between; color: #fff; overflow: hidden;
    background: var(--c1);
    box-shadow: 0 1px 2px rgba(15,27,45,.18), 0 10px 22px -10px rgba(15,27,45,.35);
    transition: transform .2s ease, box-shadow .2s ease;
  }
  .cover::before { /* spine */
    content: ""; position: absolute; inset: 0 auto 0 0; width: 11px;
    background: linear-gradient(90deg, rgba(0,0,0,.28), rgba(255,255,255,.12) 55%, rgba(0,0,0,.08));
  }
  .cover::after { /* top sheen */
    content: ""; position: absolute; inset: 0; background: linear-gradient(160deg, rgba(255,255,255,.14), transparent 45%);
    pointer-events: none;
  }
  .book:hover .cover { transform: translateY(-4px); box-shadow: 0 1px 2px rgba(15,27,45,.18), 0 18px 28px -12px rgba(15,27,45,.45); }
  .cover-title { font: 600 21px/1.15 var(--serif); letter-spacing: -.01em; display: -webkit-box; -webkit-line-clamp: 5; -webkit-box-orient: vertical; overflow: hidden; }
  .cover-author { font-size: 12px; font-weight: 600; opacity: .85; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
  .info { padding: 0 2px; }
  .info .t { font-weight: 600; font-size: 14px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
  .info .m { color: var(--ink-3); font-size: 12.5px; margin-top: 2px; }
  .acts { display: flex; gap: 6px; margin-top: 8px; }

  /* ---------- States ---------- */
  .skel .cover { background: linear-gradient(100deg, #e5e9f0 30%, #f0f2f6 50%, #e5e9f0 70%); background-size: 200% 100%; animation: sh 1.3s linear infinite; box-shadow: none; }
  .skel .cover::before, .skel .cover::after { display: none; }
  .skel .ln { height: 12px; border-radius: 6px; background: #e5e9f0; margin-top: 4px; }
  @keyframes sh { to { background-position: -200% 0; } }
  .empty { grid-column: 1 / -1; text-align: center; padding: 72px 16px; background: var(--surface); border: 1px dashed var(--line); border-radius: var(--radius); }
  .empty h2 { margin: 0 0 6px; font: 600 24px var(--serif); }
  .empty p { margin: 0 0 18px; color: var(--ink-2); }

  /* ---------- Pager ---------- */
  .pager { display: flex; justify-content: center; align-items: center; gap: 6px; margin-top: 44px; }
  .pager button { min-width: 38px; height: 38px; padding: 0 10px; border: 1px solid var(--line); background: var(--surface); border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 14px; }
  .pager button:hover:not(:disabled) { border-color: var(--ink-3); }
  .pager button[aria-current="page"] { background: var(--ink); color: #fff; border-color: var(--ink); }
  .pager button:disabled { opacity: .4; cursor: not-allowed; }

  /* ---------- Dialog ---------- */
  dialog { border: 0; border-radius: 14px; padding: 0; width: min(440px, calc(100vw - 32px)); background: var(--surface); color: var(--ink); box-shadow: 0 24px 60px -12px rgba(15,27,45,.45); }
  dialog::backdrop { background: rgba(15,27,45,.5); backdrop-filter: blur(2px); }
  dialog[open] { animation: pop .18s ease-out; }
  @keyframes pop { from { opacity: 0; transform: translateY(8px) scale(.98); } }
  .dlg { padding: 28px; }
  .dlg h2 { margin: 0 0 4px; font: 600 28px/1.15 var(--serif); letter-spacing: -.01em; }
  .dlg .sub { margin: 0 0 20px; color: var(--ink-2); font-size: 14px; }
  .field { margin-bottom: 14px; }
  .field label { display: block; font-weight: 600; font-size: 13px; margin-bottom: 5px; }
  .field input { width: 100%; height: 42px; padding: 0 12px; border: 1px solid var(--line); border-radius: 8px; background: var(--surface); }
  .field input:focus { border-color: var(--accent); outline: none; box-shadow: 0 0 0 3px var(--accent-soft); }
  .two { display: grid; grid-template-columns: 1fr 120px; gap: 12px; }
  .err { background: #fdecea; color: #8c1f18; border-radius: 8px; padding: 10px 12px; font-size: 13.5px; margin-bottom: 14px; }
  .dlg-foot { display: flex; justify-content: flex-end; gap: 8px; margin-top: 22px; }
  .switch { margin-top: 18px; text-align: center; font-size: 13.5px; color: var(--ink-2); }
  .switch button { background: none; border: 0; color: var(--accent); font-weight: 700; cursor: pointer; padding: 0; }
  .switch button:hover { text-decoration: underline; }

  /* ---------- Toast ---------- */
  .toast { position: fixed; left: 50%; bottom: 24px; transform: translate(-50%, 20px); opacity: 0; pointer-events: none; background: var(--ink); color: #fff; padding: 11px 18px; border-radius: 10px; font-weight: 600; font-size: 14px; box-shadow: 0 10px 30px -8px rgba(0,0,0,.4); transition: opacity .2s, transform .2s; max-width: calc(100vw - 32px); z-index: 50; }
  .toast.on { opacity: 1; transform: translate(-50%, 0); }
  .toast.bad { background: var(--danger); }

  /* ---------- Console ---------- */
  body.console-open main { padding-bottom: 380px; }
  .console { position: fixed; left: 0; right: 0; bottom: 0; z-index: 20; height: 340px; background: #0c1320; color: #c9d4e5; border-top: 1px solid #1f2b40; display: none; flex-direction: column; font: 12.5px/1.45 ui-monospace, "Cascadia Mono", Consolas, Menlo, monospace; }
  .console.on { display: flex; }
  .c-top { display: flex; align-items: center; gap: 16px; padding: 10px 20px; border-bottom: 1px solid #1f2b40; flex-wrap: wrap; }
  .c-top strong { color: #fff; font-weight: 600; }
  .c-spacer { flex: 1; }
  .c-close { background: none; border: 0; color: #7f8da6; cursor: pointer; font-size: 18px; line-height: 1; }
  .c-close:hover { color: #fff; }
  .c-body { flex: 1; display: grid; grid-template-columns: 320px 1fr; min-height: 0; }
  .c-side { padding: 16px 20px; border-right: 1px solid #1f2b40; overflow: auto; display: flex; flex-direction: column; gap: 14px; }
  .c-row { display: flex; justify-content: space-between; align-items: center; gap: 12px; }
  .c-k { color: #7f8da6; }
  .c-v { color: #fff; }
  .sw { position: relative; width: 42px; height: 24px; border-radius: 999px; background: #33415c; border: 0; cursor: pointer; transition: background .15s; flex: none; }
  .sw::after { content: ""; position: absolute; top: 3px; left: 3px; width: 18px; height: 18px; border-radius: 50%; background: #fff; transition: transform .15s; }
  .sw[aria-checked="true"] { background: #2fa36b; }
  .sw[aria-checked="true"]::after { transform: translateX(18px); }
  .sw:disabled { opacity: .4; cursor: not-allowed; }
  .pill { padding: 1px 8px; border-radius: 999px; font-size: 11.5px; font-weight: 700; }
  .pill.on { background: #123d2a; color: #5fe0a0; }
  .pill.off { background: #4a1d1d; color: #ff8f86; }
  .c-btn { background: #1a2740; color: #dbe5f5; border: 1px solid #2a3a58; border-radius: 6px; padding: 7px 12px; font: inherit; cursor: pointer; }
  .c-btn:hover:not(:disabled) { background: #22335a; }
  .c-btn:disabled { opacity: .45; cursor: not-allowed; }
  .c-note { color: #7f8da6; font-size: 11.5px; }
  .bar-wrap { height: 6px; border-radius: 3px; background: #1a2740; overflow: hidden; }
  .bar-fill { height: 100%; background: #4f7cff; width: 0; transition: width .2s; }
  .c-log { overflow: auto; }
  .c-log table { width: 100%; border-collapse: collapse; }
  .c-log th { position: sticky; top: 0; background: #0c1320; text-align: left; color: #7f8da6; font-weight: 600; padding: 8px 12px; border-bottom: 1px solid #1f2b40; }
  .c-log td { padding: 4px 12px; border-bottom: 1px solid #141e31; white-space: nowrap; }
  .s2 { color: #5fe0a0; } .s4 { color: #ffc65c; } .s429 { color: #ff8f86; font-weight: 700; } .s5 { color: #ff8f86; }
  .m-GET { color: #6fa8ff; } .m-POST { color: #5fe0a0; } .m-PUT, .m-PATCH { color: #ffc65c; } .m-DELETE { color: #ff8f86; }
  @media (max-width: 720px) {
    .c-body { grid-template-columns: 1fr; }
    .c-side { border-right: 0; border-bottom: 1px solid #1f2b40; max-height: 150px; }
    .console { height: 420px; }
    body.console-open main { padding-bottom: 460px; }
  }

  .hidden { display: none !important; }
  .sr { position: absolute; width: 1px; height: 1px; overflow: hidden; clip: rect(0 0 0 0); }

  @media (max-width: 720px) {
    .bar-in { flex-wrap: wrap; gap: 10px 12px; padding: 10px 16px; }
    .search { order: 3; flex-basis: 100%; max-width: none; margin: 0; }
    .nav { margin-left: auto; }
    .who { display: none; }
    main { padding: 24px 16px 48px; }
    .head h1 { font-size: 30px; }
    .grid { grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 24px 16px; }
    .cover-title { font-size: 18px; }
  }
  @media (prefers-reduced-motion: reduce) {
    *, *::before, *::after { animation: none !important; transition: none !important; }
  }
</style>
</head>
<body>

<header class="bar">
  <div class="bar-in">
    <div class="brand">
      <span class="brand-mark" aria-hidden="true">
        <svg viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4v16M9 4v16M14 6l5 14M14 6l3-1"/></svg>
      </span>
      ISA Library
    </div>

    <div class="search">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="11" cy="11" r="7"/><path d="m20 20-3.5-3.5"/></svg>
      <label for="search" class="sr">Search books</label>
      <input id="search" type="search" placeholder="Search by title or author" autocomplete="off">
    </div>

    <nav class="nav" id="nav"></nav>
  </div>
</header>

<main>
  <div class="head">
    <div>
      <h1>Catalog</h1>
      <p id="count">Loading books…</p>
    </div>
  </div>

  <div id="grid" class="grid" aria-live="polite"></div>
  <nav id="pager" class="pager" aria-label="Pagination"></nav>
</main>

<!-- Auth dialog -->
<dialog id="authDlg" aria-labelledby="authTitle">
  <form class="dlg" id="authForm" novalidate>
    <h2 id="authTitle">Log in</h2>
    <p class="sub" id="authSub">Log in to add and manage your books.</p>
    <div class="err hidden" id="authErr" role="alert"></div>
    <div class="field hidden" id="nameField"><label for="aName">Name</label><input id="aName" autocomplete="name"></div>
    <div class="field"><label for="aEmail">Email</label><input id="aEmail" type="email" autocomplete="email" required></div>
    <div class="field"><label for="aPass">Password</label><input id="aPass" type="password" autocomplete="current-password" required></div>
    <div class="dlg-foot">
      <button type="button" class="btn quiet" data-close>Cancel</button>
      <button class="btn" id="authSubmit">Log in</button>
    </div>
    <p class="switch"><span id="switchText">No account yet?</span> <button type="button" id="switchBtn">Create one</button></p>
  </form>
</dialog>

<!-- Book dialog -->
<dialog id="bookDlg" aria-labelledby="bookTitle">
  <form class="dlg" id="bookForm" novalidate>
    <h2 id="bookTitle">Add a book</h2>
    <p class="sub">Every book needs a unique ISBN.</p>
    <div class="err hidden" id="bookErr" role="alert"></div>
    <div class="field"><label for="bTitle">Title</label><input id="bTitle" required></div>
    <div class="field"><label for="bAuthor">Author</label><input id="bAuthor" required></div>
    <div class="two">
      <div class="field"><label for="bIsbn">ISBN</label><input id="bIsbn" required></div>
      <div class="field"><label for="bYear">Year</label><input id="bYear" type="number" min="1000" max="2100" placeholder="Optional"></div>
    </div>
    <div class="dlg-foot">
      <button type="button" class="btn quiet" data-close>Cancel</button>
      <button class="btn" id="bookSubmit">Save book</button>
    </div>
  </form>
</dialog>

<!-- Confirm delete -->
<dialog id="delDlg" aria-labelledby="delTitle">
  <div class="dlg">
    <h2 id="delTitle">Delete this book?</h2>
    <p class="sub" id="delText"></p>
    <div class="dlg-foot">
      <button type="button" class="btn quiet" data-close>Keep book</button>
      <button type="button" class="btn danger" id="delConfirm">Delete book</button>
    </div>
  </div>
</dialog>

<!-- Developer console -->
<section id="console" class="console" aria-label="API console">
  <div class="c-top">
    <strong>API console</strong>
    <span><span class="c-k">rate limit</span> <span id="cState" class="pill on">ON</span></span>
    <span><span class="c-k">auth</span> <span id="cAuth" class="c-v">guest</span></span>
    <span class="c-spacer"></span>
    <button class="c-btn" id="cClear" type="button">Clear log</button>
    <button class="c-close" id="cClose" type="button" aria-label="Close console">×</button>
  </div>
  <div class="c-body">
    <div class="c-side">
      <div class="c-row">
        <label for="cSwitch"><span class="c-v">Rate limiting</span><br><span class="c-note">auth 5/min · api 60/min</span></label>
        <button id="cSwitch" class="sw" role="switch" aria-checked="true" type="button"></button>
      </div>
      <div class="c-note" id="cSwitchNote">Log in to change this setting.</div>

      <div>
        <div class="c-row"><span class="c-k">Remaining (last response)</span><span class="c-v" id="cRem">–</span></div>
        <div class="bar-wrap" style="margin-top:6px"><div class="bar-fill" id="cBar"></div></div>
        <div class="c-row" style="margin-top:6px"><span class="c-k">Limit header</span><span class="c-v" id="cLim">–</span></div>
        <div class="c-row"><span class="c-k">Retry-After</span><span class="c-v" id="cRetry">–</span></div>
      </div>

      <div>
        <button class="c-btn" id="cBurst" type="button">Send 70 requests</button>
        <div class="c-note" style="margin-top:6px" id="cBurstOut">GET /api/books ×70 in parallel. Limit is 60/min.</div>
      </div>
    </div>
    <div class="c-log">
      <table>
        <thead><tr><th>time</th><th>method</th><th>path</th><th>status</th><th>ms</th><th>limit</th><th>remaining</th><th>retry</th></tr></thead>
        <tbody id="cLog"></tbody>
      </table>
    </div>
  </div>
</section>

<div id="toast" class="toast" role="status"></div>

<script>
const API = '/api';
const PER_PAGE = 12;
const $ = id => document.getElementById(id);
const S = {
  token: localStorage.getItem('token'),
  user: JSON.parse(localStorage.getItem('user') || 'null'),
  page: 1, last: 1, total: 0, query: '',
  books: new Map(), editId: null, delId: null, mode: 'login',
};

/* ---------- helpers ---------- */
function toast(msg, bad = false) {
  const t = $('toast');
  t.textContent = msg;
  t.className = 'toast on' + (bad ? ' bad' : '');
  clearTimeout(toast.t);
  toast.t = setTimeout(() => t.classList.remove('on'), 3200);
}

async function api(path, { method = 'GET', body, quiet = false } = {}) {
  const t0 = performance.now();
  const res = await fetch(API + path, {
    method,
    headers: {
      Accept: 'application/json',
      ...(body ? { 'Content-Type': 'application/json' } : {}),
      ...(S.token ? { Authorization: 'Bearer ' + S.token } : {}),
    },
    body: body ? JSON.stringify(body) : undefined,
  });
  logRequest(method, path, res, performance.now() - t0, quiet);
  if (res.status === 204) return null;
  const data = await res.json().catch(() => ({}));
  if (!res.ok) {
    let msg = data.message || 'Something went wrong. Try again.';
    if (res.status === 429) {
      const wait = res.headers.get('Retry-After');
      msg = 'Too many attempts. Try again' + (wait ? ` in ${wait} seconds.` : ' in a minute.');
    } else if (data.errors) {
      msg = Object.values(data.errors).flat().join(' ');
    } else if (res.status === 401) {
      clearSession();
      msg = 'Your session expired. Log in again.';
    }
    throw new Error(msg);
  }
  return data;
}

function el(tag, attrs = {}, ...kids) {
  const n = document.createElement(tag);
  for (const [k, v] of Object.entries(attrs)) {
    if (k === 'class') n.className = v;
    else if (k.startsWith('on')) n.addEventListener(k.slice(2), v);
    else if (v !== false && v != null) n.setAttribute(k, v === true ? '' : v);
  }
  for (const kid of kids.flat()) if (kid != null) n.append(kid.nodeType ? kid : document.createTextNode(kid));
  return n;
}

/* Deterministic cover colour from ISBN/title */
const PALETTE = [
  ['#1f3a5f','#2d5a8c'], ['#7a1f2b','#a3303f'], ['#1f5a4a','#2f8068'], ['#4a2f6e','#6b46a0'],
  ['#8a4b12','#b36a1f'], ['#23424a','#2f6670'], ['#5b2a4a','#85416d'], ['#34415c','#4d6089'],
  ['#3d5a1f','#58812e'], ['#6b2d1f','#97442f'],
];
function coverColor(seed) {
  let h = 0;
  for (const ch of String(seed)) h = (h * 31 + ch.charCodeAt(0)) >>> 0;
  return PALETTE[h % PALETTE.length];
}

/* ---------- session ---------- */
function saveSession(data) {
  S.token = data.token; S.user = data.user;
  localStorage.setItem('token', data.token);
  localStorage.setItem('user', JSON.stringify(data.user));
}
function clearSession() {
  S.token = null; S.user = null;
  localStorage.removeItem('token'); localStorage.removeItem('user');
  renderNav(); renderBooks();
}

function renderNav() {
  const nav = $('nav');
  nav.replaceChildren();
  nav.append(el('button', { class: 'btn quiet', onclick: toggleConsole, 'aria-expanded': String($('console').classList.contains('on')) }, 'Console'));
  if (S.token && S.user) {
    nav.append(
      el('span', { class: 'who' }, S.user.name),
      el('button', { class: 'btn', onclick: () => openBook() }, 'Add book'),
      el('button', { class: 'btn quiet', onclick: logout }, 'Log out'),
    );
  } else {
    nav.append(
      el('button', { class: 'btn quiet', onclick: () => openAuth('login') }, 'Log in'),
      el('button', { class: 'btn', onclick: () => openAuth('register') }, 'Sign up'),
    );
  }
}

async function logout() {
  try { await api('/logout', { method: 'POST' }); } catch {}
  clearSession();
  toast('Logged out');
}

/* ---------- dialogs ---------- */
document.querySelectorAll('dialog').forEach(d => {
  d.addEventListener('click', e => { if (e.target === d) d.close(); });
  d.querySelectorAll('[data-close]').forEach(b => b.addEventListener('click', () => d.close()));
});
function showErr(id, msg) { const e = $(id); e.textContent = msg; e.classList.toggle('hidden', !msg); }

function openAuth(mode) {
  S.mode = mode;
  const reg = mode === 'register';
  $('authTitle').textContent = reg ? 'Create your account' : 'Log in';
  $('authSub').textContent = reg ? 'Sign up to add and manage your own books.' : 'Log in to add and manage your books.';
  $('authSubmit').textContent = reg ? 'Create account' : 'Log in';
  $('nameField').classList.toggle('hidden', !reg);
  $('aPass').autocomplete = reg ? 'new-password' : 'current-password';
  $('switchText').textContent = reg ? 'Already have an account?' : 'No account yet?';
  $('switchBtn').textContent = reg ? 'Log in' : 'Create one';
  showErr('authErr', '');
  if (!$('authDlg').open) $('authDlg').showModal();
  (reg ? $('aName') : $('aEmail')).focus();
}
$('switchBtn').onclick = () => openAuth(S.mode === 'login' ? 'register' : 'login');

$('authForm').onsubmit = async e => {
  e.preventDefault();
  const reg = S.mode === 'register';
  const body = { email: $('aEmail').value.trim(), password: $('aPass').value };
  if (reg) body.name = $('aName').value.trim();
  $('authSubmit').disabled = true;
  showErr('authErr', '');
  try {
    const data = await api(reg ? '/register' : '/login', { method: 'POST', body });
    saveSession(data);
    $('authForm').reset();
    $('authDlg').close();
    renderNav(); renderBooks();
    toast(reg ? 'Account created' : 'Welcome back, ' + data.user.name);
  } catch (err) { showErr('authErr', err.message); }
  $('authSubmit').disabled = false;
};

function openBook(book = null) {
  S.editId = book ? book.id : null;
  $('bookTitle').textContent = book ? 'Edit book' : 'Add a book';
  $('bookSubmit').textContent = book ? 'Save changes' : 'Save book';
  $('bTitle').value = book?.title ?? '';
  $('bAuthor').value = book?.author ?? '';
  $('bIsbn').value = book?.isbn ?? '';
  $('bYear').value = book?.year ?? '';
  showErr('bookErr', '');
  $('bookDlg').showModal();
  $('bTitle').focus();
}

$('bookForm').onsubmit = async e => {
  e.preventDefault();
  const body = {
    title: $('bTitle').value.trim(),
    author: $('bAuthor').value.trim(),
    isbn: $('bIsbn').value.trim(),
    year: $('bYear').value ? Number($('bYear').value) : null,
  };
  $('bookSubmit').disabled = true;
  showErr('bookErr', '');
  try {
    if (S.editId) {
      await api('/books/' + S.editId, { method: 'PUT', body });
      toast('Book updated');
    } else {
      await api('/books', { method: 'POST', body });
      S.page = 1;
      toast('Book added');
    }
    $('bookDlg').close();
    loadBooks();
  } catch (err) { showErr('bookErr', err.message); }
  $('bookSubmit').disabled = false;
};

function askDelete(book) {
  S.delId = book.id;
  $('delText').textContent = `“${book.title}” will be removed from the catalog. This can't be undone.`;
  $('delDlg').showModal();
}
$('delConfirm').onclick = async () => {
  $('delConfirm').disabled = true;
  try {
    await api('/books/' + S.delId, { method: 'DELETE' });
    $('delDlg').close();
    toast('Book deleted');
    if (S.books.size === 1 && S.page > 1) S.page--;
    loadBooks();
  } catch (err) { $('delDlg').close(); toast(err.message, true); }
  $('delConfirm').disabled = false;
};

/* ---------- catalog ---------- */
function skeletons() {
  const g = $('grid');
  g.replaceChildren(...Array.from({ length: 8 }, () =>
    el('div', { class: 'book skel' }, el('div', { class: 'cover' }), el('div', { class: 'ln' }), el('div', { class: 'ln', style: 'width:60%' }))));
}

async function loadBooks() {
  skeletons();
  const p = new URLSearchParams({ page: S.page, per_page: PER_PAGE });
  if (S.query) p.set('search', S.query);
  try {
    const res = await api('/books?' + p);
    S.books = new Map(res.data.map(b => [b.id, b]));
    S.last = res.meta.last_page;
    S.total = res.meta.total;
    renderBooks();
  } catch (err) {
    $('grid').replaceChildren(el('div', { class: 'empty' },
      el('h2', {}, "Can't load the catalog"),
      el('p', {}, err.message),
      el('button', { class: 'btn', onclick: loadBooks }, 'Try again')));
    $('count').textContent = '';
    $('pager').replaceChildren();
  }
}

function renderBooks() {
  const books = [...S.books.values()];
  $('count').textContent = S.query
    ? `${S.total} ${S.total === 1 ? 'result' : 'results'} for “${S.query}”`
    : `${S.total} ${S.total === 1 ? 'book' : 'books'} in the library`;

  if (!books.length) {
    $('grid').replaceChildren(el('div', { class: 'empty' },
      el('h2', {}, S.query ? 'No books match your search' : 'The catalog is empty'),
      el('p', {}, S.query ? 'Check the spelling or try a different title or author.' : 'Add the first book to get started.'),
      S.query ? el('button', { class: 'btn quiet', onclick: () => { $('search').value = ''; S.query = ''; S.page = 1; loadBooks(); } }, 'Clear search')
        : el('button', { class: 'btn', onclick: () => (S.token ? openBook() : openAuth('login')) }, S.token ? 'Add a book' : 'Log in to add a book')));
  } else {
    $('grid').replaceChildren(...books.map(bookCard));
  }
  renderPager();
}

function bookCard(b) {
  const [c1, c2] = coverColor(b.isbn || b.title);
  const mine = S.user && b.user_id === S.user.id;
  return el('article', { class: 'book' },
    el('div', { class: 'cover', style: `--c1:linear-gradient(145deg, ${c1}, ${c2})` },
      el('div', { class: 'cover-title' }, b.title),
      el('div', { class: 'cover-author' }, b.author)),
    el('div', { class: 'info' },
      el('div', { class: 't' }, b.title),
      el('div', { class: 'm' }, [b.author, b.year].filter(Boolean).join(', ')),
      el('div', { class: 'm' }, 'ISBN ' + b.isbn),
      mine ? el('div', { class: 'acts' },
        el('button', { class: 'btn quiet sm', onclick: () => openBook(b) }, 'Edit'),
        el('button', { class: 'btn quiet sm', onclick: () => askDelete(b) }, 'Delete')) : null));
}

function renderPager() {
  const pg = $('pager');
  pg.replaceChildren();
  if (S.last <= 1) return;
  const go = n => () => { S.page = n; loadBooks(); window.scrollTo({ top: 0, behavior: 'smooth' }); };
  pg.append(el('button', { disabled: S.page <= 1, onclick: go(S.page - 1), 'aria-label': 'Previous page' }, '‹'));
  const nums = new Set([1, S.last, S.page - 1, S.page, S.page + 1].filter(n => n >= 1 && n <= S.last));
  let prev = 0;
  [...nums].sort((a, b) => a - b).forEach(n => {
    if (n - prev > 1) pg.append(el('span', { 'aria-hidden': 'true' }, '…'));
    pg.append(el('button', { onclick: go(n), 'aria-current': n === S.page ? 'page' : false, 'aria-label': 'Page ' + n }, String(n)));
    prev = n;
  });
  pg.append(el('button', { disabled: S.page >= S.last, onclick: go(S.page + 1), 'aria-label': 'Next page' }, '›'));
}

let timer;
$('search').addEventListener('input', e => {
  clearTimeout(timer);
  timer = setTimeout(() => { S.query = e.target.value.trim(); S.page = 1; loadBooks(); }, 300);
});

/* ---------- developer console ---------- */
const LOG_MAX = 200;

function logRequest(method, path, res, ms, quiet) {
  const h = n => res.headers.get(n);
  const limit = h('X-RateLimit-Limit'), rem = h('X-RateLimit-Remaining'), retry = h('Retry-After');
  if (limit != null) {
    $('cRem').textContent = rem ?? '–';
    $('cLim').textContent = limit;
    $('cBar').style.width = (rem != null ? Math.max(0, Math.min(100, (rem / limit) * 100)) : 0) + '%';
  }
  $('cRetry').textContent = retry ? retry + 's' : '–';
  if (quiet) return;
  const cls = res.status === 429 ? 's429' : res.status >= 500 ? 's5' : res.status >= 400 ? 's4' : 's2';
  const tr = el('tr', {},
    el('td', { class: 'c-k' }, new Date().toLocaleTimeString([], { hour12: false })),
    el('td', { class: 'm-' + method }, method),
    el('td', {}, '/api' + path),
    el('td', { class: cls }, String(res.status)),
    el('td', {}, Math.round(ms) + ''),
    el('td', {}, limit ?? '–'),
    el('td', {}, rem ?? '–'),
    el('td', {}, retry ? retry + 's' : '–'));
  const body = $('cLog');
  body.prepend(tr);
  while (body.children.length > LOG_MAX) body.lastChild.remove();
}

function toggleConsole() {
  const on = $('console').classList.toggle('on');
  document.body.classList.toggle('console-open', on);
  renderNav();
  if (on) refreshRateLimit();
}
$('cClose').onclick = toggleConsole;
$('cClear').onclick = () => $('cLog').replaceChildren();

function renderConsoleState() {
  const on = S.rateLimit !== false;
  $('cState').textContent = on ? 'ON' : 'OFF';
  $('cState').className = 'pill ' + (on ? 'on' : 'off');
  $('cSwitch').setAttribute('aria-checked', String(on));
  $('cSwitch').disabled = !S.token;
  $('cSwitchNote').textContent = S.token ? (on ? 'Requests over the limit return 429.' : 'Limits are off. No 429 responses.') : 'Log in to change this setting.';
  $('cAuth').textContent = S.user ? S.user.email || S.user.name : 'guest';
}

async function refreshRateLimit() {
  try {
    const d = await api('/settings/rate-limit', { quiet: true });
    S.rateLimit = d.enabled;
  } catch {}
  renderConsoleState();
}

$('cSwitch').onclick = async () => {
  const next = !(S.rateLimit !== false);
  $('cSwitch').disabled = true;
  try {
    const d = await api('/settings/rate-limit', { method: 'PUT', body: { enabled: next } });
    S.rateLimit = d.enabled;
    toast('Rate limiting ' + (d.enabled ? 'on' : 'off'));
  } catch (err) { toast(err.message, true); }
  renderConsoleState();
};

$('cBurst').onclick = async () => {
  const N = 70, out = $('cBurstOut');
  $('cBurst').disabled = true;
  out.textContent = 'Sending…';
  const t0 = performance.now();
  const codes = await Promise.all(Array.from({ length: N }, () =>
    api('/books?per_page=1', { quiet: true }).then(() => 200, e => (/Too many/.test(e.message) ? 429 : 0))));
  const ok = codes.filter(c => c === 200).length, lim = codes.filter(c => c === 429).length;
  const ms = Math.round(performance.now() - t0);
  out.textContent = `${N} sent in ${ms} ms: ${ok} × 200, ${lim} × 429${lim === 0 && S.rateLimit === false ? ' (limiting is off)' : ''}.`;
  $('cLog').prepend(el('tr', {}, el('td', { class: 'c-k' }, new Date().toLocaleTimeString([], { hour12: false })),
    el('td', { class: 'm-GET' }, 'GET'), el('td', {}, `/api/books ×${N} (burst)`),
    el('td', { class: lim ? 's429' : 's2' }, `${ok}×200 ${lim}×429`), el('td', {}, ms + ''), el('td', {}, '–'), el('td', {}, '–'), el('td', {}, '–')));
  $('cBurst').disabled = false;
  loadBooks();
};

const _renderNav = renderNav;
renderNav = function () { _renderNav(); renderConsoleState(); };

renderNav();
loadBooks();
refreshRateLimit();
</script>
</body>
</html>
