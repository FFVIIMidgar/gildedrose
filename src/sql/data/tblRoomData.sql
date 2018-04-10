/**
 * tblRoomData.sql
 *
 * Populates the tblRoomData table with initial data.
 *
 * @author A.J. Rodriguez <avrodriguezjr@gmail.com>
 */

USE `gildedrose`;

INSERT INTO tblRoom (RoomNumber, MaxOccupancy, MaxStorage) 
	VALUES (1, 2, 1);

INSERT INTO tblRoom (RoomNumber, MaxOccupancy, MaxStorage) 
	VALUES (2, 2, 0);

INSERT INTO tblRoom (RoomNumber, MaxOccupancy, MaxStorage) 
	VALUES (3, 1, 2);

INSERT INTO tblRoom (RoomNumber, MaxOccupancy, MaxStorage) 
	VALUES (4, 1, 0);