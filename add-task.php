<?php

require_once 'init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task = $_POST;
    // $task
    // print_r($_POST);
    $required = ['name', 'project'];
    $dict = [
        'name' => 'название задачи',
        'project' => 'Выберите проект'
    ];

    $errors = [];

    foreach ($required as $field) {

        if (empty($task[$field])) {
            $errors[$field] = 'Заполните ' . $dict[$field];
        }
    }

    if (empty($errors)) {
        if (is_uploaded_file($_FILES['attach']['tmp_name'])) {
            $tmp_name = $_FILES['attach']['tmp_name'];
            $path = 'img/' . $_FILES['attach']['name'];

            $file_info = finfo_open(FILEINFO_MIME_TYPE);
            $file_type = finfo_file($file_info, $tmp_name);

            if ($file_type !== 'image/jpeg' && $file_type !== 'image/png' && $file_type !== 'image/gif') {
                echo 'Неподдерживаемый формат. Загрузите файл в формате JPG/PNG/GIF';
                exit();

            } else {
                move_uploaded_file($tmp_name, $path);
                $task['attach'] = $path;
            }
        }

        try {
            $task['attach'] = $task['attach'] ?? null;
            $user_id = $_SESSION['user']['id'] ?? 0;
            // print($user_id);
            $result = add_task($db_link, $task, $user_id);

            if ($result) {
                echo 'Task added!';
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
}
