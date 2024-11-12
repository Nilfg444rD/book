CREATE DATABASE `book_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

CREATE TABLE `book` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` text,
  `title` varchar(255),
  `category` int(11),
  `author` varchar(255),
  PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE `category` (
  `id` INT(11) NOT NULL AUTO_INCREMENT , 
  `name` VARCHAR(255) NOT NULL , 
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;

INSERT INTO `category` (`id`, `name`) VALUES ('1', 'Fiction'), ('2', 'Fantasy'), ('3', 'Romance'), ('4', 'Science Fiction');