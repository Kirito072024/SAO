/* =========================================================
   Практичне заняття 22: Node.js — проста серверна частина / API
   Запуск:  cd server  →  npm start  (або node server.js)
   Перевірка: http://localhost:3000/api/projects
   ========================================================= */

const express = require('express');
const cors = require('cors');

const app = express();
const PORT = 3000;

/* ----- Крок 6: CORS — дозволяємо фронтенду з іншого порту (Live Server :5500) звертатися до API ----- */
app.use(cors());

/* ----- Крок 5: express.json() розбирає JSON із тіла POST-запиту в req.body ----- */
app.use(express.json());

/* ----- Крок 3: масив projects — мої роботи ----- */
const projects = [
  {
    id: 1,
    title: 'Сайт-фанзона SAO',
    description: 'Семантична HTML-сторінка про світ Sword Art Online: Айнкрад, механіка гри, персонажі та гільдії.',
    tech: ['HTML', 'CSS']
  },
  {
    id: 2,
    title: 'Адаптивна верстка на Tailwind',
    description: 'Сітки карток, що перебудовуються з 1 до 4 колонок залежно від ширини екрана.',
    tech: ['Tailwind CSS']
  },
  {
    id: 3,
    title: 'Форма зворотного зв\'язку',
    description: 'Перевірка email і телефону під час вводу, стан завантаження та відправка через fetch.',
    tech: ['JavaScript', 'Fetch API']
  },
  {
    id: 4,
    title: 'React-компоненти',
    description: 'Header, Section, Card і Footer як окремі компоненти з props та useState.',
    tech: ['React', 'Vite']
  },
  {
    id: 5,
    title: 'Власний API на Node.js',
    description: 'Express-сервер, який віддає проєкти у форматі JSON і приймає повідомлення з форми.',
    tech: ['Node.js', 'Express']
  }
];

/* ----- Крок 3: GET /api/projects — увесь список ----- */
app.get('/api/projects', (req, res) => {
  res.json(projects);
});

/* ----- Додаткове завдання: GET /api/projects/:id — один проєкт або 404 ----- */
app.get('/api/projects/:id', (req, res) => {
  const id = Number(req.params.id);
  const project = projects.find((p) => p.id === id);

  if (!project) {
    return res.status(404).json({ ok: false, error: 'Проєкт з id ' + req.params.id + ' не знайдено' });
  }

  res.json(project);
});

/* ----- Крок 5: POST /api/contact — приймаємо дані форми ----- */
app.post('/api/contact', (req, res) => {
  const { name, email, message } = req.body || {};

  // мінімальна перевірка на сервері: фронтенду довіряти не можна
  if (!name || !email || !message) {
    return res.status(400).json({ ok: false, error: 'Поля name, email і message обов\'язкові' });
  }

  console.log('Нове повідомлення з форми:', req.body);

  res.json({ ok: true });
});

/* ----- Будь-який інший маршрут /api/... — 404 у форматі JSON ----- */
app.use('/api', (req, res) => {
  res.status(404).json({ ok: false, error: 'Маршрут не знайдено' });
});

/* ----- Крок 4: запуск сервера ----- */
app.listen(PORT, () => {
  console.log('Сервер працює: http://localhost:' + PORT + '/api/projects');
});
