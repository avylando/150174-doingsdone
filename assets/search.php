<?php

$phrase = $_POST['phrase'];

if ($phrase) {
    try {
        $filtered_tasks = search_tasks_by_keyword($db_link, $phrase);

    } catch (Exception $error) {
        $page_content = render_template('templates/error.php', ['error' => $error->getMessage()]);
    }
}
