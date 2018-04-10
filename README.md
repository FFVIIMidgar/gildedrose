# gildedrose
A coding exercise that focuses on designing and implementing a RESTful API.

## Description
The purpose of this project is to design an API that represents a simple inn/hotel booking sytem. It exposes the following endpoints:

* Listing room availability, based on guest bookings, luggage storage requirements, and cleaning availability.
* Booking a room based on room availability, luggage storage requirements, and cleaning availability.
* Obtaining the Gnome Squad cleaning schedule for each day.

### Requirements
The following rules and conditions are presented for booking at this inn/hotel:

* The inn/hotel has four rooms:
	* One room accomodates two people and has one storage space.
	* One room accomodates two people and has zero storage spaces.
	* One room accomodates one person and has two storage spaces.
	* One room accomodates one person and has zero storage spaces.
* All rooms must be cleaned after being occupied and prior to being rented again.
* The Gnome Cleaning Squad requires one hour of cleaning per room plus an additional 30 minutes per person in the room.
* There is only one Gnome Cleaning Squad.
* The Gnome Cleaning Squad can only work up to 8 hours per day.
* The Gnome Cleaning Squad's start time is flexible but must be contiguous.
* Guests cannot storage their luggage in another guest's room.
* The inn/hotel is a shared space. Guests may be in shared rooms if it is the most profitable.
* The cost per person is calculated as follows:
	* (base room cost / number of guests in the room) + (base storage cost x number of items).
	* Base room cost is 10 gold and base storage cost is 2 gold.


### Design Decisions and Assumptions
The following are decisions and assumptions I've made:

* Only one guest can book at a time.
* A guest stays for just one night (overnight).
* Check in is at 6pm and check out is at 10am the following day. This simplifies the problem and eliminates the complications that arise with
the cleaning schedule since there are 8 full hours between a check out and a potential check in.
* The maximum number of hours that the Gnome Cleaning Squad can ever work in a day is 7 hours. 
	* This was calculated by: (4 rooms x 1 hour) + (6 guests x 0.5 hours) = 7 hours.
* The Gnome Cleaning Squad starts cleaning promptly at 10am, should there be any rooms to clean that day,
and will move on to the next room immediately after.
* A two person room will take 2 hours to clean regardless of whether one or two guests have stayed the night before.
* A guest cannot book a room before the current day.
* A guest cannot book more than one room in the same day.
* The best room selection is as follows. This is set up in such a way that empty rooms are filled up first, while matching the
guest's storage requirements as closely as possible, to maximize profit. 
	* P1: No other guests have occupied the room and the remaining storage occupancy is equal to the item count.
	* P2: No other guests have occupied the room and the remaining storage occupancy is not equal to the item count.
	* P3: Other guests have occupied the room and the remaining storage occupancy is equal to the item count.xa
	* P4: Other guests have occupied the room and the remaining storage occupancy is not equal to the item count.


## Technology Stack
This project uses the following technology stack:

* PHP
* MySQL
* Slim - PHP microframework
	* Used mostly for route handling and HTTP request/response handling.
* Composer
	* For project dependencies and autoloading.
* Apache

## Project Setup
This project uses an MVC architecture (without the View, of course). Objects are constructed with parameters instantiated elsewhere.
This is so that every object is self-contained without concern for logic that is outside of its own.

The root folder is **`gildedrose`**. Inside of that folder is the following:

* **`src/`** - All of the source code.
* **`test/`** - Contains a simple command line UI to test the API.
* **`vendor/`** - All of the third-party code.
* **`.htaccess`** - Contains rewrite rules for URLs.
* **`composer.json`** - Contains data for project dependencies and autoloading.
* **`composer.lock`** - Autogenerated from composer.json.
* **`index.php`** - The API entry point.
* **`README.md`** - This README file.

Inside of the **`src`** folder is the following:

* **`api/`** - Contains all API related code.
* **`config/`** - Contains configurations files.
* **`sql/`** - Contains SQL files.

Inside of the **`api`** folder is the following:

* **`controllers/`** - Contains all of the controllers. The controllers handle logic related to routing; being the layer between the frontend
and the backend.
* **`daos/`** - Contains all of the DAOs. THe DAOs handle communicating with the database.
* **`database/`** - Contains code related to connecting to the database.
* **`models/`** - Contains all of the models. The models are very self-contained and are essentially wrappers to database objects with additional
business logic.
* **`services/`** - Contains all of the services. The services are responsible for most of the complicated logic and data handling in the backend.
* **`api.php`** - Contains the API bootstrap code. This sets up controllers, services, DAOs, routes, and containers.
* **`routes.php`** - Handles all routing as well as their HTTP methods.

Inside of the **`sql`** folder is the following:

* **`data/`** - Constains SQL code to insert default data in tables.
* **`schemas/`** - Contains SQL code to create schemas.
* **`tables/`** - Contains SQL code to create tables.

## Setting Up to Run the Project
Because this project is developed using PHP and MySQL, it will require setting up and running Apache and MySQL.
This project was developed on a Mac, but the steps needed to set up the project should be similar for Windows.

### Web Server (Apache)
Apache will need to be installed and the project folder will need to be placed inside of the document root folder.

If it hasn't been done already, the following will need to be addressed inside of the `httpd.conf` file, which is usually located inside of the
Apache folder. For me, it was located in `/etc/apache2/`.

