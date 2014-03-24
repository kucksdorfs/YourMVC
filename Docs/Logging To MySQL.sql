CREATE TABLE IF NOT EXISTS 'mydb'.'Logging' (
  'ID' INT NOT NULL AUTO_INCREMENT,
  'LogType' VARCHAR(15) NOT NULL,
  'LogText' TEXT NULL,
  'LogTime' DATETIME NULL DEFAULT NOW(),
  PRIMARY KEY ('ID'),
  UNIQUE INDEX 'ID_UNIQUE' ('ID' ASC))
ENGINE = InnoDB

CREATE TRIGGER 'Set_LogTime' BEFORE INSERT ON 'Logging' FOR EACH ROW
set new.LogTime = now();

CREATE VIEW 'LoggedErrors' AS
	Select LogText, LogTime from Logging where LogType = 'Error'

CREATE VIEW 'LoggedInformation' AS
	Select LogText, LogTime from Logging where LogType = 'Information'

CREATE VIEW 'LoggedWarnings' AS
	Select LogText, LogTime from Logging where LogType = 'Warning'