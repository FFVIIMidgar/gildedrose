/**
 * tblRoom.sql
 *
 * Creates the tblRoom table.
 *
 * @author A.J. Rodriguez <avrodriguezjr@gmail.com>
 */

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