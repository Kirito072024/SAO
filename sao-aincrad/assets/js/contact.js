/* =========================================================
   Форма зворотного зв'язку: перевірка полів і відправка
   на REST API WordPress (POST /wp-json/sao/v1/contact).
   Адреса та nonce приходять з PHP через wp_localize_script → window.saoContact
   ========================================================= */
(function () {
  'use strict';

  var form = document.getElementById('contact-form');
  if (!form || !window.saoContact) return;

  var formMessage = document.getElementById('form-message');
  var submitButton = form.querySelector('button[type="submit"]');
  var submitText = submitButton.textContent;

  var fields = {
    name: form.querySelector('#name'),
    email: form.querySelector('#email'),
    phone: form.querySelector('#phone'),
    topic: form.querySelector('#topic'),
    message: form.querySelector('#message'),
    agree: form.querySelector('#agree'),
    website: form.querySelector('#website') // пастка для ботів
  };

  function showMessage(text, type) {
    formMessage.textContent = text;
    formMessage.classList.remove('error', 'success');
    formMessage.classList.add(type);
  }

  function getEmailError(email) {
    if (email === '') return 'Введіть електронну пошту.';
    if (email.indexOf('@') === -1) return 'Email має містити символ «@».';
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) return 'Перевірте формат email, наприклад name@example.com.';
    return '';
  }

  // формат +380XXXXXXXXX; пробіли, дужки й дефіси дозволені
  function getPhoneError(phone) {
    if (phone === '') return 'Введіть номер телефону.';
    if (!/^\+380\d{9}$/.test(phone.replace(/[\s()-]/g, ''))) {
      return 'Телефон має бути у форматі +380XXXXXXXXX (9 цифр після +380).';
    }
    return '';
  }

  // Підказка під полем під час введення
  function attachInlineValidation(input, hint, getError, okText) {
    input.addEventListener('input', function () {
      var value = input.value.trim();
      hint.classList.remove('error', 'success');
      input.classList.remove('valid', 'invalid');

      if (value === '') {
        hint.textContent = '';
        input.removeAttribute('aria-invalid');
        return;
      }

      var error = getError(value);
      hint.textContent = error || okText;
      hint.classList.add(error ? 'error' : 'success');
      input.classList.add(error ? 'invalid' : 'valid');
      input.setAttribute('aria-invalid', error ? 'true' : 'false');
    });
  }

  attachInlineValidation(fields.email, document.getElementById('email-hint'), getEmailError, 'Email виглядає правильно.');
  attachInlineValidation(fields.phone, document.getElementById('phone-hint'), getPhoneError, 'Телефон виглядає правильно.');

  form.addEventListener('submit', async function (event) {
    event.preventDefault();

    var data = {
      name: fields.name.value.trim(),
      email: fields.email.value.trim(),
      phone: fields.phone.value.trim(),
      topic: fields.topic.value,
      message: fields.message.value.trim(),
      agree: fields.agree.checked ? 1 : 0,
      website: fields.website.value
    };

    var errors = [];
    if (data.name === '') errors.push("Введіть ім'я.");
    var emailError = getEmailError(data.email);
    if (emailError) errors.push(emailError);
    var phoneError = getPhoneError(data.phone);
    if (phoneError) errors.push(phoneError);
    if (data.message === '') errors.push('Напишіть повідомлення.');
    if (!data.agree) errors.push('Потрібна згода на обробку даних.');

    if (errors.length) {
      showMessage(errors.join('\n'), 'error');
      form.classList.remove('shake');
      void form.offsetWidth;
      form.classList.add('shake'); // коротке «тремтіння» форми
      return;
    }

    submitButton.disabled = true;
    submitButton.textContent = 'Надсилання…';
    formMessage.textContent = '';
    formMessage.classList.remove('error', 'success');

    try {
      var response = await fetch(window.saoContact.restUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-WP-Nonce': window.saoContact.nonce
        },
        body: JSON.stringify(data)
      });
      var result = await response.json().catch(function () { return {}; });

      if (!response.ok || !result.ok) {
        // WP_Error приходить як { code, message, data: { status } }
        throw new Error(result.message || 'Сервер повернув помилку.');
      }

      showMessage('Дякуємо, ' + data.name + '! Повідомлення надіслано — відповімо найближчим часом.', 'success');
      form.reset();
      form.querySelectorAll('.valid, .invalid').forEach(function (el) { el.classList.remove('valid', 'invalid'); });
      form.querySelectorAll('.field-hint').forEach(function (el) { el.textContent = ''; });
    } catch (error) {
      var reason = !navigator.onLine ? "Немає з'єднання з інтернетом." : error.message;
      showMessage('Не вдалося надіслати повідомлення. ' + reason, 'error');
    } finally {
      submitButton.disabled = false;
      submitButton.textContent = submitText;
    }
  });
})();
