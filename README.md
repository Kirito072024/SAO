# SAO — Айнкрад

Фан-сайт про Sword Art Online: механіка гри, історія «смертельної гри», головні герої та гільдії Айнкрада. Навчальний проєкт з курсу «WEB-технології та WEB-дизайн».

## Що на сайті
- Головна, Айнкрад, Механіка гри, Історія
- Персонажі та клани у вигляді карток
- Форма зворотного зв'язку
- Блок «Цікавий факт»

## Технології
HTML5 (семантична розмітка), CSS3 (custom properties, flexbox, grid, transition), JavaScript (DOM, події, валідація форми), Tailwind CSS v4, Google Fonts (Exo 2, Inter), Git.

## Структура проєкту
```
SAO/
├── index.html
├── style.css
├── script.js
├── package.json
├── src/
│   ├── input.css      (вхідний файл Tailwind + кольори теми)
│   └── output.css     (згенерований файл, не редагувати вручну)
├── CONCEPT.md
├── README.md
└── images/
    ├── aincrad.jpg
    ├── kirito.jpg
    └── asuna.jpg
```

## Як запустити
Відкрийте `index.html` у браузері або запустіть через розширення Live Server у VS Code.

## Tailwind CSS
Секції «Персонажі», «Клани та гільдії» та кнопка форми стилізовані utility-класами Tailwind (`grid`, `gap-4`, `shadow-md`, `md:` / `lg:`), кольори проєкту додано в `@theme` у `src/input.css`.

Збірка стилів (потрібен Node.js 20+):
```
npm install
npx @tailwindcss/cli -i ./src/input.css -o ./src/output.css --watch
```

## Tailwind проти звичайного CSS
У Tailwind зручніше те, що стилі пишуться прямо в HTML без вигадування назв класів, а адаптивність робиться префіксами `md:` і `lg:` без окремих media-запитів. У звичайному CSS чистіший HTML і зручніше підтримувати спільні стилі в одному місці, бо в Tailwind довгі набори класів повторюються на кожній картці. Тому типографіку, змінні та тему я залишив у звичайному CSS, а картки й кнопку зробив через Tailwind.

## Автор
[Kirito072024](https://github.com/Kirito072024/SAO)
