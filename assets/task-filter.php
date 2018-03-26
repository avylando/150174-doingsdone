<?php

$filter = $_GET['filter'];

if ($filter === 'today') {
    $array = [];

    foreach($filtered_tasks as $task) {
        if(!empty($task['expiration_date']) && count_days($task['expiration_date']) === 0) {
            array_push($array, $task);
        }
    }

    $filtered_tasks = $array;
}

if ($filter === 'tomorrow') {
    $array = [];

    foreach($filtered_tasks as $task) {
        if(!empty($task['expiration_date']) && count_days($task['expiration_date']) === 1) {
            array_push($array, $task);
        }
    }

    $filtered_tasks = $array;
    $filter = 'tomorrow';
}

if ($filter === 'expired') {
    $array = [];

    foreach($filtered_tasks as $task) {
        if(!empty($task['expiration_date']) && empty($task['complete_date']) && count_days($task['expiration_date']) < 0) {
            array_push($array, $task);
        }
    }

    $filtered_tasks = $array;
    $filter = 'expired';
}
