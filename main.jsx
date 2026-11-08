import { StrictMode } from 'react'
import { createRoot } from 'react-dom/client'
import './index.css' // стилі проєкту (копія style.css зі статичного сайту)
import App from './App.jsx'

createRoot(document.getElementById('root')).render(
  <StrictMode>
    <App />
  </StrictMode>,
)
