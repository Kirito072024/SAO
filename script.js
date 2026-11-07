/* =========================================================
   Практичне заняття 14: JavaScript — базові скрипти та DOM
   Файл підключено в index.html: <script src="script.js" defer></script>
   ========================================================= */

/* ===== Крок 2. Оголошення змінних (дані проєкту) ===== */
const siteName = 'Sword Art Online: Айнкрад';          // рядок (string)
const floorsCount = 100;                                // число (number)
const characters = ['Кіріто', 'Асуна', 'Клейн', 'Юі']; // масив (array)
const guilds = [
  'Лицарі Кривавої Клятви',
  'Aincrad Liberation Force',
  'Фурінкадзан',
  'Laughing Coffin'
];
let isGameDeadly = true;                                // логічний тип (boolean)

/* ===== Крок 3. Перевірка виводу в консоль ===== */
console.log('Назва сайту:', siteName);
console.log('Кількість поверхів:', floorsCount);
console.log('Персонажі:', characters);
console.log('Гільдії:', guilds, '— всього:', guilds.length);
console.log('Гра смертельна?', isGameDeadly);

/* ===== Крок 4. Вибір елемента DOM: querySelector ===== */
const mainTitle = document.querySelector('h1');
const footer = document.querySelector('footer');
console.log('Заголовок h1:', mainTitle.textContent);
console.log('Футер знайдено:', footer !== null);

/* ===== Крок 5. Зміна текстового вмісту: рік у футері ===== */
const yearElement = document.querySelector('#current-year');
yearElement.textContent = new Date().getFullYear();

/* ===== Крок 6. Вибір кількох елементів: querySelectorAll ===== */
const cards = document.querySelectorAll('article');
const menuLinks = document.querySelectorAll('nav li a');
console.log('Кількість карток (article):', cards.length);
console.log('Кількість пунктів меню:', menuLinks.length);

/* ===== Крок 7. Додавання CSS-класу через classList ===== */
// на початку активний пункт «Головна» (перший у меню)
menuLinks[0].classList.add('active');

// при кліку підсвічуємо вибраний пункт, а в інших прибираємо клас
menuLinks.forEach(function (link) {
  link.addEventListener('click', function () {
    menuLinks.forEach(function (item) {
      item.classList.remove('active');
    });
    link.classList.add('active');
  });
});

/* ===== Перемикач теми день / ніч ===== */
const root = document.documentElement;
const themeButton = document.querySelector('#theme-toggle');

function setTheme(theme) {
  root.setAttribute('data-theme', theme);
  themeButton.textContent = theme === 'dark' ? '☀️ День' : '🌙 Ніч';
  try {
    localStorage.setItem('theme', theme);
  } catch (error) {
    console.warn('localStorage недоступний:', error);
  }
}

setTheme(root.getAttribute('data-theme') || 'dark');

themeButton.addEventListener('click', function () {
  setTheme(root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
});
