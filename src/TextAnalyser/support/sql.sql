DROP TABLE IF EXISTS `text_analyse`;

CREATE TABLE IF NOT EXISTS `text_analyse`(
  `id` INT NOT NULL AUTO_INCREMENT,
  `hash` CHAR(32),
  `text` TEXT NOT NULL,
  `is_checked` TINYINT NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `hash_idx` (`hash` ASC))
  ENGINE = InnoDB
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_general_ci;

DROP TABLE IF EXISTS `patterns_target`;

CREATE TABLE IF NOT EXISTS `patterns_target`(
  `id` INT NOT NULL AUTO_INCREMENT,
  `pattern` VARCHAR(100),
  `target` VARCHAR(100),
  `data_group` VARCHAR(100),
  PRIMARY KEY (`id`),
  INDEX `idx_target` (`target` ASC, `data_group` ASC),
  UNIQUE INDEX `idx_patt_tar` (`pattern` ASC, `target` ASC, `data_group` ASC))
  ENGINE = InnoDB,
  DEFAULT CHARACTER SET = utf8
  COLLATE = utf8_general_ci;