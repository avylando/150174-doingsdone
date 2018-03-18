<?php

require_once 'init.php';
require_once 'data.php';

date_default_timezone_set('Europe/Moscow');

$tasks = [];
$projects = [];
$project_id = 0;
$modal_add = null;

if (!empty($_SESSION)) {

    $filtered_tasks = [];
    $show_completed = 0;

    if (isset($_GET['show_completed'])) {

        if (isset($_COOKIE['showcompl'])) {
            $_COOKIE['showcompl'] == 1 ? setcookie('showcompl', 0, strtotime('+5 days')) : setcookie('showcompl', 1, strtotime('+5 days'));
            $show_completed = $_COOKIE['showcompl'];

        } else {
            setcookie('showcompl', 1, strtotime('+5 days'));
            $show_completed = 1;
        }
    }

    if (isset($_GET['add'])) {
        $modal_add = render_template('templates/add-task.php', [
            'projects' => array_slice($projects, 1)
        ]);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add-task'])) {

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
                'show_completed' => $show_completed,
                'tasks' => $filtered_tasks
            ]);

        } else {
            $page_content = render_template('templates/error.php', [
                'error' => 'Проект не найден'
            ]);
            http_response_code(404);
        }

    } else {
        $page_content = render_template('templates/index.php', [
            'show_completed' => $show_completed,
            'tasks' => $tasks
        ]);
    }

} else {

    if (isset($_GET['login'])) {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['enter'])) {
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
                try {
                    $current_user = search_user_by_email($db_link, $login['email']);

                    if (!empty($current_user)) {
                        if (password_verify($login['password'], $current_user['password'])) {
                            $_SESSION['user'] = $current_user;
                            header('Location: /index.php');
                            exit();
                        }

                        $errors['password'] = 'Вы ввели неверный пароль';

                    } else {
                        $errors['email'] = 'Пользователь не найден';
                    }

                } catch (Exception $error)  {
                    $page_content = render_template('templates/error.php', ['error' => $error->getMessage()]);
                }
            }
        }

        $modal_add = render_template('templates/modal-authorization.php', [
            'login' =>$login,
            'errors' => $errors
        ]);

        $page_content = render_template('templates/guest.php');

    } else {
        $page_content = render_template('templates/guest.php');
    }
}

$layout_content = render_template('templates/layout.php', [
    'title' => 'Дела в порядке',
    'projects' => $projects,
    'project_id' => $project_id,
    'tasks' => $tasks,
    'content' => $page_content,
    'modal_add' => $modal_add,
    'session' => check_authorization($_SESSION)
]);

print($layout_content);

?>
