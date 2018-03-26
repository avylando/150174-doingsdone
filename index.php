<?php

require_once 'assets/init.php';

date_default_timezone_set('Europe/Moscow');

$tasks = [];
$projects = [];
$project_id = intval($_GET['project_id']) ?? 0;
$filtered_tasks = [];
$show_completed = 0;
$filter = null;
$title = 'Дела в порядке';

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

    if (isset($_GET['filter'])) {
        require_once 'assets/task-filter.php';
    }

    if (isset($_GET['search'])) {
        require_once 'assets/search.php';
    }

    if (isset($_GET['add-task'])) {
        require_once 'assets/add-task.php';
    }

    if (isset($_GET['project'])) {
        require_once 'assets/add-project.php';
    }

    if (isset($_GET['complete_task']) || isset($_GET['delete_task'])) {
        require_once 'assets/task-actions.php';
    }

    foreach($filtered_tasks as &$task) {
        if (!empty($task['file'])) {
            $array = explode('/', $task['file']);
            $task['filename'] = array_pop($array);

            if (strlen($task['filename']) > 15) {
                $arr = explode('.', $task['filename']);
                $ext = array_pop($arr);
                $task['filename'] = stristr($task['filename'], ' ', true) . '.. .' . $ext;
            }
        }
    }

    unset($task);

    if (empty($page_content)) {
        $page_content = render_template('templates/index.php', [
            'projects' => $projects,
            'project_id' => $project_id,
            'show_completed' => $show_completed,
            'filter' => $filter,
            'tasks' => $filtered_tasks
        ]);
    }

} else {
    require_once 'assets/login.php';
}

if (isset($_GET['signup'])) {
    require_once 'assets/sign-up.php';
}

$layout_content = render_template('templates/layout.php', [
    'title' => $title,
    'projects' => $projects,
    'project_id' => $project_id,
    'tasks' => $tasks,
    'content' => $page_content,
    'session' => check_authorization($_SESSION)
]);

print($layout_content);

?>
