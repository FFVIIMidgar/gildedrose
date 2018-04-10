/**
 * tblBooking.sql
 *
 * Creates the tblBooking table.
 *
 * @author A.J. Rodriguez <avrodriguezjr@gmail.com>
 */

USE `gildedrose`;

CREATE TABLE `tblBooking` (
	`ID` INT NOT NULL AUTO_INCREMENT,
	`GuestID` INT NOT NULL,
	`RoomID` INT NOT NULL,
	`CheckInDate` DATE NOT NULL,
	`CheckOutDate` DATE NOT NULL,
	`ItemCount` INT NOT NULL,
 	PRIMARY KEY (`ID`),
	UNIQUE INDEX `ID_UNIQUE` (`ID` ASC)
);