<?php

$filter = $_GET['filter'] ?? null;

if (isset($_GET['complete_task']) && isset($_GET['task_id'])) {
    $complete = intval($_GET['complete_task']);
    $task_id = intval($_GET['task_id']);

    try {
        $result = change_task_completion($db_link, $complete, $task_id);

        if ($result) {
            header('Location: /index.php?project_id=' .$project_id. '&filter=' .$filter);
            exit();
        }

    } catch (Exception $error)  {
        $page_content = render_template('templates/error.php', ['error' => $error->getMessage()]);
    }
}

if (isset($_GET['delete_task'])) {
    $task_id = $_GET['delete_task'];

    try {
        $result = delete_task($db_link, $task_id);

        if ($result) {
            header('Location: /index.php?project_id=' .$project_id. '&filter=' .$filter);
            exit();
        }

    } catch (Exception $error)  {
        $page_content = render_template('templates/error.php', ['error' => $error->getMessage()]);
    }
}
