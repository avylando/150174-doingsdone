<?php

require_once 'mysql_helper.php';

function render_template($template_file_path, $data = []) {
    if (file_exists($template_file_path)) {
        ob_start();
        extract($data);
        require_once $template_file_path;
        return ob_get_clean();
    }

    return '';
}

function task_counter ($tasks, $category) {
    $counter = 0;
    foreach ($tasks as $task) {
        if ($task['category'] === $category) {
            $counter++;
        } else if ($category === 'Все') {
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

?>
