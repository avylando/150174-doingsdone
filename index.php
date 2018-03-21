<?php

require_once 'init.php';
require_once 'data.php';

date_default_timezone_set('Europe/Moscow');

$tasks = [];
$projects = [];
$project_id = 0;
$modal_add = null;
$show_completed = 0;

if (isset($_COOKIE["showcompl"])) {
    $show_completed = (intval($_COOKIE["showcompl"]) === 1) ? 0 : 1;
}

if (isset($_GET["show_completed"])) {
    setcookie("showcompl", $show_completed, strtotime("+5 days"), "/");
    header("Location: " . $_SERVER["HTTP_REFERER"]);
}

if (!empty($_SESSION)) {

    if (isset($_SESSION['user']['id'])) {
        $tasks = get_user_tasks($db_link, $_SESSION['user']['id']);
        $projects = get_user_projects($db_link, $_SESSION['user']['id']);
    }

    $project_id = intval($_GET['id']) ?? 0;

    if (isset($_GET['id'])) {
        $filtered_tasks = [];

        if ($project_id === 0) {
            $filtered_tasks = $tasks;

        } else {
            $arr = [];
            $pro_ids = [];
            foreach ($projects as $index => $project) {
                $arr[$index] = intval($project['id']);
            }

            $pro_ids = array_unique($arr);

            if (in_array($project_id, $pro_ids)) {
                foreach ($tasks as $task) {
                    if (intval($task['project_id']) === $project_id) {
                        array_push($filtered_tasks, $task);
                    }
                }

            } else {
                $page_content = render_template('templates/error.php', [
                    'error' => 'Проект не найден'
                ]);
                http_response_code(404);
            }
        }

        if (empty($page_content)) {
            $page_content = render_template('templates/index.php', [
                'projects' => $projects,
                'project_id' => $project_id,
                'show_completed' => $show_completed,
                'tasks' => $filtered_tasks
            ]);
        }

    } else {
        $page_content = render_template('templates/index.php', [
            'projects' => $projects,
            'project_id' => $project_id,
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

// print($page_content);

$layout_content = render_template('templates/layout.php', [
    'title' => 'Дела в порядке',
    'projects' => $projects,
    'project_id' => $project_id,
    'tasks' => $tasks,
    'content' => $page_content,
    'session' => check_authorization($_SESSION)
]);

print($layout_content);

?>