* Uncomment `LoadModule php5_module libexec/apache2/libphp5.so`
* Uncomment `LoadModule rewrite_module libexec/apache2/mod_rewrite.so`
* Under `DocumentRoot "path/to/DocumentRoot"`
`<Directory "/path/to/DocumentRoot">` change `AllowOverride` from `None` to `All`.

That should be all that is needed. You may have to check for things in the `php.ini` file in the `PHP` folder if things still seem a little funny.

You will have to restart the Apache web server after any changes.

Alternatively you could also use PHP's webserver:

`$ php -S localhost:8000`

### MySQL
MySQL will need to be installed and running.

SQL files have been provided to set up the database and its tables, as well as populate the `tblRoom` table with data for the four rooms.
They are located in **`/gildedrose/src/sql/`**.

To change the credentials for accessing the database to match what is on your machine, the `config.php` file is located in
**`/gildedrose/src/config/`**.

## Running the Project

There are two ways to make calls to the API.

It is assumed that input will be valid. Dates must be entered in YYYY-MM-DD format. The API has some sanity checking; it checks to see
that the request body is well-formed and all of the required parameters are present. It does not check if the parameters are in the
correct formats.

### Method 1
I have created and provided a simple command-line UI that imitates a hotel booking system. This UI makes the API calls in the code, 
so all the user has to do is follow the prompts.

This program is located in **`gildedrose/test`**. Since this program is a PHP script it could be saved anywhere on your machine if
you wish. To run it, simply navigate to the folder where it is located and run in the command line:

`$ php test.php`

### Method 2
This is the method I used when testing the code as I was developing it. I used a Chrome extension called Postman.

The following URLs are the API endpoints:

* `http://localhost/gildedrose/api/v1/rooms/availability?date={date}&itemCount={itemCount}`
	* This is a GET request
	* **`{date}`** must be in YYYY-MM-DD format
	* **`{itemCount}`** must be 0 or greater

* `http://localhost/gildedrose/api/v1/booking/book`
	* This is a POST request
	* The request body must be in the following format:
	```javascript
	{ 
		"firstName": "John"
		"lastName": "Smith"
		"email": "jsmith@gmail.com"
		"date": "2018-07-04"
		"itemCount": "2"
	}
	```

* `http://localhost/gildedrose/api/v1/management/schedule?date={date}`
	* This is a GET request
	* **`{date}`** must be in YYYY-MM-DD format

## Post-Mortem

### Technical Documents and Consultation
The following are sources that I've used while developing the project:

* http://php.net/manual/en/ - For look ups on PHP libraries, classes, methods, etc.
* https://www.slimframework.com/docs/ - Slim framework user guide.
* https://getcomposer.org/doc/ - Composer user guide.
* https://guides.github.com/features/mastering-markdown/ - Markdown guide. 
* https://www.sitepoint.com/php-authorization-jwt-json-web-tokens/ - For when I wanted to use some kind of authentication/token system for the API
before realizing it's not really needed for the exercise and would take more time.
* https://www.youtube.com/watch?v=l2xghbSlBQg&list=PLCakfctNSHkGQ6S557u-6sLEYsfWje47P&index=1 - Another JWT reference.
* Various Stack Overflow and Google lookups for small things.

### Extending the Project
This project took about 4 days to complete, on and off. The time was divided up into different parts such as researching frameworks, coming up
with a design solution, understanding the requirements, implementing the API, writing comments, and writing this README file. 

I know in the real world there are deadlines for projects/features, but I wanted to be very thorough with this project and showcase 
how I approach problems. I like to be very organized and comment/document what it is I am working on. Because the system is very modularized, 
extending it to accomodate for more Gnome Cleaning Squads, more rooms, and more business logic should be achievable. 

If I were given unlimited time I would do the following to extend the project:

* More flexible check in and check out times for guests. Perhaps v2 could allow a guest to check in any time in the day with checkout
being something like 18 hours later. Maybe v3 could allow a guest to check in any time in the day and check out any time the next day, or even several days later. 
This change would place greater stress on the Gnome Cleaning Squad as they could potentially clean the same room more than once in a day. 
Additional logic would then be needed to make sure that the Gnome Cleaning Squad does not exceed 8 hours. Room availabilities would change significantly.
* Currently the Gnome Cleaning Squad always spends 2 hours cleaning a 2 person room and 1.5 hours cleaning a 1 person room. The system could
* be extended so that if only one person occupies a 2 person room, the Gnome Cleaning Squad only needs 1.5 hours to clean it.
* Allow booking for up to 2 guests at one time.
* More robust input validation and sanity checking. Currently the API checks to see if a request body is well-formed and all of the required parameters
are presents. Input validation would need to be implemented on a parameter level, making sure each parameter is the correct data type and in the
correct format.
* More flexibiity with the API endpoints. For example management could get the Gnome Cleaning Squad schedule between a start and end date,
or a guest can view all room availabilities between a start and end date.
* Add authentication (i.e. JWT tokens) for accessing API endpoints.
* Unit testing and automated testing. A good system also has a good testing suite. Unit testing would be done with PHPUnit. System-wide and
automated testing could use scripts or a tool such as Selenium.

## Closing
I had a lot of fun with this project! I hope you enjoy the project as much as I enjoyed developing it!
