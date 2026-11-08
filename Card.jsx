import { useState } from 'react'

// Card: одна картка (персонаж або гільдія).
// title, text та image приходять через props, а лічильник «вподобань»
// — це власний стан кожної картки (useState).
function Card({ title, text, image }) {
  // Крок 1: count — поточне значення, setCount — єдиний спосіб його змінити
  const [likes, setLikes] = useState(0)

  return (
    <article>
      <h3>{title}</h3>
      {image && <img src={image} alt={title} />}
      <p>{text}</p>

      {/* Крок 2: onClick збільшує лічильник тільки цієї картки */}
      <button type="button" className="like-btn" onClick={() => setLikes(likes + 1)}>
        ♥ Подобається: {likes}
      </button>
    </article>
  )
}

export default Card
