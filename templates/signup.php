<section class="content__side">
    <p class="content__side-info">Если у вас уже есть аккаунт, авторизуйтесь на сайте</p>

    <button class="button button--transparent content__side-button button--login">Войти</button>
</section>

<main class="content__main">
    <h2 class="content__main-heading">Регистрация аккаунта</h2>

    <form class="form form-signup" action="index.php" method="post">
        <div class="form__row form__row--name">
            <label class="form__label" for="sign-name">Имя <sup>*</sup></label>

            <input class="form__input" type="text" name="username" id="sign-name" placeholder="Введите Имя">

            <p class="form__message"></p>
        </div>

        <div class="form__row form__row--email">
            <label class="form__label" for="sign-email">E-mail <sup>*</sup></label>

            <input class="form__input" type="text" name="email" id="sign-email" placeholder="Введите e-mail">

            <p class="form__message"></p>
        </div>

        <div class="form__row form__row--password">
            <label class="form__label" for="sign-password">Пароль <sup>*</sup></label>

            <input class="form__input" type="password" name="password" id="sign-password" placeholder="Введите пароль">

            <p class="form__message"></p>
        </div>

        <div class="form__row form__row--contacts">
            <label class="form__label" for="sign-contacts">Номер телефона</label>

            <input class="form__input" type="text" name="contacts" id="sign-contacts" placeholder="Введите номер телефона">

            <p class="form__message"></p>
        </div>

        <div class="form__row form__row--controls">
            <p class="error-message"></p>

            <button class="button" type="submit" name="signup">Зарегистрироваться</button>
        </div>
    </form>
</main>
