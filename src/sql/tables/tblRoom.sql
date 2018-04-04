USE `gildedrose`;

CREATE TABLE `tblRoom` (
	`ID` INT NOT NULL AUTO_INCREMENT,
	`RoomNumber` INT NOT NULL,
	`MaxOccupancy` INT NOT NULL,
	`MaxStorage` INT NOT NULL,
	PRIMARY KEY (`ID`),
	UNIQUE INDEX `ID_UNIQUE` (`ID` ASC),
	UNIQUE INDEX `RoomNumber_UNIQUE` (`RoomNumber` ASC)
);

INSERT INTO tblRoom (RoomNumber, MaxOccupancy, MaxStorage) 
	VALUES (1, 2, 1);

INSERT INTO tblRoom (RoomNumber, MaxOccupancy, MaxStorage) 
	VALUES (2, 2, 0);

INSERT INTO tblRoom (RoomNumber, MaxOccupancy, MaxStorage) 
	VALUES (3, 1, 2);

INSERT INTO tblRoom (RoomNumber, MaxOccupancy, MaxStorage) 
	VALUES (4, 1, 0);