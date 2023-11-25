CREATE DATABASE IF NOT EXISTS `bookshop`;

USE `bookshop`;

CREATE TABLE IF NOT EXISTS `genres` (
  `id`   varchar(255) NOT NULL PRIMARY KEY,
  `name` varchar(255) NOT NULL,
  `number_of_books` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `books` (
  `id`    varchar(255) NOT NULL PRIMARY KEY,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `books_genres` (
  `book_id`  varchar(255) NOT NULL,
  `genre_id` varchar(255) NOT NULL,
  PRIMARY KEY (`book_id`, `genre_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `genres` (`id`, `name`) VALUES
('983437ee-d976-4868-a67b-c4f600e800c7', 'Genre 1'),
('d6f9fdd7-73b1-420e-8b67-0676ec38a571', 'Genre 2'),
('dec6941b-e4c4-4045-a389-91c26930d309', 'Genre 3'),
('62a28fd2-05f1-4785-b12d-a673e5bcf66b', 'Genre 4'),
('a6a24291-8490-4942-bf28-3381d7a447e3', 'Genre 5'),
('cc0ded01-42f1-4279-881c-2492721a7d4e', 'Genre 6'),
('bf720917-4586-41e4-9f69-015e9f2d095d', 'Genre 7'),
('507a43a1-b960-4ac1-a6d1-927d5363c7c5', 'Genre 8');

INSERT INTO `books` (`id`, `title`) VALUES
('0886de72-aa44-4281-83f6-45c5f8284cea', 'Book 1'),
('16341b27-3fb2-4928-b4e9-6e0340e56925', 'Book 2'),
('b64f26be-4233-4375-8cbb-c44e65c08c05', 'Book 3'),
('47da32f9-dc27-41eb-98fc-cddb47e4cec8', 'Book 4'),
('2d240323-357b-416e-834a-e93d9df8c259', 'Book 5');

INSERT INTO `books_genres` (`book_id`, `genre_id`) VALUES
('b64f26be-4233-4375-8cbb-c44e65c08c05', '983437ee-d976-4868-a67b-c4f600e800c7'),
('b64f26be-4233-4375-8cbb-c44e65c08c05', 'd6f9fdd7-73b1-420e-8b67-0676ec38a571'),
('0886de72-aa44-4281-83f6-45c5f8284cea', 'a6a24291-8490-4942-bf28-3381d7a447e3'),
('0886de72-aa44-4281-83f6-45c5f8284cea', 'd6f9fdd7-73b1-420e-8b67-0676ec38a571'),
('0886de72-aa44-4281-83f6-45c5f8284cea', '983437ee-d976-4868-a67b-c4f600e800c7'),
('16341b27-3fb2-4928-b4e9-6e0340e56925', 'd6f9fdd7-73b1-420e-8b67-0676ec38a571'),
('16341b27-3fb2-4928-b4e9-6e0340e56925', '507a43a1-b960-4ac1-a6d1-927d5363c7c5'),
('47da32f9-dc27-41eb-98fc-cddb47e4cec8', '983437ee-d976-4868-a67b-c4f600e800c7'),
('47da32f9-dc27-41eb-98fc-cddb47e4cec8', '507a43a1-b960-4ac1-a6d1-927d5363c7c5'),
('47da32f9-dc27-41eb-98fc-cddb47e4cec8', 'a6a24291-8490-4942-bf28-3381d7a447e3'),
('2d240323-357b-416e-834a-e93d9df8c259', 'a6a24291-8490-4942-bf28-3381d7a447e3'),
('2d240323-357b-416e-834a-e93d9df8c259', '983437ee-d976-4868-a67b-c4f600e800c7');
