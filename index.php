<?php

require_once 'functions.php';
require_once 'data.php';

date_default_timezone_set('Europe/Moscow');

$filtered_tasks = [];
$modal_add_add = null;

if (isset($_GET['add'])) {
    $modal_add = render_template('templates/add-task.php', [
        'projects' => array_slice($projects, 1)
    ]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add-task'])) {
        $task = $_POST;
        $required = ['title', 'category'];
        $dict = [
            'title' => 'название задачи',
            'category' => 'Выберите проект'
        ];

        $errors = [];

        foreach ($required as $field) {
            if (empty($task[$field])) {
                $errors[$field] = 'Заполните ' . $dict[$field];
            }
        }

        if (is_uploaded_file($_FILES['task-image']['tmp_name'])) {
            $tmp_name = $_FILES['task-image']['tmp_name'];
            $path = 'img/' . $_FILES['task-image']['name'];

            $file_info = finfo_open(FILEINFO_MIME_TYPE);
            $file_type = finfo_file($file_info, $tmp_name);

            if ($file_type !== 'image/jpeg' && $file_type !== 'image/png' && $file_type !== 'image/gif') {
                $errors['task-image'] = 'Неподдерживаемый формат. Загрузите файл в формате JPG/PNG/GIF';
            } else {
                move_uploaded_file($tmp_name, $path);
                $task['task-image'] = $path;
            }
        }

        if (count($errors)) {
            $modal_add = render_template('templates/add-task.php', [
                'task' => $task,
                'errors' => $errors,
                'projects' => array_slice($projects, 1)
            ]);
        } else {
            array_unshift($tasks, [
            'title' => $task['title'],
            'date' => $task['date'],
            'category' => $task['category'],
            'task-image' => $task['task-image'],
            'complete' => false
            ]);
        }
    }
}

if (isset($_GET['id'])) {
    $project_id = $_GET['id'];

    if (isset($projects[$project_id])) {
        foreach ($tasks as $task) {
            if ($task['category'] === $projects[$project_id]) {
                array_push($filtered_tasks, $task);
            }

            if ($projects[$project_id] === 'Все') {
                array_push($filtered_tasks, $task);
            }
        }

        $page_content = render_template('templates/index.php', [
            'tasks' => $filtered_tasks
        ]);
    } else {
        http_response_code(404);
    }

} else {
    $page_content = render_template('templates/index.php', [
        'tasks' => $tasks
    ]);
}

$layout_content = render_template('templates/layout.php', [
    'title' => 'Дела в порядке',
    'projects' => $projects,
    'tasks' => $tasks,
    'content' => $page_content,
    'modal_add' => $modal_add,
]);

print($layout_content);

?>
