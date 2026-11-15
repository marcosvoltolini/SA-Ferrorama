<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Red Rush — Monitoramento ferroviário inteligente</title>
<meta name="description" content="Red Rush (SA Ferrorama): gestão de trens, rotas, horários e sensores em um só sistema.">
<style>
:root{--cream:#fff8ef;--surface:#fffdf9;--wine:#920404;--wine-dark:#6f0303;--red:#b94040;--blush:#f1a8a8;--ink:#2a1717;--soft:#5a3b3b;--line:rgba(42,23,23,.12);--shadow:0 1px 2px rgba(111,3,3,.08),0 12px 32px rgba(111,3,3,.12);--r:16px}
*{box-sizing:border-box;margin:0}
html{scroll-behavior:smooth}
body{font-family:"Segoe UI",system-ui,-apple-system,Roboto,sans-serif;background:var(--cream);color:var(--ink);line-height:1.6}
img{max-width:100%;display:block}
a{color:inherit;text-decoration:none}
.wrap{max-width:1120px;margin:0 auto;padding:0 24px}
section{padding:88px 0}
h2{font-size:clamp(1.7rem,3.2vw,2.4rem);line-height:1.2;color:var(--wine-dark);margin-bottom:12px}
.eyebrow{font-size:.8rem;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--red);margin-bottom:10px}
.lead{color:var(--soft);max-width:640px;font-size:1.05rem}
.btn{display:inline-block;padding:14px 28px;border-radius:999px;font-weight:700;transition:transform .15s,background .15s}
.btn:hover{transform:translateY(-2px)}
.btn-primary{background:var(--wine);color:#fff;box-shadow:var(--shadow)}
.btn-primary:hover{background:var(--wine-dark)}
.btn-ghost{border:2px solid var(--wine);color:var(--wine)}
.btn-ghost:hover{background:var(--wine);color:#fff}
header{position:sticky;top:0;z-index:10;background:rgba(255,248,239,.92);backdrop-filter:blur(8px);border-bottom:1px solid var(--line)}
header .wrap{display:flex;align-items:center;justify-content:space-between;height:68px}
.brand{display:flex;align-items:center;gap:10px;font-weight:800;font-size:1.2rem;color:var(--wine-dark)}
.brand img{height:40px;width:auto}
nav{display:flex;gap:26px;align-items:center;font-size:.95rem;font-weight:600;color:var(--soft)}
nav a:hover{color:var(--wine)}
nav .btn{padding:9px 20px;color:#fff}
.hero{padding:72px 0 96px;background:radial-gradient(900px 400px at 85% 0,rgba(241,168,168,.55),transparent 70%)}
.hero .wrap{display:grid;grid-template-columns:1.05fr .95fr;gap:48px;align-items:center}
.hero h1{font-size:clamp(2.2rem,5vw,3.6rem);line-height:1.08;color:var(--wine-dark);margin-bottom:18px}
.hero h1 span{color:var(--red)}
.hero p{color:var(--soft);font-size:1.12rem;max-width:520px;margin-bottom:30px}
.cta-row{display:flex;gap:14px;flex-wrap:wrap}
.hero-img{background:var(--surface);border-radius:28px;padding:28px;box-shadow:var(--shadow);border:1px solid var(--line)}
.stats{display:flex;gap:32px;margin-top:38px;flex-wrap:wrap}
.stats b{display:block;font-size:1.7rem;color:var(--wine)}
.stats small{color:var(--soft)}
.problem{background:var(--wine-dark);color:#fff}
.problem h2{color:#fff}.problem .lead{color:#f3d3d3}.problem .eyebrow{color:var(--blush)}
.pgrid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-top:40px}
.pcard{background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.15);border-radius:var(--r);padding:26px}
.pcard h3{font-size:1.1rem;margin-bottom:8px;color:var(--blush)}
.pcard p{color:#f3d3d3;font-size:.97rem}
.grid{display:grid;grid-template-columns:repeat(3,1fr);gap:22px;margin-top:44px}
.card{background:var(--surface);border:1px solid var(--line);border-radius:var(--r);padding:28px;box-shadow:var(--shadow);transition:transform .2s}
.card:hover{transform:translateY(-4px)}
.ico{width:48px;height:48px;border-radius:14px;background:var(--wine);display:grid;place-items:center;margin-bottom:16px}
.ico svg{width:26px;height:26px;stroke:#fff;fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round}
.card h3{font-size:1.15rem;margin-bottom:6px}
.card p{color:var(--soft);font-size:.97rem}
.monitor{background:#fbe9e6}
.mon{display:grid;grid-template-columns:1fr 1fr;gap:56px;align-items:center}
.mon img{border-radius:var(--r);box-shadow:var(--shadow);border:1px solid var(--line);background:#fff}
.sensors{display:grid;gap:14px;margin-top:28px}
.sensor{display:flex;gap:16px;align-items:center;background:var(--surface);border-radius:14px;padding:16px 18px;border:1px solid var(--line)}
.sensor .ico{margin:0;flex:none}
.sensor b{display:block}.sensor span{color:var(--soft);font-size:.93rem}
.live{display:inline-flex;align-items:center;gap:8px;font-size:.85rem;font-weight:700;color:var(--wine);margin-top:22px}
.live i{width:10px;height:10px;border-radius:50%;background:#2e9e4f;animation:pulse 1.6s infinite}
@keyframes pulse{0%{box-shadow:0 0 0 0 rgba(46,158,79,.5)}100%{box-shadow:0 0 0 12px rgba(46,158,79,0)}}
.ben{display:grid;grid-template-columns:repeat(3,1fr);gap:22px;margin-top:44px}
.ben div{border-top:4px solid var(--wine);padding-top:18px}
.ben h3{font-size:1.2rem;color:var(--wine-dark);margin-bottom:6px}
.ben p{color:var(--soft)}
.roles{display:grid;grid-template-columns:repeat(3,1fr);gap:22px;margin-top:40px}
.role{background:var(--surface);border:1px solid var(--line);border-radius:var(--r);padding:24px}
.role h3{color:var(--wine);margin-bottom:6px}
.role p{color:var(--soft);font-size:.95rem}
.cta{padding:0 0 88px}
.cta-box{background:linear-gradient(135deg,var(--wine),var(--wine-dark));color:#fff;border-radius:28px;padding:64px 32px;text-align:center;box-shadow:var(--shadow)}
.cta-box h2{color:#fff}
.cta-box p{color:#f3d3d3;max-width:540px;margin:0 auto 28px}
.cta-box .cta-row{justify-content:center}
.cta-box .btn-primary{background:#fff;color:var(--wine)}
.cta-box .btn-ghost{border-color:#fff;color:#fff}
.cta-box .btn-ghost:hover{background:#fff;color:var(--wine)}
footer{border-top:1px solid var(--line);padding:28px 0;color:var(--soft);font-size:.9rem}
footer .wrap{display:flex;justify-content:space-between;flex-wrap:wrap;gap:10px}
@media(max-width:860px){.hero .wrap,.mon{grid-template-columns:1fr}.pgrid,.grid,.ben,.roles{grid-template-columns:1fr}nav a:not(.btn){display:none}section{padding:64px 0}}
@media(prefers-reduced-motion:reduce){*{animation:none!important;transition:none!important}}
</style>
</head>
<body>

<header>
  <div class="wrap">
    <a href="#inicio" class="brand"><img src="assets/imag/Logo_red_rush.png" alt="">Red Rush</a>
    <nav>
      <a href="#problema">Problema</a>
      <a href="#funcionalidades">Funcionalidades</a>
      <a href="#monitoramento">Monitoramento</a>
      <a href="#beneficios">Benefícios</a>
      <a href="public/login.php" class="btn btn-primary">Acessar o sistema</a>
    </nav>
  </div>
</header>

<main>
<!-- HERO -->
<section class="hero" id="inicio">
  <div class="wrap">
    <div>
      <div class="eyebrow">SA Ferrorama · Red Rush</div>
      <h1>Toda a sua ferrovia, <span>sob controle</span> em um só lugar.</h1>
      <p>O Red Rush reúne trens, rotas, horários e sensores em um sistema web simples, para que a operação ferroviária seja acompanhada com mais segurança, clareza e eficiência.</p>
      <div class="cta-row">
        <a href="public/login.php" class="btn btn-primary">Acessar o sistema</a>
        <a href="#funcionalidades" class="btn btn-ghost">Conhecer as funcionalidades</a>
      </div>
      <div class="stats">
        <div><b>3</b><small>perfis de acesso</small></div>
        <div><b>3</b><small>tipos de sensor</small></div>
        <div><b>1</b><small>painel por perfil</small></div>
      </div>
    </div>
    <div class="hero-img"><img src="assets/imag/trem.png" alt="Trem do sistema Red Rush"></div>
  </div>
</section>

<!-- PROBLEMA -->
<section class="problem" id="problema">
  <div class="wrap">
    <div class="eyebrow">O problema</div>
    <h2>Operar uma ferrovia sem visibilidade custa caro.</h2>
    <p class="lead">Quando informações sobre trens, rotas e equipamentos ficam espalhadas em planilhas, papéis e conversas, a operação perde velocidade e segurança.</p>
    <div class="pgrid">
      <div class="pcard"><h3>Informação dispersa</h3><p>Horários, rotas e responsáveis em lugares diferentes dificultam saber o que está acontecendo agora.</p></div>
      <div class="pcard"><h3>Pouco acompanhamento</h3><p>Sem dados de localização, velocidade e energia, problemas só aparecem depois que já aconteceram.</p></div>
      <div class="pcard"><h3>Controle de acesso frágil</h3><p>Sem perfis bem definidos, qualquer pessoa pode alterar dados que deveriam ser protegidos.</p></div>
    </div>
  </div>
</section>

<!-- FUNCIONALIDADES -->
<section id="funcionalidades">
  <div class="wrap">
    <div class="eyebrow">Funcionalidades</div>
    <h2>Tudo o que a operação precisa, organizado.</h2>
    <p class="lead">Cadastros completos e consultas rápidas, com cada pessoa vendo apenas o que lhe cabe.</p>
    <div class="grid">
      <div class="card">
        <div class="ico"><svg viewBox="0 0 24 24"><rect x="5" y="3" width="14" height="14" rx="3"/><path d="M5 11h14M9 21l2-4M15 21l-2-4"/><circle cx="9" cy="14" r=".5"/><circle cx="15" cy="14" r=".5"/></svg></div>
        <h3>Gestão de trens</h3>
        <p>Cadastre, edite e consulte trens, cada um com um maquinista responsável associado.</p>
      </div>
      <div class="card">
        <div class="ico"><svg viewBox="0 0 24 24"><circle cx="6" cy="18" r="2"/><circle cx="18" cy="6" r="2"/><path d="M8 18h6a3 3 0 0 0 0-6h-4a3 3 0 0 1 0-6h6"/></svg></div>
        <h3>Rotas e mapas</h3>
        <p>Origem, destino, distância e mapa de cada rota, tudo lido direto do banco de dados.</p>
      </div>
      <div class="card">
        <div class="ico"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 2"/></svg></div>
        <h3>Horários automáticos</h3>
        <p>Informe a partida e a duração: o horário de chegada é calculado pelo sistema.</p>
      </div>
      <div class="card">
        <div class="ico"><svg viewBox="0 0 24 24"><path d="M5 12.5a10 10 0 0 1 14 0M8.5 16a5 5 0 0 1 7 0"/><circle cx="12" cy="19" r="1"/></svg></div>
        <h3>Sensores por trem</h3>
        <p>Associe sensores de localização, velocidade e energia a cada trem da frota.</p>
      </div>
      <div class="card">
        <div class="ico"><svg viewBox="0 0 24 24"><circle cx="9" cy="8" r="3.5"/><path d="M2.5 20a6.5 6.5 0 0 1 13 0M16 4.5a3.5 3.5 0 0 1 0 7M18 14.5a6.5 6.5 0 0 1 3.5 5.5"/></svg></div>
        <h3>Usuários e perfis</h3>
        <p>Administradores, funcionários e clientes, cada um com seu painel e suas permissões.</p>
      </div>
      <div class="card">
        <div class="ico"><svg viewBox="0 0 24 24"><path d="M12 3 4 6v6c0 5 3.5 8 8 9 4.5-1 8-4 8-9V6z"/><path d="m9 12 2 2 4-4"/></svg></div>
        <h3>Acesso protegido</h3>
        <p>Login obrigatório e verificação de permissão no servidor em cada página do sistema.</p>
      </div>
    </div>
  </div>
</section>

<!-- MONITORAMENTO -->
<section class="monitor" id="monitoramento">
  <div class="wrap mon">
    <div>
      <div class="eyebrow">Monitoramento ferroviário</div>
      <h2>Sensores que transformam dados em decisões.</h2>
      <p class="lead">Cada trem pode ter sensores vinculados, permitindo acompanhar as informações mais importantes da operação.</p>
      <div class="sensors">
        <div class="sensor"><div class="ico"><svg viewBox="0 0 24 24"><path d="M12 21s7-6.2 7-11.5a7 7 0 0 0-14 0C5 14.800 12 21 12 21z"/><circle cx="12" cy="9.5" r="2.5"/></svg></div><div><b>Localização</b><span>Saiba onde cada trem está ao longo da rota.</span></div></div>
        <div class="sensor"><div class="ico"><svg viewBox="0 0 24 24"><path d="M4 18a8 8 0 1 1 16 0"/><path d="m12 18 4-6"/></svg></div><div><b>Velocidade</b><span>Acompanhe o ritmo da viagem e identifique desvios.</span></div></div>
        <div class="sensor"><div class="ico"><svg viewBox="0 0 24 24"><path d="M13 2 4 14h7l-1 8 9-12h-7z"/></svg></div><div><b>Energia</b><span>Monitore o consumo e a alimentação do trem.</span></div></div>
      </div>
      <div class="live"><i></i> Informações operacionais centralizadas em tempo real de consulta</div>
    </div>
    <img src="assets/imag/bernina-rota.png" alt="Mapa de uma rota ferroviária cadastrada no sistema">
  </div>
</section>

<!-- BENEFÍCIOS -->
<section id="beneficios">
  <div class="wrap">
    <div class="eyebrow">Benefícios</div>
    <h2>Mais segurança, eficiência e acompanhamento.</h2>
    <div class="ben">
      <div><h3>Segurança</h3><p>Permissões por perfil e dados de sensores ajudam a proteger informações e a antecipar situações de risco.</p></div>
      <div><h3>Eficiência</h3><p>Cadastros centralizados e horários calculados reduzem retrabalho e erros de planejamento.</p></div>
      <div><h3>Acompanhamento</h3><p>Visão clara de trens, rotas, maquinistas e sensores para quem opera e para quem viaja.</p></div>
    </div>
    <div class="roles">
      <div class="role"><h3>Administrador</h3><p>Controle total: trens, rotas, sensores, exclusões e gestão de todos os usuários.</p></div>
      <div class="role"><h3>Funcionário</h3><p>Cadastra e edita trens, rotas e sensores e vê o trem que conduz como maquinista.</p></div>
      <div class="role"><h3>Cliente</h3><p>Consulta trens, rotas, horários e mapas de forma simples e segura.</p></div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta">
  <div class="wrap">
    <div class="cta-box">
      <h2>Pronto para acompanhar sua ferrovia?</h2>
      <p>Entre no sistema e veja trens, rotas, horários e sensores em um painel feito para o seu perfil.</p>
      <div class="cta-row">
        <a href="public/login.php" class="btn btn-primary">Acessar o sistema</a>
        <a href="#funcionalidades" class="btn btn-ghost">Rever funcionalidades</a>
      </div>
    </div>
  </div>
</section>
</main>

<footer>
  <div class="wrap">
    <span>© 2026 Red Rush — SA Ferrorama</span>
    <span>Projeto do curso técnico em Desenvolvimento de Sistemas</span>
  </div>
</footer>

</body>
</html>
