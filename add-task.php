<?php

require_once 'init.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add-task'])) {

    if (isset($_POST['add-task'])) {
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

        if (is_uploaded_file($_FILES['file']['tmp_name'])) {
            $tmp_name = $_FILES['file']['tmp_name'];
            $path = 'img/' . $_FILES['file']['name'];

            $file_info = finfo_open(FILEINFO_MIME_TYPE);
            $file_type = finfo_file($file_info, $tmp_name);

            if ($file_type !== 'image/jpeg' && $file_type !== 'image/png' && $file_type !== 'image/gif') {
                $errors['file'] = 'Неподдерживаемый формат. Загрузите файл в формате JPG/PNG/GIF';

            } else {
                move_uploaded_file($tmp_name, $path);
                $task['file'] = $path;
            }
        }

        if (count($errors)) {
            $modal_add = render_template('templates/add-task.php', [
                'task' => $task,
                'errors' => $errors,
                'projects' => array_slice($projects, 1)
            ]);

        } else {
            try {
                add_task($db_link, $task, $_SESSION['user']['id']);
            } catch (Exception $error) {
                print($error->getMessage());
            }
        }
    }
}
