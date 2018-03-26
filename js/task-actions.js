'use strict';

(function () {
  let controls = document.querySelectorAll('.task__controls');

  controls.forEach(function(control) {
    let actionBtn = control.querySelector('.expand-control');
    let menu = control.querySelector('.expand-list');

    function windowClickHandler() {
      menu.classList.add('hidden');
    }

    actionBtn.addEventListener('click', function() {
      menu.classList.toggle('hidden');
        if (!menu.classList.contains('hidden')) {
        window.addEventListener('click', windowClickHandler, true);

      } else {
        window.removeEventListener('click', windowClickHandler);
      }
    })

  })

})();
