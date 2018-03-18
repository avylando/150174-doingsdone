<div class="modal">
  <a class="modal__close" href='/' name="button">Закрыть</a>

  <h2 class="modal__heading">Вход на сайт</h2>

  <form class="form" action="/?login" method="post">
    <div class="form__row">
      <label class="form__label" for="email">E-mail <sup>*</sup></label>

      <input class="form__input <?=!empty($errors['email']) ? 'form__input--error' : ''?>" type="text" name="email" id="email" value="<?=!empty($login['email']) ? $login['email'] : ''?>" placeholder="Введите e-mail">
    <?php if (!empty($errors['email'])): ?>
      <p class="form__message"><?=$errors['email']?></p>
    <? endif;?>
    </div>

    <div class="form__row">
      <label class="form__label" for="password">Пароль <sup>*</sup></label>

      <input class="form__input <?=!empty($errors['password']) ? 'form__input--error' : ''?>" type="password" name="password" id="password" value="<?=!empty($login['password']) ? $login['password'] : ''?>" placeholder="Введите пароль">
    <?php if (!empty($errors['password'])): ?>
      <p class="form__message"><?=$errors['password']?></p>
    <? endif;?>
    </div>

    <div class="form__row form__row--controls">
      <input class="button" type="submit" name="enter" value="Войти">
    </div>
  </form>
</div>
