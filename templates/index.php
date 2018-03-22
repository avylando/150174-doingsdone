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
        <a href="/?show_completed&id=<?=$project_id?>">
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

                    <td class="task__date"><?=format_date(strip_tags($task['expiration_date']))?></td>
                    <td class="task__controls"></td>
                </tr>
            <?php endif; ?>

            <?php if (empty($task['complete_date'])): ?>
                <tr class="tasks__item task
                <?php if (count_days($task['expiration_date']) <= 1 && $task['expiration_date'] !== ''): ?>
                    task--important
                <?php endif; ?>
                ">
                    <td class="task__select">
                        <label class="checkbox task__checkbox">
                            <input class="checkbox__input visually-hidden" type="checkbox" checked>
                            <span class="checkbox__text"><?=strip_tags($task['name'])?></span>
                        </label>
                    </td>

                    <td class="task__date"><?=format_date($task['expiration_date'])?></td>

                    <td class="task__controls"></td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <h2>Текущих задач нет</h2>
<?php endif; ?>
