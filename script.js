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

/* ===== Практичне 15, кроки 1-2: обробник кліку і перемикач теми ===== */
// (замість класу .dark-theme використано атрибут data-theme на <html>:
//  ідея та сама — JS змінює стан, а вигляд описано в CSS)
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


/* =========================================================
   Практичне заняття 15: обробка подій та валідація форми
   ========================================================= */

/* ----- Елементи форми ----- */
const form = document.querySelector('form');
const nameInput = document.querySelector('#name');
const emailInput = document.querySelector('#email');
const messageInput = document.querySelector('#message');
const agreeInput = document.querySelector('#agree');
const formMessage = document.querySelector('#form-message');
const emailHint = document.querySelector('#email-hint');

/* ----- Практичне 18: адреса тестового API і кнопка відправки ----- */
const API_URL = 'https://jsonplaceholder.typicode.com';
const submitButton = form.querySelector('button[type="submit"]');
const submitButtonText = submitButton.textContent;

/* ----- Показати повідомлення в <div id="form-message"> (крок 6) ----- */
function showMessage(text, type) {
  formMessage.textContent = text;
  formMessage.classList.remove('error', 'success');
  formMessage.classList.add(type);
}

/* ----- Перевірка email (крок 5): повертає текст помилки або '' ----- */
function getEmailError(email) {
  if (email === '') {
    return 'Введіть електронну пошту.';
  }
  if (!email.includes('@')) {
    return 'Email має містити символ «@».';
  }
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailPattern.test(email)) {
    return 'Перевірте формат email, наприклад name@example.com.';
  }
  return '';
}

/* ----- Крок 3: обробник submit з preventDefault ----- */
form.addEventListener('submit', async function (event) {
  event.preventDefault(); // сторінка не перезавантажується

  // Крок 4: значення полів
  const name = nameInput.value.trim();
  const email = emailInput.value.trim();
  const message = messageInput.value.trim();

  // Крок 5: проста JS-валідація
  const errors = [];

  if (name === '') {
    errors.push("Введіть ім'я.");
  }

  const emailError = getEmailError(email);
  if (emailError !== '') {
    errors.push(emailError);
  }

  if (message === '') {
    errors.push('Напишіть повідомлення.');
  }

  if (!agreeInput.checked) {
    errors.push('Потрібна згода на обробку даних.');
  }

  // Крок 6: показуємо результат на сторінці і в консолі
  if (errors.length > 0) {
    showMessage(errors.join('\n'), 'error');
    console.warn('Форму не відправлено:', errors);
    return;
  }

  // Практичне 18, крок 5: збираємо дані форми в об'єкт
  const data = {
    name: name,
    email: email,
    topic: document.querySelector('#topic').value,
    message: message
  };

  // Крок 8: стан завантаження — кнопка вимкнена, текст змінено
  submitButton.disabled = true;
  submitButton.textContent = 'Надсилання…';
  formMessage.textContent = '';
  formMessage.classList.remove('error', 'success');

  try {
    // Крок 6: POST-запит із JSON
    const response = await fetch(API_URL + '/posts', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data)
    });

    // Крок 7: перевіряємо response.ok
    if (!response.ok) {
      throw new Error('Сервер відповів зі статусом ' + response.status);
    }

    const result = await response.json();
    console.log('Відповідь сервера:', result);

    showMessage('Дякуємо, ' + name + '! Повідомлення надіслано (id на сервері: ' + result.id + ').', 'success');

    form.reset();
    emailInput.classList.remove('valid', 'invalid');
    emailHint.textContent = '';
    emailHint.classList.remove('error', 'success');
  } catch (error) {
    // сюди потрапляємо і при помилці сервера, і коли немає мережі (Offline)
    console.error('Помилка відправки форми:', error);
    // TypeError — це збій мережі (немає інтернету), інакше — помилка від сервера
    const reason = error instanceof TypeError
      ? 'Немає з\'єднання з інтернетом.'
      : 'Сервер повернув помилку.';
    showMessage('Не вдалося надіслати повідомлення. ' + reason + ' Спробуйте ще раз.\n(' + error.message + ')', 'error');
  } finally {
    // кнопка знову доступна в будь-якому випадку
    submitButton.disabled = false;
    submitButton.textContent = submitButtonText;
  }
});

/* ----- Крок 7 (додатково): inline-перевірка email під час вводу ----- */
emailInput.addEventListener('input', function () {
  const value = emailInput.value.trim();

  emailHint.classList.remove('error', 'success');
  emailInput.classList.remove('valid', 'invalid');

  if (value === '') {
    emailHint.textContent = '';
    return;
  }

  const error = getEmailError(value);

  if (error !== '') {
    emailHint.textContent = error;
    emailHint.classList.add('error');
    emailInput.classList.add('invalid');
  } else {
    emailHint.textContent = 'Email виглядає правильно.';
    emailHint.classList.add('success');
    emailInput.classList.add('valid');
  }
});


/* =========================================================
   Практичне заняття 18: Fetch / AJAX
   ========================================================= */

/* Крок 1 (у консолі браузера, для перевірки GET-запиту):
   fetch("https://jsonplaceholder.typicode.com/posts/1").then(r => r.json()).then(console.log)

   Крок 4: ту саму логіку нижче написано через async/await з try/catch. */

/* ----- Кроки 3-4: завантажуємо 3 пости і показуємо їх у розділі «Новини» ----- */
const newsList = document.querySelector('#news-list');

async function loadNews() {
  newsList.textContent = 'Завантаження…';

  try {
    const response = await fetch(API_URL + '/posts?_limit=3');

    if (!response.ok) {
      throw new Error('Сервер відповів зі статусом ' + response.status);
    }

    const posts = await response.json();
    console.log('Отримано пости:', posts);

    newsList.textContent = '';

    posts.forEach(function (post) {
      const item = document.createElement('div');
      item.classList.add('news-item');

      const title = document.createElement('h3');
      title.textContent = post.title;          // textContent — безпечно для даних з API

      const text = document.createElement('p');
      text.textContent = post.body;

      item.append(title, text);
      newsList.append(item);
    });
  } catch (error) {
    console.error('Не вдалося завантажити новини:', error);
    newsList.textContent = 'Не вдалося завантажити новини. Перевірте інтернет і оновіть сторінку.';
  }
}

loadNews();
