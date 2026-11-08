// Card: одна картка (персонаж або гільдія).
// Приймає title, text та необов'язкове image через props.
function Card({ title, text, image }) {
  return (
    <article>
      <h3>{title}</h3>
      {image && <img src={image} alt={title} />}
      <p>{text}</p>
    </article>
  )
}

export default Card
