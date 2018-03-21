'use strict';

(function () {
  var modalAdd = document.querySelector('.modal-add'),
      modalAddclose = modalAdd.querySelector('.modal__close'),
      openAddBtn = document.querySelector('.button-add');

      function modalShowHandler() {
        if (modalAdd.classList.contains('modal--hide')) {
          modalAdd.classList.remove('modal--hide');
        }

        if (!document.body.classList.contains('overlay')) {
          document.body.classList.add('overlay');
        }
      }

      function modalCloseHandler() {
        if (!modalAdd.classList.contains('modal--hide')) {
          modalAdd.classList.add('modal--hide');
        }

        if (document.body.classList.contains('overlay')) {
          document.body.classList.remove('overlay');
        }
      }

      openAddBtn.addEventListener('click', modalShowHandler);
      modalAddclose.addEventListener('click', modalCloseHandler);
})();
