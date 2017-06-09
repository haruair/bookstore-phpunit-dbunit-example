CREATE TABLE `book` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(200) NOT NULL,
  `author` VARCHAR(50) NOT NULL,
  `publisher` VARCHAR(50) NOT NULL,
  `ISBN` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;