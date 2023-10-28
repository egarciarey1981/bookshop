CREATE DATABASE IF NOT EXISTS `bookshop`;

USE `bookshop`;

CREATE TABLE IF NOT EXISTS `books` (
  `id`     varchar(255) NOT NULL PRIMARY KEY,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `books` (`id`, `title`) VALUES
('653509857ae45', 'Romeo y Julieta'),
('6535098a0c2d5', 'El Quijote'),
('6535098a0c2d6', 'La Celestina'),
('6535098a0c2d7', 'El Hobbit'),
('6535098a0c2d8', 'El señor de los anillos'),
('6535098a0c2d9', 'El código Da Vinci'),
('6535098a0c2da', 'El alquimista'),
('6535098a0c2db', 'La historia interminable'),
('6535098a0c2dc', 'El perfume'),
('6535098a0c2dd', 'El nombre de la rosa'),
('6535098a0c2de', 'El retrato de Dorian Gray'),
('6535098a0c2df', 'El médico'),
('6535098a0c2e0', 'El último mohicano'),
('6535098a0c2e1', 'El conde de Montecristo'),
('6535098a0c2e2', 'El guardián entre el centeno'),
('6535098a0c2e3', 'El gran Gatsby'),
('6535098a0c2e4', 'El principito'),
('6535098a0c2e5', 'El hombre invisible'),
('6535098a0c2e6', 'El retrato de Dorian Gray');
