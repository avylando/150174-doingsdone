<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $project = $_POST;

    if (empty($project['name'])) {
        echo 'Введите название проекта';
        exit();
    }

    if (strlen($project['name']) < 3) {
        echo 'В названии должно быть более 3х символов';
        exit();
    }

    try {
        $user_id = $_SESSION['user']['id'] ?? 'NULL';

        $result = add_project($db_link, $project, $user_id);

        if ($result) {
            echo 'Project added!';
            exit();
        }

    } catch (Exception $error)  {
        $page_content = render_template('templates/error.php', ['error' => $error->getMessage()]);
    }
}
