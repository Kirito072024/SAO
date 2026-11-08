// Footer: підвал сайту. Рік береться автоматично через new Date().
function Footer({ author, githubUrl }) {
  return (
    <footer>
      <p>
        Фан-проєкт для навчання. Sword Art Online створив Рекі Кавахара, аніме
        зробила студія A-1 Pictures.
      </p>
      <p>
        &copy; {new Date().getFullYear()} SAO — Айнкрад
      </p>
      <p>
        Автор: <a href={githubUrl}>{author} на GitHub</a>
      </p>
    </footer>
  )
}

export default Footer
