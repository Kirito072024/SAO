// Header: шапка сайту. Дані приходять через props (title, subtitle, links).
function Header({ title, subtitle, links }) {
  return (
    <header>
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
