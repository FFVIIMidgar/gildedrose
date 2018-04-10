/**
 * tblGuest.sql
 *
 * Creates the tblGuest table.
 *
 * @author A.J. Rodriguez <avrodriguezjr@gmail.com>
 */

USE `gildedrose`;

CREATE TABLE `tblGuest` (
	`ID` INT NOT NULL AUTO_INCREMENT,
	`FirstName` VARCHAR(255) NOT NULL,
	`LastName` VARCHAR(255) NOT NULL,
	`Email` VARCHAR(255) NOT NULL,
	PRIMARY KEY (`ID`),
	UNIQUE INDEX `ID_UNIQUE` (`ID` ASC),
	UNIQUE INDEX `Email_UNIQUE` (`Email` ASC)
);