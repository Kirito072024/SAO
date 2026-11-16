/*
 * Миттєве превʼю в Customizer (Вигляд → Налаштувати → Тема SAO Aincrad).
 *
 * PHP передає список ключів налаштувань (saoPreviewKeys). Для кожного ключа
 * підписуємося на зміну значення й оновлюємо всі елементи з data-sao="ключ" —
 * без перезавантаження сторінки, прямо під час набору тексту.
 */
(function (api) {
  'use strict';

  var keys = window.saoPreviewKeys || {};
  var format = new Intl.NumberFormat('uk-UA');

  function update(key, type, value) {
    var nodes = document.querySelectorAll('[data-sao="' + key + '"]');
    nodes.forEach(function (el) {
      if (type === 'number') {
        var num = parseInt(value, 10) || 0;
        el.setAttribute('data-count', num);
        el.textContent = format.format(num);
      } else {
        el.textContent = value;
      }
      // коротке підсвічування, щоб було видно, що саме змінилося
      el.classList.remove('sao-flash');
      void el.offsetWidth;
      el.classList.add('sao-flash');
    });
  }

  Object.keys(keys).forEach(function (key) {
    api(key, function (setting) {
      setting.bind(function (value) { update(key, keys[key], value); });
    });
  });

  // Назва та опис сайту
  api('blogname', function (setting) {
    setting.bind(function (value) {
      document.querySelectorAll('.brand__name, .site-footer__title').forEach(function (el) {
        el.textContent = value;
      });
    });
  });
})(wp.customize);
