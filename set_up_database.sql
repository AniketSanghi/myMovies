
CREATE DATABASE myMovies;
use myMovies;

CREATE TABLE movies (
	movieID 		int AUTO_INCREMENT PRIMARY KEY,
	title			varchar(200) NOT NULL,
	releaseYear 	varchar(200),
	maleActor		varchar(200),
	femaleActor		varchar(200),
	Director		varchar(200),
	description		varchar(500),
	);

CREATE TABLE genre (
	genreID			int AUTO_INCREMENT PRIMARY KEY,
	genre 			varchar(200) NOT NULL
	);

CREATE TABLE movie_genre (
	movieID			int NOT NULL,
	genreID			int NOT NULL
	);

INSERT INTO genre (genre) VALUES ("action");
INSERT INTO genre (genre) VALUES ("adventure");
INSERT INTO genre (genre) VALUES ("comedy");
INSERT INTO genre (genre) VALUES ("thriller");
INSERT INTO genre (genre) VALUES ("romance");
INSERT INTO genre (genre) VALUES ("crime");
INSERT INTO genre (genre) VALUES ("documentary");
INSERT INTO genre (genre) VALUES ("scifi");
INSERT INTO genre (genre) VALUES ("drama");
INSERT INTO genre (genre) VALUES ("bollywoo");
INSERT INTO genre (genre) VALUES ("western");

CREATE TABLE users (
	userID			int AUTO_INCREMENT PRIMARY KEY,
	username		varchar(200) UNIQUE NOT NULL,
	fullname 		varchar(1000) NOT NULL,
	password		varchar(255) NOT NULL,
	designation		varchar(255) NOT NULL DEFAULT 'user'
	);

CREATE TABLE user_movie_list (
	userID			int,
	movieID			int,
	towatch			int DEFAULT 0,
	watched			int DEFAULT 0,
	rating 			int,
	review			varchar(8000)
	);

CREATE TABLE user_search_history (
	id 				int AUTO_INCREMENT PRIMARY KEY,
	userID			int,
	search 			varchar(200)
	);

/* Creating different designations with different permissions */
CREATE USER admin@localhost IDENTIFIED BY "admin";
GRANT INSERT ON myMovies.* TO admin@localhost;
GRANT SELECT ON myMovies.* TO admin@localhost;
GRANT DELETE ON myMovies.* TO admin@localhost;
GRANT UPDATE ON myMovies.* TO admin@localhost;

CREATE USER dev@localhost IDENTIFIED BY "dev";
GRANT ALL PRIVILEGES ON myMovies.* TO dev@localhost;

CREATE user user@localhost IDENTIFIED BY "user";
GRANT INSERT ON myMovies.user_movie_list TO user@localhost;
GRANT SELECT ON myMovies.user_movie_list TO user@localhost;
GRANT DELETE ON myMovies.user_movie_list TO user@localhost;
GRANT UPDATE ON myMovies.user_movie_list TO user@localhost;
GRANT INSERT ON myMovies.user_search_history TO user@localhost;
GRANT SELECT ON myMovies.user_search_history TO user@localhost;
GRANT DELETE ON myMovies.user_search_history TO user@localhost;
GRANT UPDATE ON myMovies.user_search_history TO user@localhost;
GRANT SELECT ON myMovies.movies TO user@localhost;
GRANT SELECT ON myMovies.movie_genre TO user@localhost;
GRANT SELECT ON myMovies.genre TO user@localhost;

CREATE user guest@localhost IDENTIFIED BY "guest";
GRANT SELECT ON myMovies.movies TO guest@localhost;
GRANT SELECT ON myMovies.movie_genre TO guest@localhost;
GRANT SELECT ON myMovies.genre TO guest@localhost;
