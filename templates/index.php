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

                    <td class="task__date"><?=strip_tags($task['expiration_date'])?></td>
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

                    <td class="task__date"><?=strip_tags($task['expiration_date'])?></td>

                    <td class="task__controls"></td>
                </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <h2>Текущих задач нет</h2>
<?php endif; ?>

<div class="modal modal-add modal--hide">
  <button class="modal__close" type="button" name="button">Закрыть</button>

  <h2 class="modal__heading">Добавление задачи</h2>

  <form class="form" action="../add-task.php" method="post" enctype="multipart/form-data">

    <div class="form__row">
      <label class="form__label" for="name">Название <sup>*</sup></label>
      <?php $validity = isset($errors['name']) ? 'form__input--error' : '';
        $value = isset($task['name']) ? $task['name'] : ''; ?>
      <input class="form__input <?=$validity?>" type="text" name="name" id="name" value="<?=$value?>" placeholder="Введите название">
      <p class="form__message"><?=$errors['name']?></p>
    </div>

    <div class="form__row">
      <label class="form__label" for="project">Проект <sup>*</sup></label>
      <?php $validity = isset($errors['project']) ? 'form__input--error' : '';
        $value = isset($task['project']) ? $task['project'] : ''; ?>
        <!-- <?php print_r($projects)?> -->
      <select class="form__input form__input--select <?=$validity?>" name="project" id="project">
        <?php foreach ($projects as $project): ?>
            <option value="<?=$project['id']?>" <?php $task['project'] === $project['name'] ? print('selected') : ''?>><?=$project['name']?></option>
        <?php endforeach; ?>
      </select>
      <p class="form__message"><?=$errors['project']?></p>
    </div>

    <div class="form__row">
      <label class="form__label" for="expiration_date">Дата выполнения</label>
      <?php $value = isset($task['expiration_date']) ? $task['expiration_date'] : ''; ?>
      <input class="form__input form__input--date" type="date" name="expiration_date" id="date" value="<?=$value?>" placeholder="Введите дату в формате ДД.ММ.ГГГГ">
    </div>

    <div class="form__row">
      <label class="form__label" for="preview">Файл</label>

      <div class="form__input-file">
        <input class="visually-hidden" type="file" name="task-image" id="preview" value="">

        <label class="button button--transparent" for="preview">
            <span>Выберите файл</span>
        </label>
        <p class="form__message"><?php isset($errors['task-image']) ? print($errors['task-image']) : '';?></p>
      </div>
    </div>

    <div class="form__row form__row--controls">
      <input class="button" type="submit" name="add-task" value="Добавить">
    </div>
  </form>
</div>
