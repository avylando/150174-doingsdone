<div class="modal">
  <button class="modal__close" type="button" name="button">Закрыть</button>

  <h2 class="modal__heading">Добавление задачи</h2>

  <form class="form"  action="../index.php" method="post" enctype="multipart/form-data">

    <div class="form__row">
      <label class="form__label" for="name">Название <sup>*</sup></label>
      <?php $validity = isset($errors['title']) ? 'form__input--error' : '';
        $value = isset($task['title']) ? $task['title'] : ''; ?>
      <input class="form__input <?=$validity?>" type="text" name="title" id="name" value="<?=$value?>" placeholder="Введите название">
      <p class="form__message"><?=$errors['title']?></p>
    </div>

    <div class="form__row">
      <label class="form__label" for="project">Проект <sup>*</sup></label>
      <?php $validity = isset($errors['category']) ? 'form__input--error' : '';
        $value = isset($task['category']) ? $task['category'] : ''; ?>
      <select class="form__input form__input--select <?=$validity?>" name="category" id="project">
        <?php foreach ($projects as $category): ?>
            <option value="<?=$category?>" <?php $task['category'] === $category ? print('selected') : ''?>><?=$category?></option>
        <?php endforeach; ?>
      </select>
      <p class="form__message"><?=$errors['category']?></p>
    </div>

    <div class="form__row">
      <label class="form__label" for="date">Дата выполнения</label>
      <?php $value = isset($task['date']) ? $task['date'] : ''; ?>
      <input class="form__input form__input--date" type="date" name="date" id="date" value="<?=$value?>" placeholder="Введите дату в формате ДД.ММ.ГГГГ">
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
