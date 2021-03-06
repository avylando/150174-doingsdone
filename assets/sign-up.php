<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $signup = $_POST;
    $required = ['username', 'email', 'password'];
    $dict = [
        'username' => 'Имя',
        'email' => 'E-mail',
        'password' => 'пароль'
    ];

    // $signup['contacts'] = $signup['contacts'] ?? null;

    foreach ($required as $field) {
        if (empty($signup[$field])) {
            $errors[$field] = 'Введите ' .$dict[$field];
        }
    }

    if (empty($errors)) {
        if (strlen($signup['username']) < 3) {
            echo 'В имени должно быть 3 или более символов';
            exit();
        }

        if (!filter_var($signup['email'], FILTER_VALIDATE_EMAIL)) {
            echo "Введите корректный Email";
            exit();
        }

        if (strlen($signup['password']) < 6) {
            echo 'Введите надежный пароль (от 6 символов)';
            exit();
        }

        if (!empty($signup['contacts'])) {
            if (!ctype_digit($signup['contacts'])) {
                echo 'Введите корректный номер телефона (допускаются только цифры)';
                exit();
            }

            if (strlen($signup['contacts']) < 5) {
                echo 'В телефоне должно быть 5 или более символов';
                exit();
            }
        }

        try {
            $user = search_user_by_email($db_link, $signup['email']);

            if (!empty($user)) {
                echo 'Пользователь с таким адресом уже зарегистрирован';
                exit();
            }

            mysqli_query($db_link, "START TRANSACTION");

            $res1 = add_user($db_link, $signup);

            $user_id = mysqli_insert_id($db_link);

            $res2 = add_default_projects($db_link, $user_id);

            if ($res1 && $res2) {
                mysqli_query($db_link, "COMMIT");
                echo 'Sign up!';
                exit();

            } else {
                mysqli_query($db_link, "ROLLBACK");
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
    $page_content = render_template('templates/signup.php', []);
}
