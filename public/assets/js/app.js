document.addEventListener('DOMContentLoaded', function() {
    /* Icons */
    // SVG icons inlined - lucide.createIcons not needed
    if(typeof lucide !== "undefined") lucide.createIcons();

    /* AOS */
    AOS.init({ duration:700, once:true, offset:40, easing:'ease-out-cubic', delay:0, mirror:false });
    // AOS offline fallback: manually trigger elements in viewport
    function triggerAOS() {
      var els = document.querySelectorAll('[data-aos]');
      var observer = new IntersectionObserver(function(entries) {
        entries.forEach(function(entry) {
          if (entry.isIntersecting) {
            var el = entry.target;
            var delay = parseInt(el.getAttribute('data-aos-delay') || 0);
            setTimeout(function(){ el.classList.add('aos-animate'); }, delay);
            observer.unobserve(el);
          }
        });
      }, { threshold: 0.1, rootMargin: '0px 0px -30px 0px' });
      els.forEach(function(el) {
        el.style.opacity = '0';
        observer.observe(el);
      });
    }
    setTimeout(triggerAOS, 100);

    /* Theme */
    var html = document.documentElement;
    var tBtn = document.getElementById('tBtn');
    var tIco = document.getElementById('tIco');
    function applyTheme(t) {
      html.setAttribute('data-theme', t);
      tIco.setAttribute('data-lucide', t === 'dark' ? 'moon' : 'sun');
      // SVG icons inlined - lucide.createIcons not needed
    if(typeof lucide !== "undefined") lucide.createIcons();
      localStorage.setItem('imrs-t', t);
    }
    var saved = localStorage.getItem('imrs-t');
    applyTheme(saved || 'light');
    tBtn.addEventListener('click', function(){
      applyTheme(html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
    });

    /* Lang */
    window.setLang = function(b) {
      document.querySelectorAll('.lang-btn').forEach(function(x){ x.classList.remove('act'); });
      b.classList.add('act');
    };

    /* Scroll */
    var hdr = document.getElementById('hdr');
    var pbar = document.getElementById('pbar');
    var stb = document.getElementById('stb');
    window.addEventListener('scroll', function(){
      var sv = window.scrollY;
      hdr.classList.toggle('sc', sv > 30);
      var max = document.body.scrollHeight - window.innerHeight;
      pbar.style.width = (max > 0 ? Math.min(100, Math.max(0, sv / max * 100)) : 0) + '%';
      stb.classList.toggle('sh', sv > 350);
    }, { passive: true });
    stb.addEventListener('click', function(){ window.scrollTo({ top:0, behavior:'smooth' }); });

    /* Burger */
    var burg = document.getElementById('burg');
    var mobNav = document.getElementById('mobNav');
    var mo = false;
    burg.addEventListener('click', function(){
      mo = !mo;
      burg.classList.toggle('op', mo);
      mobNav.classList.toggle('op', mo);
      burg.setAttribute('aria-expanded', mo);
      document.body.style.overflow = mo ? 'hidden' : '';
    });
    mobNav.querySelectorAll('a').forEach(function(a){
      a.addEventListener('click', function(){
        mo=false; burg.classList.remove('op'); mobNav.classList.remove('op');
        burg.setAttribute('aria-expanded',false); document.body.style.overflow='';
      });
    });

    /* Mob nav accordion */
    mobNav.querySelectorAll('.mob-sub-toggle').forEach(function(btn){
      btn.addEventListener('click', function(){
        var open = btn.classList.toggle('op');
        var sub = btn.nextElementSibling;
        if (sub) sub.classList.toggle('op', open);
        btn.setAttribute('aria-expanded', open);
      });
    });


    /* Video autoplay */
    var heroVideo = document.getElementById('hero-video');
    if (heroVideo) {
      var canvas = document.getElementById('hero-canvas');
      heroVideo.muted = true;
      var playPromise = heroVideo.play();
      if (playPromise !== undefined) {
        playPromise.catch(function() {
          document.addEventListener('click', function onFirstClick() {
            heroVideo.play();
            document.removeEventListener('click', onFirstClick);
          }, { once: true });
        });
      }
      heroVideo.addEventListener('canplay', function() {
        if (canvas) { canvas.style.opacity = '0'; canvas.style.transition = 'opacity 1s'; }
        heroVideo.style.opacity = '1';
      });
      heroVideo.addEventListener('error', function() {
        var sources = heroVideo.querySelectorAll('source');
        var idx = Array.from(sources).findIndex(function(s){ return s.src === heroVideo.currentSrc; });
        if (idx < sources.length - 1) {
          heroVideo.src = sources[idx + 1].src;
          heroVideo.load();
          heroVideo.play();
        }
      });
    }
    // Mini canvas particles (vanilla, no Three.js)
(function(){
  var canvas = document.getElementById('hero-canvas');
  if(!canvas) return;
  var ctx = canvas.getContext('2d');
  var pts = [];
  function resize(){
    canvas.width = canvas.parentElement.offsetWidth;
    canvas.height = canvas.parentElement.offsetHeight;
  }
  resize(); window.addEventListener('resize', resize);
  for(var i=0;i<180;i++){
    pts.push({
      x: Math.random()*canvas.width,
      y: Math.random()*canvas.height,
      r: Math.random()*1.5+0.4,
      vx:(Math.random()-.5)*0.3,
      vy:(Math.random()-.5)*0.3,
      a: Math.random()*0.5+0.15
    });
  }
  function draw(){
    ctx.clearRect(0,0,canvas.width,canvas.height);
    pts.forEach(function(p){
      ctx.beginPath();
      ctx.arc(p.x,p.y,p.r,0,Math.PI*2);
      ctx.fillStyle='rgba(37,99,168,'+p.a+')';
      ctx.fill();
      p.x+=p.vx; p.y+=p.vy;
      if(p.x<0)p.x=canvas.width;
      if(p.x>canvas.width)p.x=0;
      if(p.y<0)p.y=canvas.height;
      if(p.y>canvas.height)p.y=0;
    });
    requestAnimationFrame(draw);
  }
  draw();
})();

    /* CountUp */
    var statsEl = document.querySelector('.hero-stats');
    if (statsEl && typeof countUp !== 'undefined') {
      new IntersectionObserver(function(en){
        if(en[0].isIntersecting){
          [['c1',30,2],['c2',120,2.2],['c3',14,1.8],['c4',40,2]].forEach(function(d){
            new countUp.CountUp(d[0],d[1],{duration:d[2]}).start();
          });
        }
      },{threshold:.5}).observe(statsEl);
    }

    /* Indicator bars */
    setTimeout(function(){
      document.querySelectorAll('.ind-fill').forEach(function(f){
        f.style.width = f.dataset.w+'%';
      });
    }, 700);

    /* Swiper — currently no Swiper-based components on the homepage.
       (Journals = bento grid, Partners = pure-CSS marquee.) */

    /* GSAP parallax - smooth scrub */
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
      gsap.registerPlugin(ScrollTrigger);
      ScrollTrigger.config({ limitCallbacks: true, ignoreMobileResize: true });
      gsap.to('.hero-title',{yPercent:-12,ease:'none',scrollTrigger:{trigger:'#hero',start:'top top',end:'bottom top',scrub:1.5}});
      gsap.to('.hero-desc',{yPercent:-6,ease:'none',scrollTrigger:{trigger:'#hero',start:'top top',end:'bottom top',scrub:1.5}});
      gsap.to('.hero-video-bg video',{scale:1.08,ease:'none',scrollTrigger:{trigger:'#hero',start:'top top',end:'bottom top',scrub:true}});
    }

    /* ════════ FX: SCROLL PROGRESS BAR ════════ */
    (function(){
      var bar = document.getElementById('scrollProg');
      if(!bar) return;
      var raf = null;
      function update(){
        var h = document.documentElement;
        var scrolled = h.scrollTop || document.body.scrollTop;
        var max = (h.scrollHeight - h.clientHeight) || 1;
        bar.style.width = Math.min(100, (scrolled / max) * 100) + '%';
        raf = null;
      }
      window.addEventListener('scroll', function(){
        if(!raf) raf = requestAnimationFrame(update);
      }, { passive:true });
      update();
    })();

    /* ════════ FX: 3D TILT on .tilt cards ════════ */
    (function(){
      var reduced = window.matchMedia('(prefers-reduced-motion:reduce)').matches;
      var coarse = window.matchMedia('(hover:none)').matches;
      if(reduced || coarse) return;
      var MAX = 8; // degrees
      document.querySelectorAll('.tilt').forEach(function(el){
        var rect, raf, rx=0, ry=0, tx=0, ty=0;
        function onMove(e){
          rect = rect || el.getBoundingClientRect();
          var px = (e.clientX - rect.left) / rect.width - .5;
          var py = (e.clientY - rect.top) / rect.height - .5;
          tx = -py * MAX;
          ty =  px * MAX;
          if(!raf) raf = requestAnimationFrame(apply);
        }
        function apply(){
          rx += (tx - rx) * .18;
          ry += (ty - ry) * .18;
          el.style.setProperty('transform','perspective(900px) rotateX('+rx.toFixed(2)+'deg) rotateY('+ry.toFixed(2)+'deg) translateZ(0)','important');
          if(Math.abs(tx-rx) > .05 || Math.abs(ty-ry) > .05){
            raf = requestAnimationFrame(apply);
          } else { raf = null; }
        }
        function onEnter(){ rect = el.getBoundingClientRect(); }
        function onLeave(){
          tx = 0; ty = 0;
          if(!raf) raf = requestAnimationFrame(apply);
        }
        el.addEventListener('mouseenter', onEnter);
        el.addEventListener('mousemove', onMove);
        el.addEventListener('mouseleave', onLeave);
      });
    })();

    /* ════════ FX: MAGNETIC BUTTONS ════════ */
    (function(){
      var reduced = window.matchMedia('(prefers-reduced-motion:reduce)').matches;
      var coarse = window.matchMedia('(hover:none)').matches;
      if(reduced || coarse) return;
      var STRENGTH = 0.32;
      document.querySelectorAll('.btn-p, .btn-g, .btn-w, .ico-btn, .btn-proposal').forEach(function(btn){
        btn.classList.add('magnetic');
        var raf, tx=0, ty=0, cx=0, cy=0;
        function onMove(e){
          var r = btn.getBoundingClientRect();
          tx = (e.clientX - (r.left + r.width/2)) * STRENGTH;
          ty = (e.clientY - (r.top + r.height/2)) * STRENGTH;
          if(!raf) raf = requestAnimationFrame(apply);
        }
        function apply(){
          cx += (tx - cx) * .22;
          cy += (ty - cy) * .22;
          btn.style.setProperty('transform','translate('+cx.toFixed(2)+'px,'+cy.toFixed(2)+'px)','important');
          if(Math.abs(tx-cx) > .1 || Math.abs(ty-cy) > .1){
            raf = requestAnimationFrame(apply);
          } else { raf = null; }
        }
        function onLeave(){
          tx = 0; ty = 0;
          if(!raf) raf = requestAnimationFrame(apply);
        }
        btn.addEventListener('mousemove', onMove);
        btn.addEventListener('mouseleave', onLeave);
      });
    })();

    /* ════════ FX: HERO PARALLAX (mouse-driven layers) ════════ */
    (function(){
      var reduced = window.matchMedia('(prefers-reduced-motion:reduce)').matches;
      var coarse = window.matchMedia('(hover:none)').matches;
      if(reduced || coarse) return;
      var hero = document.getElementById('hero');
      if(!hero) return;
      var bg = hero.querySelector('.hero-video-bg');
      var badge = hero.querySelector('.hero-badge');
      var canvas = document.getElementById('hero-canvas');
      var raf, tx=0, ty=0;
      function onMove(e){
        var r = hero.getBoundingClientRect();
        tx = ((e.clientX - r.left) / r.width - .5) * 2;
        ty = ((e.clientY - r.top) / r.height - .5) * 2;
        if(!raf) raf = requestAnimationFrame(apply);
      }
      function apply(){
        if(bg) bg.style.setProperty('transform','translate('+(tx*-10).toFixed(2)+'px,'+(ty*-7).toFixed(2)+'px) scale(1.04)','important');
        if(canvas) canvas.style.setProperty('transform','translate('+(tx*-18).toFixed(2)+'px,'+(ty*-12).toFixed(2)+'px)','important');
        if(badge) badge.style.setProperty('transform','translate('+(tx*7).toFixed(2)+'px,'+(ty*4).toFixed(2)+'px)','important');
        raf = null;
      }
      hero.addEventListener('mousemove', onMove);
      hero.addEventListener('mouseleave', function(){
        tx = 0; ty = 0;
        if(!raf) raf = requestAnimationFrame(apply);
      });
    })();

    /* ════════ FX: STAGGER REVEAL via IntersectionObserver ════════ */
    (function(){
      var nodes = document.querySelectorAll('[data-stagger]');
      if(!nodes.length || typeof IntersectionObserver === 'undefined') return;
      var io = new IntersectionObserver(function(ents){
        ents.forEach(function(en){
          if(en.isIntersecting){
            en.target.classList.add('in');
            io.unobserve(en.target);
          }
        });
      }, { threshold: 0.15 });
      nodes.forEach(function(n){ io.observe(n); });
    })();

    /* ════════ FX: SHIMMER LOADING on images ════════ */
    (function(){
      document.querySelectorAll('.news-featured-img, .nli-thumb, .j-card-img, .pub-ico').forEach(function(wrap){
        var img = wrap.querySelector('img');
        if(!img) return;
        if(!img.complete){
          wrap.classList.add('loading');
          img.addEventListener('load', function(){ wrap.classList.remove('loading'); });
          img.addEventListener('error', function(){ wrap.classList.remove('loading'); });
        }
      });
    })();

    /* ════════ FX: HEADER — Magnetic nav links ════════ */
    (function(){
      if(window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
      if(window.matchMedia && window.matchMedia('(max-width: 980px)').matches) return;
      var links = document.querySelectorAll('#hdr .nav-links > .nav-item > a, #hdr .btn-proposal');
      links.forEach(function(el){
        el.addEventListener('mousemove', function(e){
          var rect = el.getBoundingClientRect();
          var x = e.clientX - rect.left - rect.width  / 2;
          var y = e.clientY - rect.top  - rect.height / 2;
          el.style.transform = 'translate(' + (x * 0.18) + 'px, ' + (y * 0.22) + 'px)';
        });
        el.addEventListener('mouseleave', function(){
          el.style.transform = '';
        });
      });
    })();

    /* ════════ FX: FOOTER — Dot grid parallax ════════ */
    (function(){
      var ftr = document.getElementById('ftr');
      if(!ftr) return;
      if(window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
      ftr.classList.add('has-fx');
      var raf = null, mx = 50, my = 50;
      ftr.addEventListener('mousemove', function(e){
        var rect = ftr.getBoundingClientRect();
        mx = ((e.clientX - rect.left) / rect.width)  * 100;
        my = ((e.clientY - rect.top)  / rect.height) * 100;
        if(raf) return;
        raf = requestAnimationFrame(function(){
          ftr.style.setProperty('--mx', mx + '%');
          ftr.style.setProperty('--my', my + '%');
          raf = null;
        });
      });
      ftr.addEventListener('mouseleave', function(){
        ftr.style.setProperty('--mx', '50%');
        ftr.style.setProperty('--my', '50%');
      });
    })();
});