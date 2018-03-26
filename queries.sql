-- Добавление пользователей
INSERT INTO user (name, email, password, phone)
VALUES ('Игнат', 'ignat.v@gmail.com', '$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka', 'phone: 89653426190'),
('Леночка', 'kitty_93@li.ru', '$2y$10$bWtSjUhwgggtxrnJ7rxmIe63ABubHQs0AS0hgnOo41IEdMHkYoSVa', NULL),
('Руслан', 'warrior07@mail.ru', '$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW', 'mobile: 89222310241. home: 7291082');

-- Добавление проектов
INSERT INTO project (name, author_id)
VALUES ('Все', 1), ('Все', 2), ('Все', 3), ('Входящие', 1), ('Входящие', 2), ('Входящие', 3), ('Учеба', 2), ('Работа', 1), ('Домашние дела', 3), ('Авто', 2);

-- Добавление заданий
INSERT INTO task (name, project_id, expiration_date, complete_date, author_id)
VALUES
('Собеседование в IT-компании', 8, '2018-04-21 00:00:00', NULL, 1),
('Выполнить тестовое задание', 8, '2018-04-08 00:00:00', NULL, 1),
('Сделать задание первого раздела', 7, '2018-04-08 00:00:00', '2018-03-02 00:00:00', 1),
('Встреча с другом', 5, '2018-04-13 00:00:00', NULL, 2),
('Купить корм для кота', 9, NULL, NULL, 3),
('Заказать пиццу', 9, NULL, NULL, 3)
