'use strict';

(function () {
  window.backend = {
    load: function (onLoad, onError, url, parameter = '') {
      var  xhr = new XMLHttpRequest();

      xhr.responseType = 'json';
      xhr.addEventListener('load', function () {

        switch (xhr.status) {
          case 200:
          console.log(xhr);
            onLoad(xhr.response);
            break;

          case 404:
            onError('Ошибка ' + xhr.status + ' ' + xhr.statusText + 'Данные не найдены');
            break;

          default:
            onError('Произошла ошибка: ' + xhr.status + ' ' + xhr.statusText);
        }
      });

      xhr.addEventListener('error', function () {
        onError('Ошибка соединения с сервером');
      });

      xhr.addEventListener('timeout', function () {
        onError('Истек таймаут соединения с сервером');
      });

      xhr.timeout = 10000;
      xhr.open("GET", url + parameter, true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.send();
    },

    save: function (data, onLoad, onError, url) {
      var xhr = new XMLHttpRequest();

      // xhr.responseType = 'json';
      xhr.addEventListener('load', function () {
        switch (xhr.status) {
          case 200: onLoad();
            break;

          default:
            onError('Произошла ошибка: ' + xhr.status + ' ' + xhr.statusText);
        }
      });

      xhr.addEventListener('error', function () {
        onError('Ошибка соединения. Обновите страницу и повторите запрос');
      });

      xhr.addEventListener('timeout', function () {
        onError('Истек таймаут соединения с сервером');
      });

      xhr.timeout = 10000;
      xhr.open('POST', url);
      xhr.send(data);
    }
  };
})();
