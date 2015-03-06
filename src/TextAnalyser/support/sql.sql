DROP TABLE IF EXISTS `text_analyse`;

CREATE TABLE IF NOT EXISTS `text_analyse`(
  `id` INT NOT NULL AUTO_INCREMENT,
  `text` TEXT NOT NULL,
  `is_checked` INT(1) NOT NULL,
  PRIMARY KEY (`id`))
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_general_ci;

DROP TABLE IF EXISTS `patterns_target`;

CREATE TABLE IF NOT EXISTS `patterns_target`(
  `id` INT NOT NULL AUTO_INCREMENT,
  `pattern` VARCHAR(100),
  `target` VARCHAR(100),
  PRIMARY KEY (`id`),
  INDEX `idx_target` (`target` ASC),
  UNIQUE INDEX `idx_patt_tar` (`pattern` ASC, `target` ASC))
  ENGINE = InnoDB,
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_general_ci;