<?php

function render_template($template_file_path, $data) {
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

?>
