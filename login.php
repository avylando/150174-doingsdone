<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['login'])) {
    $login = $_POST;
    $required = ['email', 'password'];
    $dict = [
        'email' => 'E-mail',
        'password' => 'пароль'
    ];

    foreach ($required as $field) {
        if (empty($login[$field])) {
            $errors[$field] = 'Введите ' .$dict[$field];
        }
    }

    if (empty($errors)) {
        if (!filter_var($login['email'], FILTER_VALIDATE_EMAIL)){
            echo "Введите корректный Email";
            exit();
        }

        try {
            $current_user = search_user_by_email($db_link, $login['email']);

            if (!empty($current_user)) {
                if (password_verify($login['password'], $current_user['password'])) {
                    $_SESSION['user'] = $current_user;
                    echo 'Authorization complete!';
                    exit();
                    // header('Location: /');
                    // exit();
                }

                // $errors['password'] = 'Вы ввели неверный пароль';
                echo 'Неверный пароль';
                exit();

            } else {
                // $errors['email'] = 'Пользователь не найден';
                echo 'Пользователь не найден';
                exit();
            }

        } catch (Exception $error)  {
            $page_content = render_template('templates/error.php', ['error' => $error->getMessage()]);
        }

    } else {
        $response = json_encode($errors);
        echo $response;
        exit();
    }

} else {
    $page_content = render_template('templates/guest.php');
}
