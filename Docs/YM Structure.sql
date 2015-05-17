SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

DROP SCHEMA IF EXISTS `YourMVC` ;
CREATE SCHEMA IF NOT EXISTS `YourMVC` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `YourMVC` ;

-- -----------------------------------------------------
-- Table `YourMVC`.`YM_Tables`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `YourMVC`.`YM_Tables` ;

CREATE TABLE IF NOT EXISTS `YourMVC`.`YM_Tables` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `GUID` VARCHAR(40) NOT NULL,
  `Table_Name` VARCHAR(50) NULL,
  `YM_ID` VARCHAR(50) NULL,
  `YM_Name` VARCHAR(50) NULL,
  `YM_Description` TEXT NULL,
  `CreatedOn` DATETIME NULL,
  `CreatedBy` VARCHAR(50) NULL,
  `ModifiedOn` DATETIME NULL,
  `ModifiedBy` VARCHAR(50) NULL,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `Table_Name_UNIQUE` (`Table_Name` ASC),
  UNIQUE INDEX `YM_ID_UNIQUE` (`YM_ID` ASC),
  UNIQUE INDEX `GUID_UNIQUE` (`GUID` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `YourMVC`.`YM_ColumnTypes`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `YourMVC`.`YM_ColumnTypes` ;

CREATE TABLE IF NOT EXISTS `YourMVC`.`YM_ColumnTypes` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `GUID` VARCHAR(40) NOT NULL,
  `Type` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `ID_UNIQUE` (`ID` ASC),
  UNIQUE INDEX `GUID_UNIQUE` (`GUID` ASC),
  UNIQUE INDEX `Type_UNIQUE` (`Type` ASC))
ENGINE = InnoDB
PACK_KEYS = DEFAULT;


-- -----------------------------------------------------
-- Table `YourMVC`.`YM_Columns`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `YourMVC`.`YM_Columns` ;

CREATE TABLE IF NOT EXISTS `YourMVC`.`YM_Columns` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `GUID` VARCHAR(40) NOT NULL,
  `Column_Name` VARCHAR(50) NOT NULL,
  `YM_Table` INT NOT NULL,
  `YM_ID` VARCHAR(45) NOT NULL,
  `YM_Name` VARCHAR(45) NOT NULL,
  `YM_Description` TEXT NULL,
  `IsPrimaryKey` BIT NULL,
  `SecondaryKeyIndex` INT NULL,
  `FieldType` INT NOT NULL,
  `FieldLength` INT NULL,
  `TableReference` INT NULL,
  `FieldReference` INT NULL,
  `EnforceLookup` BIT NULL,
  `CreatedOn` DATETIME NULL,
  `CreatedBy` VARCHAR(50) NULL,
  `ModifiedOn` DATETIME NULL,
  `ModifiedBy` VARCHAR(45) NULL,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `GUID_UNIQUE` (`GUID` ASC),
  INDEX `fk_YM_Columns_1_idx` (`FieldType` ASC),
  INDEX `TableReference_idx` (`TableReference` ASC),
  INDEX `FieldValueReference_idx` (`FieldReference` ASC),
  CONSTRAINT `FieldType`
    FOREIGN KEY (`FieldType`)
    REFERENCES `YourMVC`.`YM_ColumnTypes` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `TableReference`
    FOREIGN KEY (`TableReference`)
    REFERENCES `YourMVC`.`YM_Tables` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FieldValueReference`
    FOREIGN KEY (`FieldReference`)
    REFERENCES `YourMVC`.`YM_Columns` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

USE `YourMVC`;

DELIMITER $$

USE `YourMVC`$$
DROP TRIGGER IF EXISTS `YourMVC`.`YM_Tables_BINS` $$
USE `YourMVC`$$
CREATE TRIGGER `YM_Tables_BINS` BEFORE INSERT ON `YM_Tables` FOR EACH ROW
set new.GUID = (SELECT UUID()),new.CreatedOn = (SELECT NOW()),new.CreatedBy = (SELECT CURRENT_USER());
$$


USE `YourMVC`$$
DROP TRIGGER IF EXISTS `YourMVC`.`YM_Tables_BUPD` $$
USE `YourMVC`$$
CREATE TRIGGER `YM_Tables_BUPD` BEFORE UPDATE ON `YM_Tables` FOR EACH ROW
set new.ModifiedOn = (SELECT NOW()), new.ModifiedBy = (SELECT CURRENT_USER());
$$


USE `YourMVC`$$
DROP TRIGGER IF EXISTS `YourMVC`.`YM_ColumnTypes_BINS` $$
USE `YourMVC`$$
CREATE TRIGGER `YM_ColumnTypes_BINS` BEFORE INSERT ON `YM_ColumnTypes` FOR EACH ROW
set new.GUID = (SELECT UUID());$$


USE `YourMVC`$$
DROP TRIGGER IF EXISTS `YourMVC`.`YM_Columns_BINS` $$
USE `YourMVC`$$
CREATE TRIGGER `YM_Columns_BINS` BEFORE INSERT ON `YM_Columns` FOR EACH ROW
set new.GUID = (SELECT UUID()),new.CreatedOn = (SELECT NOW()),new.CreatedBy = (SELECT CURRENT_USER());$$


USE `YourMVC`$$
DROP TRIGGER IF EXISTS `YourMVC`.`YM_Columns_BUPD` $$
USE `YourMVC`$$
CREATE TRIGGER `YM_Columns_BUPD` BEFORE UPDATE ON `YM_Columns` FOR EACH ROW
set new.ModifiedOn = (SELECT NOW()), new.ModifiedBy = (SELECT CURRENT_USER());$$


DELIMITER ;

-- -----------------------------------------------------
-- Data for table `YourMVC`.`YM_ColumnTypes`
-- -----------------------------------------------------
START TRANSACTION;
USE `YourMVC`;
INSERT INTO `YourMVC`.`YM_ColumnTypes` (`Type`) VALUES ('Integer');
INSERT INTO `YourMVC`.`YM_ColumnTypes` (`Type`) VALUES ('Float');
INSERT INTO `YourMVC`.`YM_ColumnTypes` (`Type`) VALUES ('Date/Time');
INSERT INTO `YourMVC`.`YM_ColumnTypes` (`Type`) VALUES ('Date');
INSERT INTO `YourMVC`.`YM_ColumnTypes` (`Type`) VALUES ('Time');
INSERT INTO `YourMVC`.`YM_ColumnTypes` (`Type`) VALUES ('String');
INSERT INTO `YourMVC`.`YM_ColumnTypes` (`Type`) VALUES ('Boolean');
INSERT INTO `YourMVC`.`YM_ColumnTypes` (`Type`) VALUES ('Lookup');

COMMIT;
