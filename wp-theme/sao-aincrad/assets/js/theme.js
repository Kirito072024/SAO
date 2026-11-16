/* =========================================================
   SAO Aincrad — інтерактив теми
   1. Перемикач день / ніч (сонце ↔ місяць) з «коловою» анімацією
   2. Мобільне меню (бургер)
   3. Шапка, «смужка HP» прокрутки і кнопка «нагору»
   4. Поява блоків при прокрутці (data-reveal)
   5. Лічильники в блоці цифр (data-count)
   ========================================================= */
(function () {
  'use strict';

  var root = document.documentElement;
  var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ---------- 1. Тема день / ніч ---------- */
  var toggle = document.getElementById('theme-toggle');

  function applyTheme(theme) {
    root.setAttribute('data-theme', theme);
    try {
      localStorage.setItem('sao-theme', theme);
    } catch (e) { /* приватний режим — просто не зберігаємо */ }

    if (toggle) {
      toggle.setAttribute('aria-label', theme === 'dark' ? 'Увімкнути світлу тему' : 'Увімкнути темну тему');
      toggle.setAttribute('aria-pressed', theme === 'light' ? 'true' : 'false');
    }
    var meta = document.querySelector('meta[name="theme-color"]');
    if (meta) meta.setAttribute('content', theme === 'dark' ? '#1a0f3a' : '#8fc0f0');
  }

  function switchTheme(event) {
    var next = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';

    // клас для «спалаху» кнопки (CSS-анімація .is-switching)
    toggle.classList.remove('is-switching');
    void toggle.offsetWidth; // перезапуск анімації
    toggle.classList.add('is-switching');

    // Без підтримки View Transitions API (Firefox, старі браузери) або з reduced motion —
    // просто міняємо тему, кольори плавно змінюються через CSS transition
    if (!document.startViewTransition || reduceMotion) {
      applyTheme(next);
      return;
    }

    // Коло нової теми «розливається» з центру кнопки на весь екран
    var rect = toggle.getBoundingClientRect();
    var x = event && event.clientX ? event.clientX : rect.left + rect.width / 2;
    var y = event && event.clientY ? event.clientY : rect.top + rect.height / 2;
    var radius = Math.hypot(Math.max(x, innerWidth - x), Math.max(y, innerHeight - y));

    root.classList.add('theme-transition');
    var transition = document.startViewTransition(function () {
      applyTheme(next);
    });

    transition.ready.then(function () {
      root.animate(
        { clipPath: ['circle(0px at ' + x + 'px ' + y + 'px)', 'circle(' + radius + 'px at ' + x + 'px ' + y + 'px)'] },
        { duration: 750, easing: 'cubic-bezier(.65,0,.35,1)', pseudoElement: '::view-transition-new(root)' }
      );
    });
    transition.finished.finally(function () {
      root.classList.remove('theme-transition');
    });
  }

  if (toggle) {
    applyTheme(root.getAttribute('data-theme') || 'dark');
    toggle.addEventListener('click', switchTheme);
  }

  /* ---------- 2. Мобільне меню ---------- */
  var burger = document.getElementById('burger');
  var nav = document.getElementById('primary-nav');

  function setMenu(open) {
    burger.setAttribute('aria-expanded', open ? 'true' : 'false');
    burger.setAttribute('aria-label', open ? 'Закрити меню' : 'Відкрити меню');
    document.body.classList.toggle('menu-open', open);
  }

  if (burger && nav) {
    burger.addEventListener('click', function () {
      setMenu(burger.getAttribute('aria-expanded') !== 'true');
    });
    nav.addEventListener('click', function (e) {
      if (e.target.closest('a')) setMenu(false);
    });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') setMenu(false);
    });
  }

  /* ---------- 3. Шапка, смужка HP, кнопка «нагору» ---------- */
  var topbar = document.querySelector('.topbar');
  var hpFill = document.querySelector('.hp-bar__fill');
  var toTop = document.querySelector('.to-top');
  var ticking = false;

  function onScroll() {
    var y = window.scrollY;
    var max = document.documentElement.scrollHeight - window.innerHeight;
    var progress = max > 0 ? Math.min(y / max, 1) : 0;

    if (topbar) topbar.classList.toggle('is-scrolled', y > 24);
    if (hpFill) hpFill.style.transform = 'scaleX(' + progress + ')';
    if (toTop) toTop.classList.toggle('is-visible', y > 600);
    ticking = false;
  }

  window.addEventListener('scroll', function () {
    if (!ticking) {
      window.requestAnimationFrame(onScroll);
      ticking = true;
    }
  }, { passive: true });
  onScroll();

  /* ---------- 4. Поява блоків при прокрутці ---------- */
  var revealItems = document.querySelectorAll('[data-reveal]');

  if ('IntersectionObserver' in window && !reduceMotion) {
    var revealObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          revealObserver.unobserve(entry.target);
        }
      });
    }, { rootMargin: '0px 0px -8% 0px', threshold: 0.08 });

    revealItems.forEach(function (el) { revealObserver.observe(el); });
  } else {
    revealItems.forEach(function (el) { el.classList.add('is-visible'); });
  }

  /* ---------- 5. Лічильники 0 → N ---------- */
  var counters = document.querySelectorAll('[data-count]');
  var format = new Intl.NumberFormat('uk-UA');

  function runCounter(el) {
    var target = parseInt(el.getAttribute('data-count'), 10);
    var start = null;
    var duration = 1600;

    function frame(time) {
      if (!start) start = time;
      var t = Math.min((time - start) / duration, 1);
      var eased = 1 - Math.pow(1 - t, 3); // плавне сповільнення в кінці
      el.textContent = format.format(Math.round(target * eased));
      if (t < 1) requestAnimationFrame(frame);
    }
    requestAnimationFrame(frame);
  }

  if ('IntersectionObserver' in window && !reduceMotion) {
    var counterObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          runCounter(entry.target);
          counterObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.6 });

    counters.forEach(function (el) { counterObserver.observe(el); });
  }
})();
