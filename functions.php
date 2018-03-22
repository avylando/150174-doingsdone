<?php

require_once 'mysql_helper.php';

function render_template($template_file_path, $data = []) {
    if (file_exists($template_file_path)) {
        ob_start();
        extract($data);
        include $template_file_path;
        return ob_get_clean();
    }

    return '';
}

function task_counter ($tasks, $project) {
    $counter = 0;
    foreach ($tasks as $task) {
        if ($task['project'] === $project) {
            $counter++;
        } else if ($project === 'Все') {
            $counter++;
        }
    }
    return $counter;
}

function count_days($expired_date) {
    $diff = strtotime($expired_date) - time();
    $days = floor($diff / 86400);
    return $days;
}

function format_date($date) {
    if (strtotime($date)) {
        $formatted_date = date('d-m-Y', strtotime($date));

        return $formatted_date;
    }
    return 'Некорректный формат даты';
}

function check_authorization($session) {
    $result = [];

    if (isset($session['user'])) {
        $result['authorized'] = true;
        $result['user'] = $session['user'];
    }

    return $result;
}

function search_user_by_email($connect, $email) {
    if (!$connect) {
        throw new Exception(mysqli_connect_error());
    }

    $sql = "SELECT * FROM user
    WHERE email = ?";

    $input_user = mysqli_real_escape_string($connect, $email);
    $stmt = db_get_prepare_stmt($connect, $sql, [$input_user]);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        throw new Exception(mysqli_error($connect));
    }

    return $current_user = mysqli_fetch_assoc($result);
}


function get_user_tasks($connect, $user_id) {
    if (!$connect) {
        throw new Exception(mysqli_connect_error());
    }

    $sql = "SELECT task.name, file, expiration_date, complete_date, project.name AS project, project.id AS project_id
            FROM task
            INNER JOIN project ON project.id = project_id
            WHERE task.author_id = ?";

    $stmt = db_get_prepare_stmt($connect, $sql, [$user_id]);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        throw new Exception(mysqli_error($connect));
    }
    $tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);
    // print_r($tasks);
    return $tasks;
}

function get_user_projects($connect, $user_id) {
    if (!$connect) {
        throw new Exception(mysqli_connect_error());
    }

    $sql = "SELECT id, name FROM project
            WHERE project.author_id = ?";

    $stmt = db_get_prepare_stmt($connect, $sql, [$user_id]);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        throw new Exception(mysqli_error($connect));
    }

    return $projects = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function add_user($connect, $data) {
    if (!$connect) {
        throw new Exception(mysqli_connect_error());
    }

    $sql = "INSERT INTO user(name, email, password, contacts)
            VALUES(?, ?, ?, ?)";

    $password = password_hash($data['password'], PASSWORD_DEFAULT);
    $stmt = db_get_prepare_stmt($connect, $sql, [$data['username'], $data['email'], $password, $data['contacts']]);
    $result = mysqli_stmt_execute($stmt);

    if (!$result) {
        throw new Exception(mysqli_error($connect));
    }

    return $result;
}

function add_task($connect, $task, $user_id) {
    if (!$connect) {
        throw new Exception(mysqli_connect_error());
    }

    print_r($task);

    $sql = "INSERT INTO task(name, project_id, file, expiration_date, author_id)
            VALUES(?, ?, ?, ?, ?)";

    $stmt = db_get_prepare_stmt($connect, $sql, [$task['name'], $task['project'], $task['attach'], $task['expiration_date'], $user_id]);
    $result = mysqli_stmt_execute($stmt);

    if (!$result) {
        throw new Exception(mysqli_error($connect));
    }

    return $result;
}

?>
