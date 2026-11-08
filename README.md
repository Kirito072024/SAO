# SAO — Айнкрад

Фан-сайт про Sword Art Online: механіка гри, історія «смертельної гри», головні герої та гільдії Айнкрада. Навчальний проєкт з курсу «WEB-технології та WEB-дизайн».

## Посилання
- **Живий сайт:** _додати після деплою_ (наприклад, `https://sao-ainkrad.vercel.app`)
- **Репозиторій:** [github.com/Kirito072024/SAO](https://github.com/Kirito072024/SAO)
- **Макет у Figma:** _додати посилання на макет_

## Що на сайті
- Головна, Айнкрад, Механіка гри, Історія
- Персонажі та клани у вигляді карток
- Новини Айнкраду — хроніка подій, завантажується з `news.json`
- Мої проєкти — картки з власного API на Node.js
- Форма зворотного зв'язку з перевіркою полів
- Перемикач теми день / ніч
- Встановлюється як застосунок (PWA) і відкривається без інтернету

## Технології
- **HTML5** — семантична розмітка, SEO (meta description, Open Graph), доступність (skip link, aria-атрибути)
- **CSS3** — custom properties, flexbox, grid, transition, дві теми
- **Tailwind CSS v4** — сітки карток і кнопка форми
- **JavaScript** — DOM, події, валідація форми, `fetch` + `async/await`
- **Node.js + Express** — API в папці `server/` (GET `/api/projects`, POST `/api/contact`)
- **PWA** — `manifest.json`, service worker `sw.js`
- **Деплой** — Vercel, автодеплой при кожному push у `main`
- Google Fonts (Exo 2, Inter), Git

## Структура проєкту
```
SAO/
├── index.html
├── style.css
├── script.js
├── news.json          (новини для розділу «Новини Айнкраду»)
├── manifest.json      (PWA: назва, кольори, іконки)
├── sw.js              (service worker: кеш для роботи без інтернету)
├── package.json
├── src/
│   ├── input.css      (вхідний файл Tailwind + кольори теми)
│   └── output.css     (згенерований файл, не редагувати вручну)
├── images/            (картинки у WebP + og-image.jpg для превʼю посилання)
├── icons/             (іконки застосунку 192 і 512 px)
├── server/            (Express API)
├── CONCEPT.md, LIGHTHOUSE.md, SEO-A11Y.md, TESTING.md
└── README.md
```

## Як запустити локально
Відкрийте `index.html` через розширення Live Server у VS Code (service worker не працює, якщо відкрити файл просто подвійним кліком).

API для розділу «Мої проєкти» і форми:
```
cd server
npm install
npm start
```

## Деплой
Сайт опублікований на Vercel: Add New Project → репозиторій `Kirito072024/SAO` → Framework Preset **Other**, команду збірки не вказувати, Output Directory — корінь проєкту (сайт на чистому HTML, `src/output.css` уже лежить у репозиторії). Після кожного `git push` у `main` Vercel сам оновлює сайт.

## PWA
- `manifest.json` — назва, `display: standalone`, кольори, іконки 192 і 512 px
- `sw.js` — при першому відкритті кешує сторінку, стилі, скрипт, новини й картинки. Сторінка й новини завантажуються спершу з мережі (щоб після деплою була свіжа версія), а без інтернету — з кешу
- Перевірка: DevTools → Application → Manifest і Service workers

## Tailwind CSS
Секції «Персонажі», «Клани та гільдії» та кнопка форми стилізовані utility-класами Tailwind (`grid`, `gap-4`, `shadow-md`, `md:` / `lg:`), кольори проєкту додано в `@theme` у `src/input.css`.

Збірка стилів (потрібен Node.js 20+):
```
npm install
npx @tailwindcss/cli -i ./src/input.css -o ./src/output.css --minify
```

## Tailwind проти звичайного CSS
У Tailwind зручніше те, що стилі пишуться прямо в HTML без вигадування назв класів, а адаптивність робиться префіксами `md:` і `lg:` без окремих media-запитів. У звичайному CSS чистіший HTML і зручніше підтримувати спільні стилі в одному місці, бо в Tailwind довгі набори класів повторюються на кожній картці. Тому типографіку, змінні та тему я залишив у звичайному CSS, а картки й кнопку зробив через Tailwind.

## Автор
[Kirito072024](https://github.com/Kirito072024/SAO)
