'use strict';

(function() {
  var formAuth = document.querySelector('.form-login'),
      formSignup = document.querySelector('.form-signup'),
      formAddTask = document.querySelector('.form-add-task'),
      modalSuccess = document.querySelector('.modal-success');

  function createMessage(parent, message) {
    parent.querySelector('input').classList.add('form__input--error');
    parent.querySelector('.form__message').textContent = message;
  }

  function cleanErrors(form) {
    var inputs = form.querySelectorAll('input'),
        messages = form.querySelectorAll('.form__message');
        console.log(inputs);

    inputs.forEach(function(el) {
      if (el.classList.contains('form__input--error')) {
        el.classList.remove('form__input--error');
      }
    })

    messages.forEach(function(el) {
      el.textContent = '';
    })
  }

  function onAuthSuccess(response) {
    try {
      response = JSON.parse(response);

      if (response.email) {
        createMessage(emailCell, response.email);
      }

      if (response.password) {
        createMessage(passwordCell, response.password);
      }

    } catch (err) {
      // console.error(err.message);
      if (response === 'Введите корректный Email' || response === 'Пользователь не найден') {
        createMessage(emailCell, response);
      }

      if (response === 'Неверный пароль') {
        createMessage(passwordCell, response);
      }

      if (response === 'Authorization complete!') {
        window.location.replace('/index.php');
      }
    }
  }

  function onSignSuccess(response) {
    try {
      response = JSON.parse(response);

      if (response.email) {
        createMessage(emailSetCell, response.email);
      }

      if (response.password) {
        createMessage(passwordSetCell, response.password);
      }

      if (response.username) {
        createMessage(nameSetCell, response.username);
      }

    } catch (err) {

      if (response === 'Введите корректный Email' || response === 'Пользователь с таким адресом уже зарегистрирован') {
        createMessage(emailSetCell, response);
      }

      if (response === 'Введите надежный пароль (от 6 символов)') {
        createMessage(passwordSetCell, response);
      }

      if (response === 'В имени должно быть 3 или более символов') {
        createMessage(nameSetCell, response);
      }

      if (response === 'Введите корректный номер телефона (допускаются только цифры)' || response === 'В телефоне должно быть 5 или более символов') {
        createMessage(contactsSetCell, response);
      }

      if (response === 'Sign up!') {
        if (modalSuccess.classList.contains('modal--hide')) {
          modalSuccess.classList.remove('modal--hide');
          document.body.classList.add('overlay');
        }
      }
    }
  }

  function onTaskAddSuccess(response) {
    try {
      response = JSON.parse(response);

      if (response.name) {
        createMessage(taskNameCell, response.name);
      }

      if (response.project) {
        createMessage(taskProjectCell, response.project);
      }

    } catch (err) {
      if (response === 'Неподдерживаемый формат. Загрузите файл в формате JPG/PNG/GIF') {
        createMessage(taskAttachCell, response);
      }

      if (response === 'Task added!') {
        window.location.replace('/index.php');
      }
    }
  }

  function onError(message) {
    console.log(message);
  }

  if (formAuth) {
    var emailCell = formAuth.querySelector('.form__row--email'),
        passwordCell = formAuth.querySelector('.form__row--password');

    formAuth.addEventListener('submit', function(evt) {
      cleanErrors(formAuth);
      var formData = new FormData(formAuth);
      window.ajax.save(formData, onAuthSuccess, onError, '/index.php?login');
      evt.preventDefault();
    });
  }

  if (formSignup) {
    var emailSetCell = formSignup.querySelector('.form__row--email'),
      passwordSetCell = formSignup.querySelector('.form__row--password'),
      nameSetCell = formSignup.querySelector('.form__row--name'),
      contactsSetCell = formSignup.querySelector('.form__row--contacts');

    formSignup.addEventListener('submit', function(evt) {
      cleanErrors(formSignup);
      var formData = new FormData(formSignup);
      window.ajax.save(formData, onSignSuccess, onError, '/index.php?signup');
      evt.preventDefault();
    });
  }

  if (formAddTask) {
    var taskNameCell = formAddTask.querySelector('.form__row--name'),
      taskProjectCell = formAddTask.querySelector('.form__row--project'),
      taskAttachCell = formAddTask.querySelector('.form__row--attach');

    formAddTask.addEventListener('submit', function(evt) {
      cleanErrors(formAddTask);
      var formData = new FormData(formAddTask);
      window.ajax.save(formData, onTaskAddSuccess, onError, '/index.php?add-task');
      evt.preventDefault();
    });
  }

})();
