CREATE DATABASE doingsdone_db;

USE doingsdone_db;

CREATE TABLE user (
  id INT AUTO_INCREMENT PRIMARY KEY,
  signup_date DATETIME NOT NULL DEFAULT NOW(),
  name CHAR(128) NOT NULL,
  email CHAR(128) NOT NULL,
  password CHAR(64) NOT NULL,
  phone CHAR(255)
);

CREATE TABLE project (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name CHAR(32) NOT NULL,
  author_id INT NOT NULL,
  CONSTRAINT FK_ProjectAuthor FOREIGN KEY (author_id) REFERENCES user(id)
);

CREATE TABLE task (
  id INT AUTO_INCREMENT PRIMARY KEY,
  creation_date DATETIME NOT NULL DEFAULT NOW(),
  name CHAR(255) NOT NULL,
  project_id INT NOT NULL,
  file CHAR(128),
  expiration_date DATETIME NULL DEFAULT NULL,
  complete_date DATETIME NULL DEFAULT NULL,
  author_id INT NOT NULL,
  CONSTRAINT FK_TaskAuthor FOREIGN KEY (author_id) REFERENCES user(id),
  CONSTRAINT FK_TaskProject FOREIGN KEY (project_id) REFERENCES project(id)
);

CREATE UNIQUE INDEX email ON user (email);
CREATE INDEX task ON task (name);
CREATE INDEX task_project ON task (project_id);
CREATE FULLTEXT INDEX task_ft_search ON task (name);
