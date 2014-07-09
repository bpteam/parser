SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


-- -----------------------------------------------------
-- Table `parser`.`type_url`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `parser`.`type_url` ;

CREATE TABLE IF NOT EXISTS `parser`.`type_url` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `parser`.`module`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `parser`.`module` ;

CREATE TABLE IF NOT EXISTS `parser`.`module` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(45) NOT NULL,
  `class_name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `parser`.`state`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `parser`.`state` ;

CREATE TABLE IF NOT EXISTS `parser`.`state` (
  `id` INT NOT NULL,
  `title` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `parser`.`site`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `parser`.`site` ;

CREATE TABLE IF NOT EXISTS `parser`.`site` (
  `id` INT NOT NULL,
  `title` VARCHAR(250) NOT NULL,
  `description` VARCHAR(500) NULL,
  `module_id` INT NOT NULL,
  `state_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_site_module1_idx` (`module_id` ASC),
  INDEX `fk_site_state1_idx` (`state_id` ASC),
  CONSTRAINT `fk_site_module1`
    FOREIGN KEY (`module_id`)
    REFERENCES `parser`.`module` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_site_state1`
    FOREIGN KEY (`state_id`)
    REFERENCES `parser`.`state` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `parser`.`pars_url`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `parser`.`pars_url` ;

CREATE TABLE IF NOT EXISTS `parser`.`pars_url` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `url` VARCHAR(300) NOT NULL,
  `type_url_id` INT NOT NULL,
  `module_id` INT NOT NULL,
  `site_id` INT NOT NULL,
  `state_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_pars_url_type_url_idx` (`type_url_id` ASC),
  INDEX `fk_pars_url_module1_idx` (`module_id` ASC),
  INDEX `fk_pars_url_site1_idx` (`site_id` ASC),
  INDEX `fk_pars_url_state1_idx` (`state_id` ASC),
  CONSTRAINT `fk_pars_url_type_url`
    FOREIGN KEY (`type_url_id`)
    REFERENCES `parser`.`type_url` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pars_url_module1`
    FOREIGN KEY (`module_id`)
    REFERENCES `parser`.`module` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pars_url_site1`
    FOREIGN KEY (`site_id`)
    REFERENCES `parser`.`site` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_pars_url_state1`
    FOREIGN KEY (`state_id`)
    REFERENCES `parser`.`state` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `parser`.`site_page`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `parser`.`site_page` ;

CREATE TABLE IF NOT EXISTS `parser`.`site_page` (
  `hash` CHAR(32) NOT NULL,
  `url` TEXT NULL,
  `html` TEXT NULL,
  `time` INT NULL,
  PRIMARY KEY (`hash`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
