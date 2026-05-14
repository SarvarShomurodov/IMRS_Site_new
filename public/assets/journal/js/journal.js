/* ══════════════════════════════════════════════════════════════════
   IMRS JOURNAL — sayt ichidagi sayt JS
   ══════════════════════════════════════════════════════════════════ */

(function () {
  'use strict';

  /* ═══ STATE ═══ */
  var state = {
    articles: [],
    filters: { year: null, cat: null, tags: [], search: '' },
    sort: 'new',
    view: 'grid'
  };

  var dom = {};

  /* ═══ URL ↔ STATE SYNC ═══ */
  function readUrlIntoState() {
    try {
      var p = new URLSearchParams(window.location.search);
      var cat  = p.get('cat');
      var year = p.get('year');
      var tag  = p.get('tag');
      var q    = p.get('q');
      if (cat)  state.filters.cat  = cat;
      if (year) state.filters.year = year;
      if (tag)  state.filters.tags = [tag];
      if (q)    state.filters.search = q.trim().toLowerCase();
    } catch (e) {}
  }

  function syncUrl() {
    try {
      var p = new URLSearchParams();
      var f = state.filters;
      if (f.cat)          p.set('cat',  f.cat);
      if (f.year)         p.set('year', f.year);
      if (f.tags.length)  p.set('tag',  f.tags[0]);
      if (f.search)       p.set('q',    f.search);
      var qs = p.toString();
      var url = window.location.pathname + (qs ? '?' + qs : '');
      window.history.replaceState(null, '', url);
    } catch (e) {}
  }

  /* ═══ THEME (FOUC oldini olish layout'da bor) ═══ */
  function initTheme() {
    var btn = document.getElementById('jsiteThemeBtn');
    if (!btn) return;
    btn.addEventListener('click', function () {
      var cur = document.documentElement.getAttribute('data-theme');
      var next = cur === 'dark' ? 'light' : 'dark';
      document.documentElement.setAttribute('data-theme', next);
      try { localStorage.setItem('imrs-theme', next); } catch (e) {}
    });
  }

  /* ═══ ARTICLES ═══ */
  function loadArticles() {
    var nodes = document.querySelectorAll('#jsiteArticles .jsite-article');
    state.articles = Array.prototype.map.call(nodes, function (el) {
      return {
        el: el,
        cat: el.dataset.cat || '',
        year: el.dataset.year || '',
        tags: (el.dataset.tags || '').split(',').filter(Boolean),
        title: (el.dataset.title || '').toLowerCase(),
        excerpt: (el.dataset.excerpt || '').toLowerCase(),
        author: (el.dataset.author || '').toLowerCase(),
        views: parseInt(el.dataset.views || '0', 10),
        date: el.dataset.date || ''
      };
    });
  }

  function applyFilters() {
    return state.articles.filter(function (a) {
      if (state.filters.year && a.year !== state.filters.year) return false;
      if (state.filters.cat && a.cat !== state.filters.cat) return false;
      if (state.filters.tags.length) {
        var hasAny = state.filters.tags.some(function (t) {
          return a.tags.indexOf(t) !== -1;
        });
        if (!hasAny) return false;
      }
      var q = state.filters.search;
      if (q) {
        var hay = a.title + ' ' + a.excerpt + ' ' + a.author + ' ' + a.cat;
        if (hay.indexOf(q) === -1) return false;
      }
      return true;
    });
  }

  function applySort(list) {
    var s = state.sort;
    return list.slice().sort(function (a, b) {
      if (s === 'new')     return b.date.localeCompare(a.date);
      if (s === 'old')     return a.date.localeCompare(b.date);
      if (s === 'popular') return b.views - a.views;
      if (s === 'title')   return a.title.localeCompare(b.title);
      return 0;
    });
  }

  function render() {
    var visible = applySort(applyFilters());
    var visibleSet = {};
    visible.forEach(function (a, i) { visibleSet[i] = a; });

    // Hide all
    state.articles.forEach(function (a) { a.el.style.display = 'none'; });

    // Reorder + show
    var list = dom.list;
    visible.forEach(function (a) {
      a.el.style.display = '';
      list.appendChild(a.el);
    });

    // Counts
    var n = visible.length;
    var tb = document.querySelector('.jsite-toolbar');
    var tpl = (tb && tb.getAttribute('data-count-template')) || (n + ' articles');
    var label = tpl.replace('__N__', n);
    document.querySelectorAll('[data-count]').forEach(function (el) { el.textContent = label; });

    // Empty state
    if (dom.empty) dom.empty.hidden = n !== 0;
    if (dom.list)  dom.list.hidden  = n === 0;

    renderActiveChips();
    syncUrl();
  }

  /* ═══ ACTIVE FILTER CHIPS ═══ */
  function renderActiveChips() {
    var box = dom.activeFilters;
    if (!box) return;
    box.innerHTML = '';

    var f = state.filters;
    var any = f.year || f.cat || f.tags.length || f.search;

    if (!any) {
      var empty = document.createElement('span');
      empty.className = 'jsite-active-empty';
      empty.textContent = box.getAttribute('data-empty-text') || '';
      box.appendChild(empty);
      return;
    }

    if (f.year) box.appendChild(makeChip(f.year, function () {
      state.filters.year = null; syncSidebar(); render();
    }));

    if (f.cat) box.appendChild(makeChip(f.cat, function () {
      state.filters.cat = null; syncNav(); render();
    }));

    f.tags.forEach(function (t) {
      box.appendChild(makeChip('#' + t, function () {
        state.filters.tags = state.filters.tags.filter(function (x) { return x !== t; });
        syncSidebar(); render();
      }));
    });

    if (f.search) box.appendChild(makeChip('"' + f.search + '"', function () {
      state.filters.search = '';
      if (dom.searchInput) dom.searchInput.value = '';
      render();
    }));
  }

  function makeChip(label, onRemove) {
    var box = document.getElementById('jsiteActiveFilters');
    var removeLbl = (box && box.getAttribute('data-chip-remove')) || 'Remove';
    var span = document.createElement('span');
    span.className = 'jsite-chip';
    span.appendChild(document.createTextNode(label + ' '));
    var btn = document.createElement('button');
    btn.type = 'button';
    btn.setAttribute('aria-label', removeLbl);
    btn.textContent = '×';
    btn.addEventListener('click', onRemove);
    span.appendChild(btn);
    return span;
  }

  /* ═══ SYNC SIDEBAR / NAV (faol holatni yangilash) ═══ */
  function syncSidebar() {
    document.querySelectorAll('.jsite-side-years li').forEach(function (li) {
      li.classList.toggle('is-act', li.dataset.year === state.filters.year);
    });
    document.querySelectorAll('.jsite-side-tags a').forEach(function (a) {
      a.classList.toggle('is-act', state.filters.tags.indexOf(a.dataset.tag) !== -1);
    });
  }

  function syncNav() {
    document.querySelectorAll('.jsite-nav-list li').forEach(function (li) {
      var a = li.querySelector('a');
      if (!a) return;
      var c = a.dataset.cat;
      var isAct = state.filters.cat ? (c === state.filters.cat) : (c === 'all');
      li.classList.toggle('is-act', isAct);
    });
  }

  /* ═══ HANDLERS ═══ */
  function initYearFilter() {
    document.querySelectorAll('.jsite-side-years li').forEach(function (li) {
      var a = li.querySelector('a');
      if (!a) return;
      a.addEventListener('click', function (e) {
        e.preventDefault();
        var y = li.dataset.year;
        state.filters.year = state.filters.year === y ? null : y;
        syncSidebar(); render();
      });
    });
  }

  function initTagFilter() {
    document.querySelectorAll('.jsite-side-tags a').forEach(function (a) {
      a.addEventListener('click', function (e) {
        e.preventDefault();
        var t = a.dataset.tag;
        var idx = state.filters.tags.indexOf(t);
        if (idx === -1) state.filters.tags.push(t);
        else state.filters.tags.splice(idx, 1);
        syncSidebar(); render();
      });
    });
  }

  function initNavFilter() {
    document.querySelectorAll('.jsite-nav-list a').forEach(function (a) {
      a.addEventListener('click', function (e) {
        e.preventDefault();
        var c = a.dataset.cat;
        state.filters.cat = (c === 'all') ? null : c;
        syncNav(); render();
      });
    });
  }

  function initSearch() {
    var inp = document.querySelector('.jsite-search input');
    if (!inp) return;
    dom.searchInput = inp;
    var t;
    inp.addEventListener('input', function () {
      clearTimeout(t);
      t = setTimeout(function () {
        state.filters.search = inp.value.trim().toLowerCase();
        render();
      }, 150);
    });
  }

  function initSort() {
    var sel = document.getElementById('jsiteSort');
    if (!sel) return;
    sel.addEventListener('change', function () {
      state.sort = sel.value;
      render();
    });
  }

  function initViewToggle() {
    var buttons = document.querySelectorAll('.jsite-view-toggle button');
    if (!buttons.length || !dom.list) return;
    buttons.forEach(function (b) {
      b.addEventListener('click', function () {
        buttons.forEach(function (x) { x.classList.remove('is-act'); });
        b.classList.add('is-act');
        var v = b.dataset.view;
        state.view = v;
        dom.list.classList.toggle('is-grid-mode', v === 'grid');
        dom.list.classList.toggle('is-list-mode', v === 'list');
      });
    });
  }

  function clearAll() {
    state.filters = { year: null, cat: null, tags: [], search: '' };
    if (dom.searchInput) dom.searchInput.value = '';
    var sel = document.getElementById('jsiteSort');
    if (sel) sel.value = 'new';
    state.sort = 'new';
    syncSidebar(); syncNav(); render();
  }

  function initClearAll() {
    var btn = document.querySelector('.jsite-side-clear');
    if (btn) btn.addEventListener('click', function (e) { e.preventDefault(); clearAll(); });
    var btn2 = document.getElementById('jsiteEmptyClear');
    if (btn2) btn2.addEventListener('click', clearAll);
  }

  /* ═══ INIT ═══ */
  function ready(fn) {
    if (document.readyState !== 'loading') fn();
    else document.addEventListener('DOMContentLoaded', fn);
  }

  ready(function () {
    dom.list = document.getElementById('jsiteArticles');
    dom.empty = document.getElementById('jsiteEmpty');
    dom.activeFilters = document.getElementById('jsiteActiveFilters');

    initTheme();
    if (dom.list) {
      loadArticles();
      readUrlIntoState();
      initYearFilter();
      initTagFilter();
      initNavFilter();
      initSearch();
      initSort();
      initViewToggle();
      initClearAll();
      // URLdan kelgan boshlang'ich qiymatlarni input/UI'da aks ettirish
      var sInp = document.querySelector('.jsite-search input');
      if (sInp && state.filters.search) sInp.value = state.filters.search;
      syncSidebar();
      syncNav();
      render();
    }
  });

})();
