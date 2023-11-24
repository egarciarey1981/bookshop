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
('453509857ae45', 'Tragedy'),
('453509857ae46', 'Horror'),
('453509857ae49', 'Mystery'),
('453509857ae4a', 'Romance'),
('453509857ae4b', 'Western'),
('453509857ae4c', 'Drama'),
('453509857ae4d', 'Action'),
('453509857ae4e', 'Adventure');

INSERT INTO `books` (`id`, `title`) VALUES
('553509857ae60', 'Romeo and Juliet'),
('553509857ae61', 'Frankestein'),
('553509857ae62', 'The Hound of the Baskervilles'),
('553509857ae63', 'Twenty Thousand Leagues Under the Seas'),
('553509857ae64', 'Five Weeks in a Balloon');

INSERT INTO `books_genres` (`book_id`, `genre_id`) VALUES
('553509857ae60', '453509857ae45'),
('553509857ae60', '453509857ae4c'),
('553509857ae61', '453509857ae46'),
('553509857ae61', '453509857ae4c'),
('553509857ae62', '453509857ae46'),
('553509857ae62', '453509857ae4c'),
('553509857ae63', '453509857ae4d'),
('553509857ae63', '453509857ae4e'),
('553509857ae64', '453509857ae4d'),
('553509857ae64', '453509857ae4e'),
('553509857ae65', '453509857ae4d'),
('553509857ae65', '453509857ae4e');
