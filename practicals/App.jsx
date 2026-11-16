import Header from './components/Header'
import Footer from './components/Footer'
import Section from './components/Section'
import Card from './components/Card'

// Пункти меню (передаються в Header через props)
const navLinks = [
  { href: '#home', label: 'Головна' },
  { href: '#characters', label: 'Персонажі' },
  { href: '#clans', label: 'Клани' },
]

// Крок 5: масив даних — персонажі (аналог масиву projects з аркуша)
const characters = [
  {
    id: 1,
    title: 'Кіріто',
    text: 'Гравець-одинак і колишній бета-тестер. Єдиний, хто володіє навичкою двох мечів.',
    image: '/images/kirito.jpg',
  },
  {
    id: 2,
    title: 'Асуна',
    text: 'Майстриня рапіри, заступниця командира гільдії Лицарі Кривавої Клятви.',
    image: '/images/asuna.jpg',
  },
  {
    id: 3,
    title: 'Клейн',
    text: 'Перший друг Кіріто в грі та лідер гільдії Фурінкадзан. Воїн із катаною.',
    image: '/images/klein.jpg',
  },
  {
    id: 4,
    title: 'Юі',
    text: 'Штучний інтелект, якого Кіріто й Асуна знаходять на 22-му поверсі та ростять як доньку.',
    image: '/images/yui.jpg',
  },
]

// Масив гільдій (картки без зображення)
const guilds = [
  {
    id: 1,
    title: 'Лицарі Кривавої Клятви',
    text: 'Найсильніша гільдія Айнкрада, її очолює Хізкліф.',
  },
  {
    id: 2,
    title: 'Aincrad Liberation Force («Армія»)',
    text: 'Найбільша гільдія гри, що стежила за порядком на нижніх поверхах.',
  },
  {
    id: 3,
    title: 'Фурінкадзан',
    text: 'Дружня гільдія Клейна, яка часто допомагає Кіріто.',
  },
  {
    id: 4,
    title: 'Laughing Coffin',
    text: 'Злий клан убивць на чолі з PoH, що вбивав гравців заради розваги.',
  },
]

function App() {
  return (
    <>
      <Header
        title="Sword Art Online: Айнкрад"
        subtitle="Фан-сайт про механіку гри, історію та героїв"
        links={navLinks}
      />

      <main>
        <Section id="home" title="Ласкаво просимо">
          <p>
            6 листопада 2022 року десять тисяч гравців увійшли в гру Sword Art
            Online і не змогли з неї вийти. Тут ти дізнаєшся, як влаштований
            світ гри, що сталося на початку та хто в ньому виживав.
          </p>
        </Section>

        {/* Крок 6: список карток через map, key — унікальний id */}
        <Section id="characters" title="Персонажі">
          {characters.map((character) => (
            <Card
              key={character.id}
              title={character.title}
              text={character.text}
              image={character.image}
            />
          ))}
        </Section>

        <Section id="clans" title="Клани та гільдії">
          {guilds.map((guild) => (
            <Card key={guild.id} title={guild.title} text={guild.text} />
          ))}
        </Section>
      </main>

      <Footer author="Kirito072024" githubUrl="https://github.com/Kirito072024/SAO" />
    </>
  )
}

export default App
