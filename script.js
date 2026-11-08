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
const phoneInput = document.querySelector('#phone');
const phoneHint = document.querySelector('#phone-hint');

/* ----- Практичне 22: адреса власного API (папка server, node server.js) і кнопка відправки -----
   Раніше (Практичне 18) тут був тестовий https://jsonplaceholder.typicode.com */
const API_URL = 'http://localhost:3000/api';
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

/* ----- Перевірка телефону (Практичне 21): формат +380XXXXXXXXX ----- */
function getPhoneError(phone) {
  if (phone === '') {
    return 'Введіть номер телефону.';
  }

  // пробіли, дужки та дефіси дозволені — прибираємо їх перед перевіркою
  const digits = phone.replace(/[\s()-]/g, '');

  if (!/^\+380\d{9}$/.test(digits)) {
    return 'Телефон має бути у форматі +380XXXXXXXXX (9 цифр після +380).';
  }

  return '';
}

/* ----- Прибрати підсвітку й підказку поля (після успішної відправки) ----- */
function clearFieldState(input, hint) {
  input.classList.remove('valid', 'invalid');
  hint.textContent = '';
  hint.classList.remove('error', 'success');
}

/* ----- Крок 3: обробник submit з preventDefault ----- */
form.addEventListener('submit', async function (event) {
  event.preventDefault(); // сторінка не перезавантажується

  // Крок 4: значення полів
  const name = nameInput.value.trim();
  const email = emailInput.value.trim();
  const phone = phoneInput.value.trim();
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

  const phoneError = getPhoneError(phone);
  if (phoneError !== '') {
    errors.push(phoneError);
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
    phone: phone.replace(/[\s()-]/g, ''),
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
    const response = await fetch(API_URL + '/contact', {
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

    // наш сервер відповідає { ok: true }
    if (!result.ok) {
      throw new Error(result.error || 'Сервер не прийняв повідомлення');
    }

    showMessage('Дякуємо, ' + name + '! Повідомлення надіслано на сервер.', 'success');

    form.reset();
    clearFieldState(emailInput, emailHint);
    clearFieldState(phoneInput, phoneHint);
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

/* ----- Крок 7 (додатково) + Практичне 21: inline-перевірка під час вводу -----
   Одна універсальна функція замість окремих слухачів для кожного поля
   (рефакторинг: було дублювання коду для email, стало повторне використання) */
function attachInlineValidation(input, hint, getError, okText) {
  input.addEventListener('input', function () {
    const value = input.value.trim();

    hint.classList.remove('error', 'success');
    input.classList.remove('valid', 'invalid');

    if (value === '') {
      hint.textContent = '';
      return;
    }

    const error = getError(value);

    if (error !== '') {
      hint.textContent = error;
      hint.classList.add('error');
      input.classList.add('invalid');
    } else {
      hint.textContent = okText;
      hint.classList.add('success');
      input.classList.add('valid');
    }
  });
}

attachInlineValidation(emailInput, emailHint, getEmailError, 'Email виглядає правильно.');
attachInlineValidation(phoneInput, phoneHint, getPhoneError, 'Телефон виглядає правильно.');


/* =========================================================
   Практичне заняття 18: Fetch / AJAX
   ========================================================= */

/* Крок 1 (у консолі браузера, для перевірки GET-запиту):
   fetch("https://jsonplaceholder.typicode.com/posts/1").then(r => r.json()).then(console.log)

   Крок 4: ту саму логіку нижче написано через async/await з try/catch. */

/* ----- Крок 3-4: новини з файлу news.json через fetch + async/await ----- */
const newsList = document.querySelector('#news-list');

async function loadNews() {
  newsList.textContent = 'Завантаження новин…';

  try {
    const response = await fetch('news.json');

    if (!response.ok) {
      throw new Error('Сервер відповів зі статусом ' + response.status);
    }

    const news = await response.json();
    console.log('Отримано новини:', news);

    newsList.textContent = '';
    newsList.classList.add('timeline');

    news.forEach(function (item) {
      const card = document.createElement('div');
      card.classList.add('news-item');

      const meta = document.createElement('div');
      meta.classList.add('news-meta');

      const date = document.createElement('span');
      date.classList.add('news-date');
      date.textContent = item.date;

      const tag = document.createElement('span');
      tag.classList.add('news-tag');
      tag.textContent = item.tag;

      meta.append(date, tag);

      const title = document.createElement('h3');
      title.textContent = item.title;          // textContent — безпечно для даних із зовнішніх джерел

      const text = document.createElement('p');
      text.textContent = item.text;

      card.append(meta, title, text);
      newsList.append(card);
    });
  } catch (error) {
    console.error('Не вдалося завантажити новини:', error);
    newsList.textContent = 'Не вдалося завантажити новини. Відкрийте сторінку через Live Server або GitHub Pages і оновіть її.';
  }
}

/* ----- Практичне 22, крок 7: картки проєктів із власного API (GET /api/projects) ----- */
const projectsList = document.querySelector('#projects-list');

// ті самі Tailwind-класи, що й у статичних карток гільдій
const PROJECT_CARD_CLASSES = 'flex flex-col gap-2 min-w-0 p-4 rounded-2xl bg-card border border-line shadow-md transition hover:-translate-y-1 hover:border-primary hover:shadow-lg *:m-0 border-t-4 border-t-accent';

async function loadProjects() {
  projectsList.textContent = 'Завантаження проєктів…';

  try {
    const response = await fetch(API_URL + '/projects');

    if (!response.ok) {
      throw new Error('Сервер відповів зі статусом ' + response.status);
    }

    const projects = await response.json();
    console.log('Отримано проєкти з власного API:', projects);

    projectsList.textContent = '';

    projects.forEach(function (project) {
      const card = document.createElement('article');
      card.className = PROJECT_CARD_CLASSES;

      const title = document.createElement('h3');
      title.textContent = project.title;     // textContent — безпечно для даних із сервера

      const text = document.createElement('p');
      text.textContent = project.description;

      const tech = document.createElement('p');
      tech.classList.add('news-tag');
      tech.textContent = project.tech.join(' · ');

      card.append(title, text, tech);
      projectsList.append(card);
    });
  } catch (error) {
    console.error('Не вдалося завантажити проєкти з API:', error);
    projectsList.textContent = 'Не вдалося завантажити проєкти. Запустіть сервер (cd server, npm start) і оновіть сторінку.';
  }
}

loadNews();
loadProjects();
