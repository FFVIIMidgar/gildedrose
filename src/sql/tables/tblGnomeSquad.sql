/**
 * tblGnomeSquad.sql
 *
 * Creates the tblGnomeSquad table.
 *
 * @author A.J. Rodriguez <avrodriguezjr@gmail.com>
 */

USE `gildedrose`;

CREATE TABLE `tblGnomeSquad` (
	`ID` INT NOT NULL AUTO_INCREMENT,
	`RoomID` INT NOT NULL,
	`Date` DATE NOT NULL,
	`StartTime` TIME NOT NULL,
	`EndTime` TIME NOT NULL,
	PRIMARY KEY (`ID`),
	UNIQUE INDEX `ID_UNIQUE` (`ID` ASC)
);