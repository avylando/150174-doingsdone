<?php

require_once 'init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task = $_POST;
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
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {
            $tmp_name = $_FILES['file']['tmp_name'];
            $path = 'img/' . $_FILES['file']['name'];

            $file_info = finfo_open(FILEINFO_MIME_TYPE);
            $file_type = finfo_file($file_info, $tmp_name);
            $valid_types = ['image/jpeg', 'image/png', 'image/gif', 'application/pdf', ' application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
            $validity = false;

            foreach($valid_types as $type) {
                if ($file_type === $type) {
                    $validity = true;
                    break;
                }
            }

            if (!$validity) {
                echo 'Неподдерживаемый формат. Загрузите файл в формате JPG/PNG/GIF';
                exit();

            } else {
                move_uploaded_file($tmp_name, $path);
                $task['file'] = $path;
            }
        }

        try {

            $task['expiration_date'] === '' ? $task['expiration_date'] = NULL : $task['expiration_date'];
            $task['file'] = $task['file'] ?? NULL;
            $user_id = $_SESSION['user']['id'] ?? NULL;

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
