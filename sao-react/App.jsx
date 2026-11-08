import { useState, useEffect } from 'react'
import Header from './components/Header'
import Footer from './components/Footer'
import Section from './components/Section'
import Card from './components/Card'
import './App.css'

// Пункти меню (передаються в Header через props)
const navLinks = [
  { href: '#home', label: 'Головна' },
  { href: '#characters', label: 'Картки' },
  { href: '#contacts', label: 'Контакти' },
]

// Дані карток. Поле category потрібне для фільтра: 'heroes' або 'guilds'
const cards = [
  {
    id: 1,
    category: 'heroes',
    title: 'Кіріто',
    text: 'Гравець-одинак і колишній бета-тестер. Єдиний, хто володіє навичкою двох мечів.',
    image: '/images/kirito.jpg',
  },
  {
    id: 2,
    category: 'heroes',
    title: 'Асуна',
    text: 'Майстриня рапіри, заступниця командира гільдії Лицарі Кривавої Клятви.',
    image: '/images/asuna.jpg',
  },
  {
    id: 3,
    category: 'heroes',
    title: 'Клейн',
    text: 'Перший друг Кіріто в грі та лідер гільдії Фурінкадзан. Воїн із катаною.',
    image: '/images/klein.jpg',
  },
  {
    id: 4,
    category: 'heroes',
    title: 'Юі',
    text: 'Штучний інтелект, якого Кіріто й Асуна знаходять на 22-му поверсі та ростять як доньку.',
    image: '/images/yui.jpg',
  },
  {
    id: 5,
    category: 'guilds',
    title: 'Лицарі Кривавої Клятви',
    text: 'Найсильніша гільдія Айнкрада, її очолює Хізкліф.',
  },
  {
    id: 6,
    category: 'guilds',
    title: 'Aincrad Liberation Force («Армія»)',
    text: 'Найбільша гільдія гри, що стежила за порядком на нижніх поверхах.',
  },
  {
    id: 7,
    category: 'guilds',
    title: 'Фурінкадзан',
    text: 'Дружня гільдія Клейна, яка часто допомагає Кіріто.',
  },
  {
    id: 8,
    category: 'guilds',
    title: 'Laughing Coffin',
    text: 'Злий клан убивць на чолі з PoH, що вбивав гравців заради розваги.',
  },
]

// Кнопки фільтра: value порівнюється з category у картках
const filters = [
  { value: 'all', label: 'Усі' },
  { value: 'heroes', label: 'Герої' },
  { value: 'guilds', label: 'Гільдії' },
]

// Початкова тема береться з localStorage (додаткове завдання)
function getSavedTheme() {
  try {
    return localStorage.getItem('theme') || 'dark'
  } catch {
    return 'dark'
  }
}

function App() {
  // Стан застосунку: тема, вибрана категорія та ім'я з поля форми
  const [theme, setTheme] = useState(getSavedTheme)
  const [category, setCategory] = useState('all')
  const [name, setName] = useState('')

  // Крок 4 + додаткове завдання: при зміні theme ставимо атрибут на кореневий
  // елемент <html> (CSS вже вміє data-theme="light") і зберігаємо вибір
  useEffect(() => {
    document.documentElement.setAttribute('data-theme', theme)
    try {
      localStorage.setItem('theme', theme)
    } catch {
      // localStorage недоступний — тема просто не збережеться
    }
  }, [theme])

  function toggleTheme() {
    setTheme(theme === 'dark' ? 'light' : 'dark')
  }

  // Крок 5: фільтр карток через filter()
  const visibleCards =
    category === 'all' ? cards : cards.filter((card) => card.category === category)

  return (
    <>
      <Header
        title="Sword Art Online: Айнкрад"
        subtitle="Фан-сайт про механіку гри, історію та героїв"
        links={navLinks}
        theme={theme}
        onToggleTheme={toggleTheme}
      />

      <main>
        <Section id="home" title="Ласкаво просимо">
          <p>
            6 листопада 2022 року десять тисяч гравців увійшли в гру Sword Art
            Online і не змогли з неї вийти. Тут ти дізнаєшся, як влаштований
            світ гри, що сталося на початку та хто в ньому виживав.
          </p>
        </Section>

        <Section id="characters" title="Персонажі та гільдії">
          <div className="filter-bar">
            {filters.map((filter) => (
              <button
                key={filter.value}
                type="button"
                className={category === filter.value ? 'filter-btn active' : 'filter-btn'}
                aria-pressed={category === filter.value}
                onClick={() => setCategory(filter.value)}
              >
                {filter.label}
              </button>
            ))}
          </div>

          {visibleCards.map((card) => (
            <Card key={card.id} title={card.title} text={card.text} image={card.image} />
          ))}
        </Section>

        {/* Кроки 6-7: контрольована форма — значення поля живе в стані name */}
        <Section id="contacts" title="Контакти">
          <form onSubmit={(event) => event.preventDefault()}>
            <p>
              <label htmlFor="name">Ім'я:</label>
              <input
                type="text"
                id="name"
                value={name}
                onChange={(event) => setName(event.target.value)}
                placeholder="Як до тебе звертатися"
              />
            </p>

            <p className="greeting">
              {name ? `Привіт, ${name}! Ласкаво просимо в Айнкрад.` : "Введіть ім'я, і я привітаюся."}
            </p>
          </form>
        </Section>
      </main>

      <Footer author="Kirito072024" githubUrl="https://github.com/Kirito072024/SAO" />
    </>
  )
}

export default App
