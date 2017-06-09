CREATE TABLE `bookstore` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `address` VARCHAR(50) NOT NULL,
  `openedAt` DATETIME NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE = InnoDB;
