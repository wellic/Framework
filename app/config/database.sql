-- -----------------------------------------------------
-- База данных
-- -----------------------------------------------------
DROP DATABASE IF EXISTS `mindkblog`;
CREATE DATABASE IF NOT EXISTS `mindkblog`;
USE `mindkblog`;


-- -----------------------------------------------------
-- Таблица `users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `users` ;

CREATE TABLE IF NOT EXISTS `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `name` VARCHAR(80) NOT NULL COMMENT '',
  `email` VARCHAR(120) NOT NULL COMMENT '',
  `password` VARCHAR(80) NOT NULL COMMENT '',
  `role` VARCHAR(45) NOT NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '')
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Таблица `posts`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `posts` ;

CREATE TABLE IF NOT EXISTS `posts` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `title` VARCHAR(100) NOT NULL COMMENT '',
  `content` TEXT NOT NULL COMMENT '',
  `date` DATETIME NOT NULL COMMENT '',
  `users_id` INT(11) NOT NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '',
  CONSTRAINT `users`
    FOREIGN KEY (`users_id`)
    REFERENCES `users` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

-- -----------------------------------------------------
-- Добавить пользователя
-- Пароль для админа : admin, для гостя : guest
-- -----------------------------------------------------
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`) VALUES
(2, 'Jura Zubach', 'jurazubach@gmail.com', '21232f297a57a5a743894a0e4a801fc3', 'ROLE_ADMIN'),;
(2, 'Guest', 'guest@gmail.com', '084e0343a0486ff05530df6c705c8bb4', 'ROLE_USER');

-- -----------------------------------------------------
-- Добавить посты
-- -----------------------------------------------------
INSERT INTO `posts` (`id`, `title`, `content`, `date`, `users_id`) VALUES
(1, 'iPhone Upgrade Program', 'Get a new iPhone every year. Unlocked - choose your carrier.\r\nLow monthly payments.\r\niPhone protection with AppleCare+', '2015-10-15 12:15:43', 2),
(2, 'iOS 9', 'Easy to use yet capable of so much, iOS 9 was engineered to work hand in hand with the advanced technologies built into iPhone.', '2015-10-15 08:11:14', 2),
(3, 'iCloud', 'Keep everything you love about iPhone up to date, secure, and accessible from any device with iCloud.', '2015-10-03 01:13:02', 2),
(4, 'AppleCare+ for iPhone', 'Every iPhone comes with one year of repair coverage and 90 days of complimentary support. Extend your coverage with AppleCare+.', '2015-10-15 12:17:06', 2),
(5, 'As individual as you are.', 'What you put on says a lot about you. And everyone is different. So we designed Apple Watch to reflect a wide range of tastes and styles. And you can make it even more personal, to suit the occasion or your mood, by switching bands and changing watch faces. Anytime you want.', '2015-10-15 12:17:06', 2);
