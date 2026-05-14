/* ══════════════════════════════════════════════════════════════════
   IMRS JOURNAL — Auth (login/register) sahifalari JS
   ══════════════════════════════════════════════════════════════════ */

(function () {
  'use strict';

  /* ── Show/hide password toggle ───────────────────────────────── */
  function initPasswordToggle() {
    document.querySelectorAll('[data-toggle-pass]').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var sel = btn.getAttribute('data-toggle-pass');
        var input = document.querySelector(sel);
        if (!input) return;
        var shown = input.type === 'text';
        input.type = shown ? 'password' : 'text';
        btn.classList.toggle('is-shown', !shown);
      });
    });
  }

  /* ── Phone mask: +998 (90) 123-45-67 ─────────────────────────── */
  function initPhoneMask() {
    document.querySelectorAll('[data-mask-phone]').forEach(function (input) {
      function format(digits) {
        // digits — faqat raqamlar massivi (ko'pi bilan 12 ta: 998 + 9)
        // Format: +998 (XX) XXX-XX-XX
        var d = digits.replace(/\D/g, '');
        if (d.startsWith('998')) d = d.substring(3);
        d = d.substring(0, 9);

        var out = '+998';
        if (d.length > 0) out += ' (' + d.substring(0, 2);
        if (d.length >= 2) out += ')';
        if (d.length > 2) out += ' ' + d.substring(2, 5);
        if (d.length > 5) out += '-' + d.substring(5, 7);
        if (d.length > 7) out += '-' + d.substring(7, 9);
        return out;
      }

      function onInput() {
        var caretEnd = this.selectionEnd === this.value.length;
        this.value = format(this.value);
        if (caretEnd) {
          var len = this.value.length;
          this.setSelectionRange(len, len);
        }
      }

      function onFocus() {
        if (!this.value) this.value = '+998 (';
      }

      function onBlur() {
        // Agar foydalanuvchi hech narsa kiritmagan bo'lsa — bo'sh qoldiramiz
        var d = this.value.replace(/\D/g, '');
        if (d === '998' || d === '') {
          this.value = '';
        }
      }

      input.addEventListener('focus', onFocus);
      input.addEventListener('input', onInput);
      input.addEventListener('blur', onBlur);

      // Initial format (server'dan kelgan eski qiymatni ham tartibga solamiz)
      if (input.value) input.value = format(input.value);
    });
  }

  /* ── Theme (asosiy journal.js da bor — alohida sahifada ham kerak) */
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

  /* ── Init ────────────────────────────────────────────────────── */
  function ready(fn) {
    if (document.readyState !== 'loading') fn();
    else document.addEventListener('DOMContentLoaded', fn);
  }

  ready(function () {
    initPasswordToggle();
    initPhoneMask();
    initTheme();
  });

})();
