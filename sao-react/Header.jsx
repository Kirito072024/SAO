// Header: шапка сайту. Дані та перемикач теми приходять через props.
function Header({ title, subtitle, links, theme, onToggleTheme }) {
  return (
    <header>
      {/* Кнопка теми: стан theme зберігається в App, тут лише викликаємо onToggleTheme */}
      <button type="button" className="theme-toggle" onClick={onToggleTheme}>
        {theme === 'dark' ? '☀️ День' : '🌙 Ніч'}
      </button>

      <h1>{title}</h1>
      <p>{subtitle}</p>

      <nav aria-label="Головне меню">
        <a className="logo" href="#home">
          SAO
        </a>

        <ul>
          {links.map((link) => (
            <li key={link.href}>
              <a href={link.href}>{link.label}</a>
            </li>
          ))}
        </ul>
      </nav>
    </header>
  )
}

export default Header
