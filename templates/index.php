<h2 class="content__main-heading">Список задач</h2>

<form class="search-form" action="index.php?search" method="post">
    <input class="search-form__input" type="text" name="phrase" value="" placeholder="Поиск по задачам">

    <input class="search-form__submit" type="submit" name="" value="Искать">
</form>

<div class="tasks-controls">
    <nav class="tasks-switch">
        <a href="index.php?project_id=<?=$project_id?>" class="tasks-switch__item <?=empty($filter) ? 'tasks-switch__item--active' : ''?>">Все задачи</a>
        <a href="index.php?project_id=<?=$project_id?>&filter=today" class="tasks-switch__item <?=($filter === 'today') ? 'tasks-switch__item--active' : ''?>">Повестка дня</a>
        <a href="index.php?project_id=<?=$project_id?>&filter=tomorrow" class="tasks-switch__item <?=($filter === 'tomorrow') ? 'tasks-switch__item--active' : ''?>">Завтра</a>
        <a href="index.php?project_id=<?=$project_id?>&filter=expired" class="tasks-switch__item <?=($filter === 'expired') ? 'tasks-switch__item--active' : ''?>">Просроченные</a>
    </nav>

    <label class="checkbox">
        <a href="/?show_completed&project_id=<?=$project_id?>">
            <?php if(intval($show_completed) === 1): ?>
                <input class="checkbox__input visually-hidden" type="checkbox" checked>
            <?php else: ?>
                <input class="checkbox__input visually-hidden" type="checkbox">
            <?php endif; ?>
                <span class="checkbox__text">Показывать выполненные</span>
        </a>
    </label>
</div>

<?php if (!empty($tasks)): ?>
    <table class="tasks">
        <?php foreach($tasks as $task): ?>
            <?php if (!empty($task['complete_date']) && intval($show_completed) === 1): ?>
                <tr class="tasks__item task task--completed">
                    <td class="task__select">
                        <label class="checkbox task__checkbox">
                            <input class="checkbox__input visually-hidden" type="checkbox" checked>
                            <span class="checkbox__text"><?=strip_tags($task['name'])?></span>
                        </label>
                    </td>


                    <td class="task__file">
                        <?php if(!empty($task['file'])): ?>
                        <a class="download-link" href="<?=$task['file']?>"><?=$task['filename']?></a>
                        <?php endif; ?>
                    </td>


                    <td class="task__date"><?=format_date(strip_tags($task['expiration_date']))?></td>
                    <td class="task__controls">
                        <button class="expand-control" type="button" name="button">Дополнительные действия</button>
                        <ul class="expand-list hidden">
                            <li class="expand-list__item">
                                <a href="?complete_task=0&task_id=<?=$task['id']?>&project_id=<?=$project_id?>&filter=<?=$filter?>">
                                    Отметить как невыполненную
                                </a>
                            </li>
                            <li class="expand-list__item">
                                <a href="?delete_task=<?=$task['id']?>&project_id=<?=$project_id?>&filter=<?=$filter?>">
                                    Удалить
                                </a>
                            </li>
                        </ul>
                    </td>
                </tr>
            <?php endif; ?>

            <?php if (empty($task['complete_date'])): ?>
                <tr class="tasks__item task
                <?php if (count_days($task['expiration_date']) <= 1 && !empty($task['expiration_date'])): ?>
                    task--important
                <?php endif; ?>
                ">
                    <td class="task__select">
                        <label class="checkbox task__checkbox">
                            <input class="checkbox__input visually-hidden" type="checkbox" checked>
                            <span class="checkbox__text"><?=strip_tags($task['name'])?></span>
                        </label>
                    </td>


                    <td class="task__file">
                        <?php if(!empty($task['file'])): ?>
                        <a class="download-link" href="<?=$task['file']?>"><?=$task['filename']?></a>
                        <?php endif; ?>
                    </td>


                    <td class="task__date"><?=format_date($task['expiration_date'])?></td>

                    <td class="task__controls">
                    <button class="expand-control" type="button" name="button">Дополнительные действия</button>
                        <ul class="expand-list hidden">
                            <li class="expand-list__item">
                                <a href="?complete_task=1&task_id=<?=$task['id']?>&project_id=<?=$project_id?>&filter=<?=$filter?>">
                                    Выполнить
                                </a>
                            </li>
                            <li class="expand-list__item">
                                <a href="?delete_task=<?=$task['id']?>&project_id=<?=$project_id?>&filter=<?=$filter?>">
                                    Удалить
                                </a>
                            </li>
                        </ul>
                    </td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <h2>Задач для проекта нет</h2>
<?php endif; ?>
