<?php

// показывать или нет выполненные задачи
$show_complete_tasks = rand(0, 1);

$projects = ['Все', 'Входящие', 'Учеба', 'Работа', 'Домашние дела', 'Авто'];
$tasks = [
    [
        'title' => 'Собеседование в IT компании',
        'date' => '01.06.2018',
        'category' => $projects[3],
        'complete' => false
    ],

    [
        'title' => 'Выполнить тестовое задание',
        'date' => '25.05.2018',
        'category' => $projects[3],
        'complete' => false
    ],

    [
        'title' => 'Сделать задание первого раздела',
        'date' => '21.04.2018',
        'category' => $projects[2],
        'complete' => true
    ],

    [
        'title' => 'Встреча с другом',
        'date' => '22.04.2018',
        'category' => $projects[1],
        'complete' => false
    ],

    [
        'title' => 'Купить корм для кота',
        'date' => '',
        'category' => $projects[4],
        'complete' => false
    ],

    [
        'title' => 'Заказать пиццу',
        'date' => '',
        'category' => $projects[4],
        'complete' => false
    ],
];

?>
