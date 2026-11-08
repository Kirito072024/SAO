// Section (додаткове завдання): секція з пропом title і вкладеним вмістом через children.
function Section({ id, title, children }) {
  return (
    <section id={id}>
      <h2>{title}</h2>
      {children}
    </section>
  )
}

export default Section
