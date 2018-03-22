<?php

require_once 'init.php';
require_once 'data.php';

date_default_timezone_set('Europe/Moscow');

$tasks = [];
$projects = [];
$project_id = 0;
$modal_add = null;
$show_completed = 0;
$errors = [];

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
    require_once 'login.php';
}

if (isset($_GET['signup'])) {
    require_once 'signup.php';
}

if (isset($_GET['add-task'])) {
    require_once 'add-task.php';
}

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
