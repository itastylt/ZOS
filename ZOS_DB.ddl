#@(#) script.ddl

DROP TABLE IF EXISTS Matches;
DROP TABLE IF EXISTS Bet;
DROP TABLE IF EXISTS belongs2;
DROP TABLE IF EXISTS Tournament_Player;
DROP TABLE IF EXISTS Team;
DROP TABLE IF EXISTS participates_in;
DROP TABLE IF EXISTS Tournament;
DROP TABLE IF EXISTS Transaction;
DROP TABLE IF EXISTS Organizer;
DROP TABLE IF EXISTS ELO;
DROP TABLE IF EXISTS Player;
DROP TABLE IF EXISTS has1;
DROP TABLE IF EXISTS Game_mode;
DROP TABLE IF EXISTS Administrator;
DROP TABLE IF EXISTS Users;
DROP TABLE IF EXISTS Genre;
DROP TABLE IF EXISTS Game;
CREATE TABLE Game
(
	name varchar (255) NOT NULL,
	description varchar (255) NOT NULL,
	image_url varchar (255) NOT NULL,
	id integer NOT NULL,
	PRIMARY KEY(id)
);

CREATE TABLE Genre
(
	name varchar (255) NOT NULL,
	id integer NOT NULL,
	PRIMARY KEY(id)
);

CREATE TABLE Users
(
	Usersname varchar (255) NOT NULL,
	password varchar (255) NOT NULL,
	email varchar (255) NOT NULL,
	registration_date date NOT NULL,
	image_url varchar (255) NULL,
	id integer NOT NULL,
	PRIMARY KEY(id)
);

CREATE TABLE Administrator
(
	id integer NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY(id) REFERENCES Users (id)
);

CREATE TABLE Game_mode
(
	team_size integer NOT NULL,
	name varchar (255) NOT NULL,
	id integer NOT NULL,
	fk_Gameid integer NOT NULL,
	PRIMARY KEY(id),
	CONSTRAINT turi FOREIGN KEY(fk_Gameid) REFERENCES Game (id)
);

CREATE TABLE has1
(
	fk_Genreid integer NOT NULL,
	fk_Gameid integer NOT NULL,
	PRIMARY KEY(fk_Genreid, fk_Gameid),
	CONSTRAINT has1_genre FOREIGN KEY(fk_Genreid) REFERENCES Genre (id),
	CONSTRAINT has1_game FOREIGN KEY(fk_Gameid) REFERENCES Game (id)
);

CREATE TABLE Player
(
	block_date date NULL,
	block_comment varchar (255) NULL,
	id integer NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY(id) REFERENCES Users (id)
);

CREATE TABLE ELO
(
	points integer NOT NULL,
	id integer NOT NULL,
	fk_Playerid integer NOT NULL,
	fk_Gameid integer NOT NULL,
	PRIMARY KEY(id),
	CONSTRAINT has2 FOREIGN KEY(fk_Playerid) REFERENCES Player (id),
	CONSTRAINT belongs FOREIGN KEY(fk_Gameid) REFERENCES Game (id)
);

CREATE TABLE Organizer
(
	id integer NOT NULL,
	PRIMARY KEY(id),
	FOREIGN KEY(id) REFERENCES Player (id)
);

CREATE TABLE Transaction
(
	change_value float NOT NULL,
	comment varchar (255) NULL,
	time date NOT NULL,
	id integer NOT NULL,
	fk_Playerid integer NOT NULL,
	PRIMARY KEY(id),
	CONSTRAINT performs FOREIGN KEY(fk_Playerid) REFERENCES Player (id)
);

CREATE TABLE Tournament
(
	current_stage integer NULL,
	max_team_count integer NOT NULL,
	player_count integer NOT NULL,
	date date NOT NULL,
	prize_pool float NOT NULL,
	join_price float NOT NULL,
	registration_start date NOT NULL,
	registration_end date NOT NULL,
	tournament_start date NULL,
	status ENUM('unconfirmed', 'confirmed', 'ongoing', 'ended', 'sent_to_admin') NOT NULL,
	id integer NOT NULL,
	fk_Gamemodeid integer NOT NULL,
	fk_Organizerid integer NOT NULL,
	fk_Administratorid integer NULL,
	PRIMARY KEY(id),
	CONSTRAINT has FOREIGN KEY(fk_Gamemodeid) REFERENCES Game_mode (id),
	CONSTRAINT controls FOREIGN KEY(fk_Organizerid) REFERENCES Organizer (id),
	CONSTRAINT confirms FOREIGN KEY(fk_Administratorid) REFERENCES Administrator (id)
);

CREATE TABLE participates_in
(
	fk_Playerid integer NOT NULL,
	fk_Tournamentid integer NOT NULL,
	PRIMARY KEY(fk_Playerid, fk_Tournamentid),
	CONSTRAINT participates_in_player FOREIGN KEY(fk_Playerid) REFERENCES Player (id),
	CONSTRAINT participates_in_tournament FOREIGN KEY(fk_Tournamentid) REFERENCES Tournament(id)
);

CREATE TABLE Team
(
	coefficient float NOT NULL,
	stage integer NULL,
	id integer NOT NULL,
	fk_Tournamentid integer NOT NULL,
	PRIMARY KEY(id),
	CONSTRAINT participates_in1 FOREIGN KEY(fk_Tournamentid) REFERENCES Tournament (id)
);

CREATE TABLE Tournament_Player
(
	fk_Tournamentid integer NOT NULL,
	fk_Playerid integer NOT NULL,
	PRIMARY KEY(fk_Tournamentid, fk_Playerid),
	FOREIGN KEY(fk_Tournamentid) REFERENCES Tournament (id),
	FOREIGN KEY(fk_Playerid) REFERENCES Player (id)
);

CREATE TABLE belongs2
(
	fk_Teamid integer NOT NULL,
	fk_Playerid integer NOT NULL,
	PRIMARY KEY(fk_Teamid, fk_Playerid),
	CONSTRAINT belongs2_team FOREIGN KEY(fk_Teamid) REFERENCES Team (id),
	CONSTRAINT belongs2_player FOREIGN KEY(fk_Playerid) REFERENCES Player (id)
);

CREATE TABLE Bet
(
	placed_sum float NOT NULL,
	winning_sum float NOT NULL,
	id integer NOT NULL,
	fk_Teamid integer NOT NULL,
	fk_Playerid integer NOT NULL,
	PRIMARY KEY(id),
	CONSTRAINT has3 FOREIGN KEY(fk_Teamid) REFERENCES Team (id),
	CONSTRAINT performs_bet FOREIGN KEY(fk_Playerid) REFERENCES Player (id)
);

CREATE TABLE Matches
(
	result varchar (255) NOT NULL,
	end_time date NOT NULL,
	start_time date NOT NULL,
	id integer NOT NULL,
	fk_Teamid integer NULL,
	fk_Teamid1 integer NULL,
	fk_Matchesid integer NULL,
	fk_Teamid2 integer NULL,
	PRIMARY KEY(id),
	UNIQUE(fk_Teamid),
	FOREIGN KEY(fk_Teamid) REFERENCES Team (id),
	CONSTRAINT participates2 FOREIGN KEY(fk_Teamid1) REFERENCES Team (id),
	CONSTRAINT made_of FOREIGN KEY(fk_Matchesid) REFERENCES Matches (id),
	CONSTRAINT participates1 FOREIGN KEY(fk_Teamid2) REFERENCES Team (id)
);
