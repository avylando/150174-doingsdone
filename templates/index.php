<h2 class="content__main-heading">Список задач</h2>

<form class="search-form" action="index.html" method="post">
    <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

    <input class="search-form__submit" type="submit" name="" value="Искать">
</form>

<div class="tasks-controls">
    <nav class="tasks-switch">
        <a href="/" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
        <a href="/" class="tasks-switch__item">Повестка дня</a>
        <a href="/" class="tasks-switch__item">Завтра</a>
        <a href="/" class="tasks-switch__item">Просроченные</a>
    </nav>

    <label class="checkbox">
        <a href="/?show_completed">
            <?php if(intval($show_completed) === 1): ?>
                <input class="checkbox__input visually-hidden" type="checkbox" checked>
            <?php else: ?>
                <input class="checkbox__input visually-hidden" type="checkbox">
            <?php endif; ?>
                <span class="checkbox__text">Показывать выполненные</span>
        </a>
    </label>
</div>

<?php if (isset($tasks)): ?>
    <table class="tasks">
        <?php foreach($tasks as $task): ?>
            <?php if ($task['complete'] && intval($show_completed) === 1): ?>
                <tr class="tasks__item task task--completed">
                    <td class="task__select">
                        <label class="checkbox task__checkbox">
                            <input class="checkbox__input visually-hidden" type="checkbox" checked>
                            <span class="checkbox__text"><?=strip_tags($task['title'])?></span>
                        </label>
                    </td>

                    <td class="task__date"><?=strip_tags($task['date'])?></td>

                    <td class="task__controls"></td>
                </tr>
            <?php endif; ?>

            <?php if (!$task['complete']): ?>

                <tr class="tasks__item task
                <?php if (count_days($task['date']) <= 1 && $task['date'] !== ''): ?>
                    task--important
                <?php endif; ?>
                ">
                    <td class="task__select">
                        <label class="checkbox task__checkbox">
                            <input class="checkbox__input visually-hidden" type="checkbox" checked>
                            <span class="checkbox__text"><?=strip_tags($task['title'])?></span>
                        </label>
                    </td>

                    <td class="task__date"><?=strip_tags($task['date'])?></td>

                    <td class="task__controls"></td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <h1>Проект не найден</h1>
<?php endif; ?>
