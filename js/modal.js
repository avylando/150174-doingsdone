'use strict';

(function () {
  var modalAdd = document.querySelector('.modal-add-task'),
      modalAddClose = modalAdd.querySelector('.modal__close'),
      openAddBtns = document.querySelectorAll('.button--add'),

      modalProject = document.querySelector('.modal-project'),
      modalProjectClose = modalProject.querySelector('.modal__close'),
      openProjectBtn = document.querySelector('.button--project'),

      modalLogin = document.querySelector('.modal-login'),
      modalLoginClose = modalLogin.querySelector('.modal__close'),
      openLoginBtns = document.querySelectorAll('.button--login'),

      modalSuccess = document.querySelector('.modal-success'),
      modalSuccessClose = modalSuccess.querySelector('.modal__close'),
      btnSuccess = modalSuccess.querySelector('.button-success');

      function modalShowHandler(modal) {
        if (modal.classList.contains('modal--hide')) {
          modal.classList.remove('modal--hide');
        }

        if (!document.body.classList.contains('overlay')) {
          document.body.classList.add('overlay');
        }
      }

      function modalCloseHandler(modal) {
        if (!modal.classList.contains('modal--hide')) {
          modal.classList.add('modal--hide');
        }

        if (document.body.classList.contains('overlay')) {
          document.body.classList.remove('overlay');
        }
      }

      openAddBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
          modalShowHandler(modalAdd);
        });
      });

      modalAddClose.addEventListener('click', function() {
        modalCloseHandler(modalAdd);
      });

      if (openLoginBtns) {
        openLoginBtns.forEach(function(btn) {
          btn.addEventListener('click', function() {
            modalShowHandler(modalLogin);
          });
        });

        modalLoginClose.addEventListener('click', function() {
          modalCloseHandler(modalLogin);
        });
      }

      if (openProjectBtn) {
        openProjectBtn.addEventListener('click', function() {
          modalShowHandler(modalProject);
        });

        modalProjectClose.addEventListener('click', function() {
          modalCloseHandler(modalProject);
        });
      }

      modalSuccessClose.addEventListener('click', function() {
        modalCloseHandler(modalSuccess);
      });

      btnSuccess.addEventListener('click', function() {
        modalCloseHandler(modalSuccess);
        modalShowHandler(modalLogin);
      });

})();
