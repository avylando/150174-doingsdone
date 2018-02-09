<?php

require_once 'functions.php';
// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

$projects = ['Все', 'Входящие', 'Учеба', 'Работа', 'Домашние дела', 'Авто'];
$tasks = [
    0 => [
        'title' => 'Собеседование в IT компании',
        'date' => '01.06.2018',
        'category' => $projects[3],
        'complete' => false
    ],

    1 => [
        'title' => 'Выполнить тестовое задание',
        'date' => '25.05.2018',
        'category' => $projects[3],
        'complete' => false
    ],

    2 => [
        'title' => 'Сделать задание первого раздела',
        'date' => '21.04.2018',
        'category' => $projects[2],
        'complete' => true
    ],

    3 => [
        'title' => 'Встреча с другом',
        'date' => '22.04.2018',
        'category' => $projects[1],
        'complete' => false
    ],

    4 => [
        'title' => 'Купить корм для кота',
        'date' => '',
        'category' => $projects[4],
        'complete' => false
    ],

    5 => [
        'title' => 'Заказать пиццу',
        'date' => '',
        'category' => $projects[4],
        'complete' => false
    ],
];

date_default_timezone_set('Europe/Moscow');

$page_content = render_template('templates/index.php', [
    'tasks' => $tasks
]);

$layout_content = render_template('templates/layout.php', [
    'title' => 'Дела в порядке',
    'projects' => $projects,
    'tasks' => $tasks,
    'content' => $page_content
]);

print($layout_content);

?>
