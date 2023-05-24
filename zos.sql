-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3307
-- Generation Time: May 24, 2023 at 05:08 PM
-- Server version: 10.10.2-MariaDB
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zos`
--

-- --------------------------------------------------------

--
-- Table structure for table `administrator`
--

DROP TABLE IF EXISTS `administrator`;
CREATE TABLE IF NOT EXISTS `administrator` (
    `id` int(11) NOT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`id`) VALUES
    (3);

-- --------------------------------------------------------

--
-- Table structure for table `belongs2`
--

DROP TABLE IF EXISTS `belongs2`;
CREATE TABLE IF NOT EXISTS `belongs2` (
    `fk_Teamid` int(11) NOT NULL,
    `fk_Playerid` int(11) NOT NULL,
    PRIMARY KEY (`fk_Teamid`,`fk_Playerid`),
    KEY `belongs2_player` (`fk_Playerid`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `belongs2`
--

INSERT INTO `belongs2` (`fk_Teamid`, `fk_Playerid`) VALUES
                                                        (878, 10),
                                                        (879, 9),
                                                        (880, 8),
                                                        (881, 13),
                                                        (882, 6),
                                                        (883, 11),
                                                        (884, 7),
                                                        (885, 12),
                                                        (886, 9),
                                                        (886, 17),
                                                        (887, 10),
                                                        (887, 18),
                                                        (888, 15),
                                                        (888, 20),
                                                        (889, 12),
                                                        (889, 16),
                                                        (890, 7),
                                                        (890, 19),
                                                        (891, 13),
                                                        (891, 22),
                                                        (892, 11),
                                                        (892, 21),
                                                        (893, 6),
                                                        (893, 8);

-- --------------------------------------------------------

--
-- Table structure for table `bet`
--

DROP TABLE IF EXISTS `bet`;
CREATE TABLE IF NOT EXISTS `bet` (
                                     `placed_sum` float NOT NULL,
                                     `winning_sum` float NOT NULL,
                                     `id` int(11) NOT NULL AUTO_INCREMENT,
    `fk_Teamid` int(11) NOT NULL,
    `fk_Playerid` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `has3` (`fk_Teamid`),
    KEY `performs_bet` (`fk_Playerid`)
    ) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `bet`
--

INSERT INTO `bet` (`placed_sum`, `winning_sum`, `id`, `fk_Teamid`, `fk_Playerid`) VALUES
                                                                                      (1, 1.25, 1, 1, 6),
                                                                                      (1, 1.25, 2, 1, 6),
                                                                                      (1, 1.25, 3, 1, 6),
                                                                                      (1, 1.25, 4, 1, 6),
                                                                                      (1, 1.25, 5, 1, 6),
                                                                                      (123, 153.75, 6, 1, 6),
                                                                                      (3, 3.75, 7, 1, 6),
                                                                                      (4, 5, 8, 1, 6),
                                                                                      (4, 5, 9, 1, 6),
                                                                                      (50, 62.5, 10, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `elo`
--

DROP TABLE IF EXISTS `elo`;
CREATE TABLE IF NOT EXISTS `elo` (
    `points` int(11) NOT NULL,
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `fk_Playerid` int(11) NOT NULL,
    `fk_Gameid` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `has2` (`fk_Playerid`),
    KEY `belongs` (`fk_Gameid`)
    ) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `elo`
--

INSERT INTO `elo` (`points`, `id`, `fk_Playerid`, `fk_Gameid`) VALUES
                                                                   (450, 1, 6, 1),
                                                                   (500, 2, 7, 1),
                                                                   (500, 3, 8, 1),
                                                                   (500, 4, 9, 1),
                                                                   (700, 5, 10, 1),
                                                                   (500, 6, 11, 1),
                                                                   (500, 7, 12, 1),
                                                                   (500, 8, 13, 1),
                                                                   (500, 9, 15, 1),
                                                                   (500, 10, 16, 1),
                                                                   (500, 11, 17, 1),
                                                                   (500, 12, 18, 1),
                                                                   (500, 13, 19, 1),
                                                                   (500, 14, 20, 1),
                                                                   (500, 15, 21, 1),
                                                                   (500, 16, 22, 1);

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

DROP TABLE IF EXISTS `game`;
CREATE TABLE IF NOT EXISTS `game` (
    `name` varchar(255) NOT NULL,
    `description` varchar(255) NOT NULL,
    `image_url` varchar(255) NOT NULL,
    `id` int(11) NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `game`
--

INSERT INTO `game` (`name`, `description`, `image_url`, `id`) VALUES
                                                                  ('Counter-Strike 1.6', 'Žaidimo esmė yra kovoti vienai komandai prieš kitą šaunamaisiais ginklais, peiliais arba granatomis. Yra dvi komandos: teroristai ir policijos specialiosios pajėgos. Už kiekvieną nušautą kitos komandos žaidėją gaunamas taškas. Raundą laimi komanda, nukovu', '1684765314.png', 1),
                                                                  ('osu!', 'ritminis žaidimas, renkami taškai už teisingą mušimą į ritmą', '1684849757.jpg', 2);

-- --------------------------------------------------------

--
-- Table structure for table `game_mode`
--

DROP TABLE IF EXISTS `game_mode`;
CREATE TABLE IF NOT EXISTS `game_mode` (
    `team_size` int(11) NOT NULL,
    `name` varchar(255) NOT NULL,
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `fk_Gameid` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `turi` (`fk_Gameid`)
    ) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `game_mode`
--

INSERT INTO `game_mode` (`team_size`, `name`, `id`, `fk_Gameid`) VALUES
                                                                     (5, 'AutoMIX', 11, 1),
                                                                     (5, 'Competitive 5v5', 12, 1),
                                                                     (1, '1v1', 13, 1),
                                                                     (1, 'osu!taiko', 14, 2),
                                                                     (2, 'Wingman', 15, 1),
                                                                     (1, 'osu!mania', 16, 2);

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

DROP TABLE IF EXISTS `genre`;
CREATE TABLE IF NOT EXISTS `genre` (
    `name` varchar(255) NOT NULL,
    `id` int(11) NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- --------------------------------------------------------

--
-- Table structure for table `has1`
--

DROP TABLE IF EXISTS `has1`;
CREATE TABLE IF NOT EXISTS `has1` (
    `fk_Genreid` int(11) NOT NULL,
    `fk_Gameid` int(11) NOT NULL,
    PRIMARY KEY (`fk_Genreid`,`fk_Gameid`),
    KEY `has1_game` (`fk_Gameid`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- --------------------------------------------------------

--
-- Table structure for table `matches`
--

DROP TABLE IF EXISTS `matches`;
CREATE TABLE IF NOT EXISTS `matches` (
    `result` varchar(255) DEFAULT NULL,
    `end_time` date DEFAULT NULL,
    `start_time` date DEFAULT NULL,
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `fk_Teamid` int(11) DEFAULT NULL,
    `fk_Teamid1` int(11) DEFAULT NULL,
    `fk_Matchesid` int(11) DEFAULT NULL,
    `fk_Teamid2` int(11) DEFAULT NULL,
    `fk_lower1` int(11) DEFAULT NULL,
    `fk_lower2` int(11) DEFAULT NULL,
    `stage` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `fk_Teamid` (`fk_Teamid`),
    KEY `participates2` (`fk_Teamid1`),
    KEY `made_of` (`fk_Matchesid`),
    KEY `participates1` (`fk_Teamid2`),
    KEY `lower1` (`fk_lower1`),
    KEY `lower2` (`fk_lower2`)
    ) ENGINE=InnoDB AUTO_INCREMENT=313 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `matches`
--

INSERT INTO `matches` (`result`, `end_time`, `start_time`, `id`, `fk_Teamid`, `fk_Teamid1`, `fk_Matchesid`, `fk_Teamid2`, `fk_lower1`, `fk_lower2`, `stage`) VALUES
                                                                                                                                                                 (NULL, NULL, NULL, 292, NULL, NULL, NULL, NULL, 293, 294, 0),
                                                                                                                                                                 (NULL, NULL, NULL, 299, NULL, NULL, NULL, NULL, 300, 301, 0),
                                                                                                                                                                 (NULL, NULL, NULL, 300, NULL, NULL, 299, NULL, 302, 303, 1),
                                                                                                                                                                 (NULL, NULL, NULL, 301, NULL, NULL, 299, NULL, 304, 305, 1),
                                                                                                                                                                 (NULL, NULL, NULL, 302, NULL, 878, 300, 882, NULL, NULL, 2),
                                                                                                                                                                 (NULL, NULL, NULL, 303, NULL, 879, 300, 884, NULL, NULL, 2),
                                                                                                                                                                 (NULL, NULL, NULL, 304, NULL, 885, 301, 880, NULL, NULL, 2),
                                                                                                                                                                 (NULL, NULL, NULL, 305, NULL, 881, 301, 883, NULL, NULL, 2),
                                                                                                                                                                 (NULL, NULL, NULL, 306, NULL, NULL, NULL, NULL, 307, 308, 0),
                                                                                                                                                                 (NULL, NULL, NULL, 307, NULL, NULL, 306, NULL, 309, 310, 1),
                                                                                                                                                                 (NULL, NULL, NULL, 308, NULL, NULL, 306, NULL, 311, 312, 1),
                                                                                                                                                                 (NULL, NULL, NULL, 309, NULL, 887, 307, 893, NULL, NULL, 2),
                                                                                                                                                                 (NULL, NULL, NULL, 310, NULL, 892, 307, 889, NULL, NULL, 2),
                                                                                                                                                                 (NULL, NULL, NULL, 311, NULL, 888, 308, 891, NULL, NULL, 2),
                                                                                                                                                                 (NULL, NULL, NULL, 312, NULL, 890, 308, 886, NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `most_popular_game`
--

DROP TABLE IF EXISTS `most_popular_game`;
CREATE TABLE IF NOT EXISTS `most_popular_game` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `name` varchar(255) NOT NULL,
    `quantity` int(11) NOT NULL DEFAULT 0,
    `update_date` date NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `most_popular_game`
--

INSERT INTO `most_popular_game` (`id`, `name`, `quantity`, `update_date`) VALUES
                                                                              (1, 'Minecraft', 270, '2023-05-22'),
                                                                              (2, 'Roblox', 1241, '2023-05-22');

-- --------------------------------------------------------

--
-- Table structure for table `organizer`
--

DROP TABLE IF EXISTS `organizer`;
CREATE TABLE IF NOT EXISTS `organizer` (
    `id` int(11) NOT NULL,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `organizer`
--

INSERT INTO `organizer` (`id`) VALUES
                                   (1),
                                   (6);

-- --------------------------------------------------------

--
-- Table structure for table `participates_in`
--

DROP TABLE IF EXISTS `participates_in`;
CREATE TABLE IF NOT EXISTS `participates_in` (
    `fk_Playerid` int(11) NOT NULL,
    `fk_Tournamentid` int(11) NOT NULL,
    PRIMARY KEY (`fk_Playerid`,`fk_Tournamentid`),
    KEY `participates_in_tournament` (`fk_Tournamentid`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `participates_in`
--

INSERT INTO `participates_in` (`fk_Playerid`, `fk_Tournamentid`) VALUES
                                                                     (3, 6),
                                                                     (6, 7),
                                                                     (6, 8),
                                                                     (6, 9),
                                                                     (6, 10),
                                                                     (7, 8),
                                                                     (7, 10),
                                                                     (8, 8),
                                                                     (8, 10),
                                                                     (9, 8),
                                                                     (9, 10),
                                                                     (10, 8),
                                                                     (10, 10),
                                                                     (11, 8),
                                                                     (11, 10),
                                                                     (12, 8),
                                                                     (12, 10),
                                                                     (13, 8),
                                                                     (13, 10),
                                                                     (15, 10),
                                                                     (16, 6),
                                                                     (16, 10),
                                                                     (17, 10),
                                                                     (18, 10),
                                                                     (19, 10),
                                                                     (20, 10),
                                                                     (21, 10),
                                                                     (22, 10);

-- --------------------------------------------------------

--
-- Table structure for table `player`
--

DROP TABLE IF EXISTS `player`;
CREATE TABLE IF NOT EXISTS `player` (
                                        `block_date` date DEFAULT NULL,
                                        `block_comment` varchar(255) DEFAULT NULL,
    `id` int(11) NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `player`
--

INSERT INTO `player` (`block_date`, `block_comment`, `id`) VALUES
                                                               ('2023-05-21', 'saddas', 1),
                                                               (NULL, NULL, 2),
                                                               (NULL, NULL, 3),
                                                               (NULL, NULL, 5),
                                                               (NULL, NULL, 6),
                                                               (NULL, NULL, 7),
                                                               (NULL, NULL, 8),
                                                               (NULL, NULL, 9),
                                                               (NULL, NULL, 10),
                                                               (NULL, NULL, 11),
                                                               (NULL, NULL, 12),
                                                               (NULL, NULL, 13),
                                                               (NULL, NULL, 14),
                                                               (NULL, NULL, 15),
                                                               (NULL, NULL, 16),
                                                               (NULL, NULL, 17),
                                                               (NULL, NULL, 18),
                                                               (NULL, NULL, 19),
                                                               (NULL, NULL, 20),
                                                               (NULL, NULL, 21),
                                                               (NULL, NULL, 22);

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

DROP TABLE IF EXISTS `team`;
CREATE TABLE IF NOT EXISTS `team` (
    `name` varchar(255) DEFAULT NULL,
    `coefficient` float NOT NULL,
    `stage` int(11) DEFAULT NULL,
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `fk_Tournamentid` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `participates_in1` (`fk_Tournamentid`)
    ) ENGINE=InnoDB AUTO_INCREMENT=894 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`name`, `coefficient`, `stage`, `id`, `fk_Tournamentid`) VALUES
                                                                                 (NULL, 0.25, 0, 1, 6),
                                                                                 (NULL, 0.25, 0, 2, 6),
                                                                                 (NULL, 0.25, 0, 3, 6),
                                                                                 (NULL, 0.25, 0, 4, 6),
                                                                                 ('player4 team', 0, NULL, 878, 8),
                                                                                 ('player3 team', 0, NULL, 879, 8),
                                                                                 ('player2 team', 0, NULL, 880, 8),
                                                                                 ('player7 team', 0, NULL, 881, 8),
                                                                                 ('Organisator team', 0, NULL, 882, 8),
                                                                                 ('player5 team', 0, NULL, 883, 8),
                                                                                 ('player1 team', 0, NULL, 884, 8),
                                                                                 ('player6 team', 0, NULL, 885, 8),
                                                                                 ('player3 team', 0, NULL, 886, 10),
                                                                                 ('player4 team', 0, NULL, 887, 10),
                                                                                 ('p8 team', 0, NULL, 888, 10),
                                                                                 ('player6 team', 0, NULL, 889, 10),
                                                                                 ('player1 team', 0, NULL, 890, 10),
                                                                                 ('player7 team', 0, NULL, 891, 10),
                                                                                 ('player5 team', 0, NULL, 892, 10),
                                                                                 ('player2 team', 0, NULL, 893, 10);

-- --------------------------------------------------------

--
-- Table structure for table `tournament`
--

DROP TABLE IF EXISTS `tournament`;
CREATE TABLE IF NOT EXISTS `tournament` (
    `current_stage` int(11) DEFAULT NULL,
    `max_team_count` int(11) NOT NULL,
    `player_count` int(11) NOT NULL,
    `date` date NOT NULL,
    `prize_pool` float NOT NULL,
    `join_price` float NOT NULL,
    `registration_start` date NOT NULL,
    `registration_end` date NOT NULL,
    `tournament_start` date DEFAULT NULL,
    `status` enum('unconfirmed','confirmed','ongoing','ended','sent_to_admin') NOT NULL,
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `fk_Gamemodeid` int(11) NOT NULL,
    `fk_Organizerid` int(11) NOT NULL,
    `fk_Administratorid` int(11) DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `has` (`fk_Gamemodeid`),
    KEY `controls` (`fk_Organizerid`),
    KEY `confirms` (`fk_Administratorid`)
    ) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `tournament`
--

INSERT INTO `tournament` (`current_stage`, `max_team_count`, `player_count`, `date`, `prize_pool`, `join_price`, `registration_start`, `registration_end`, `tournament_start`, `status`, `id`, `fk_Gamemodeid`, `fk_Organizerid`, `fk_Administratorid`) VALUES
                                                                                                                                                                                                                                                            (0, 16, 80, '0000-00-00', 1000, 100, '2023-05-24', '2023-05-30', '2023-05-31', 'confirmed', 6, 11, 6, NULL),
                                                                                                                                                                                                                                                            (0, 16, 80, '0000-00-00', 1000, 30, '2023-05-23', '2023-05-24', '2023-05-25', 'sent_to_admin', 7, 12, 6, NULL),
                                                                                                                                                                                                                                                            (0, 8, 8, '0000-00-00', 50, 10, '2023-05-22', '2023-05-25', '2023-05-24', 'confirmed', 8, 13, 6, NULL),
                                                                                                                                                                                                                                                            (0, 8, 8, '0000-00-00', 500, 100, '2023-05-22', '2023-05-24', '2023-05-23', 'unconfirmed', 9, 14, 6, NULL),
                                                                                                                                                                                                                                                            (0, 8, 16, '0000-00-00', 100, 10, '2023-05-23', '2023-05-26', '2023-05-24', 'confirmed', 10, 15, 6, NULL),
                                                                                                                                                                                                                                                            (0, 16, 16, '0000-00-00', 100, 10, '2023-05-23', '2023-05-26', '2023-05-24', 'sent_to_admin', 11, 16, 6, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tournament_player`
--

DROP TABLE IF EXISTS `tournament_player`;
CREATE TABLE IF NOT EXISTS `tournament_player` (
    `fk_Tournamentid` int(11) NOT NULL,
    `fk_Playerid` int(11) NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (`fk_Tournamentid`,`fk_Playerid`),
    KEY `fk_Playerid` (`fk_Playerid`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

DROP TABLE IF EXISTS `transaction`;
CREATE TABLE IF NOT EXISTS `transaction` (
                                             `change_value` float NOT NULL,
                                             `comment` varchar(255) DEFAULT NULL,
    `time` date NOT NULL,
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `fk_Playerid` int(11) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `performs` (`fk_Playerid`)
    ) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`change_value`, `comment`, `time`, `id`, `fk_Playerid`) VALUES
                                                                                       (-1000, 'Sent 1000 e transaction to PaySera', '2023-05-22', 4, 6),
                                                                                       (-1, 'Sent 1 e transaction to PaySera', '2023-05-22', 5, 6),
                                                                                       (-1, 'Sent 1 e transaction to PaySera', '2023-05-22', 6, 6),
                                                                                       (-1, 'Sent 1 e transaction to PaySera', '2023-05-22', 7, 6),
                                                                                       (-1, 'Sent 1 e transaction to PaySera', '2023-05-22', 8, 6),
                                                                                       (-123, 'Sent 123 e transaction to PaySera', '2023-05-22', 9, 6),
                                                                                       (-3, 'Sent 3 e transaction to PaySera', '2023-05-22', 10, 6),
                                                                                       (-4, 'Sent 4 e transaction to PaySera', '2023-05-22', 11, 6),
                                                                                       (-4, 'Sent 4 e transaction to PaySera', '2023-05-22', 12, 6),
                                                                                       (-100, 'Sent 100 e transaction to PaySera', '2023-05-23', 13, 3),
                                                                                       (-50, 'Sent 50 e transaction to PaySera', '2023-05-23', 14, 3),
                                                                                       (-1000, 'Sent 1000 e transaction to PaySera', '2023-05-23', 15, 6),
                                                                                       (-50, 'Sent 50 e transaction to PaySera', '2023-05-23', 16, 6),
                                                                                       (-30, 'Sent 30 e transaction to PaySera', '2023-05-23', 17, 6),
                                                                                       (-500, 'Sent 500 e transaction to PaySera', '2023-05-23', 18, 6),
                                                                                       (-100, 'Sent 100 e transaction to PaySera', '2023-05-23', 19, 6),
                                                                                       (-10, 'Sent 10 e transaction to PaySera', '2023-05-24', 20, 7),
                                                                                       (-10, 'Sent 10 e transaction to PaySera', '2023-05-24', 21, 8),
                                                                                       (-10, 'Sent 10 e transaction to PaySera', '2023-05-24', 22, 9),
                                                                                       (-10, 'Sent 10 e transaction to PaySera', '2023-05-24', 23, 10),
                                                                                       (-10, 'Sent 10 e transaction to PaySera', '2023-05-24', 24, 12),
                                                                                       (-10, 'Sent 10 e transaction to PaySera', '2023-05-24', 25, 11),
                                                                                       (-10, 'Sent 10 e transaction to PaySera', '2023-05-24', 26, 13),
                                                                                       (-10, 'Sent 10 e transaction to PaySera', '2023-05-24', 27, 6),
                                                                                       (-10, 'Sent 10 e transaction to PaySera', '2023-05-24', 28, 14),
                                                                                       (-10, 'Sent 10 e transaction to PaySera', '2023-05-24', 29, 14),
                                                                                       (-100, 'Sent 100 e transaction to PaySera', '2023-05-24', 30, 6),
                                                                                       (-10, 'Sent 10 e transaction to PaySera', '2023-05-24', 31, 6),
                                                                                       (-10, 'Sent 10 e transaction to PaySera', '2023-05-24', 32, 7),
                                                                                       (-10, 'Sent 10 e transaction to PaySera', '2023-05-24', 33, 8),
                                                                                       (-10, 'Sent 10 e transaction to PaySera', '2023-05-24', 34, 9),
                                                                                       (-10, 'Sent 10 e transaction to PaySera', '2023-05-24', 35, 10),
                                                                                       (-10, 'Sent 10 e transaction to PaySera', '2023-05-24', 36, 11),
                                                                                       (-10, 'Sent 10 e transaction to PaySera', '2023-05-24', 37, 12),
                                                                                       (-10, 'Sent 10 e transaction to PaySera', '2023-05-24', 38, 13),
                                                                                       (-10, 'Sent 10 e transaction to PaySera', '2023-05-24', 39, 15),
                                                                                       (-10, 'Sent 10 e transaction to PaySera', '2023-05-24', 40, 16),
                                                                                       (-10, 'Sent 10 e transaction to PaySera', '2023-05-24', 41, 17),
                                                                                       (-10, 'Sent 10 e transaction to PaySera', '2023-05-24', 42, 18),
                                                                                       (-10, 'Sent 10 e transaction to PaySera', '2023-05-24', 43, 19),
                                                                                       (-10, 'Sent 10 e transaction to PaySera', '2023-05-24', 44, 20),
                                                                                       (-10, 'Sent 10 e transaction to PaySera', '2023-05-24', 45, 21),
                                                                                       (-10, 'Sent 10 e transaction to PaySera', '2023-05-24', 46, 22),
                                                                                       (-100, 'Sent 100 e transaction to PaySera', '2023-05-24', 47, 6),
                                                                                       (-100, 'Sent 100 e transaction to PaySera', '2023-05-24', 48, 16);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
    `username` varchar(255) NOT NULL,
    `password` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `registration_date` date NOT NULL,
    `image_url` varchar(255) DEFAULT NULL,
    `id` int(11) NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (`id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `email`, `registration_date`, `image_url`, `id`) VALUES
                                                                                                 ('User', 'slaptazodis', 'user@gmail.com', '2023-05-21', 'asdasdasdasd', 1),
                                                                                                 ('wadsda', 'asdawd', 'asdawd', '2023-05-22', 'asdawd', 2),
                                                                                                 ('admin', 'admin', 'admin@localhost.lt', '2023-05-22', '1684757086.png', 3),
                                                                                                 ('testas', 'ttt', 'mezencevas.andrius@gmail.com', '2023-05-22', '1684757102.png', 4),
                                                                                                 ('testas1', 'testas1', 'theandriux26a@gmail.com', '2023-05-22', '1684758745.png', 5),
                                                                                                 ('Organisator', 'Organisator', 'factionsbrawl@gmail.com', '2023-05-22', '1684762232.png', 6),
                                                                                                 ('player1', 'p1', 'ignasijuschose@gmail.com', '2023-05-24', '1684883184.jpg', 7),
                                                                                                 ('player2', 'p2', 'i.rupeika@ktu.edu', '2023-05-24', '1684883248.jpg', 8),
                                                                                                 ('player3', 'p3', 'a@a.lt', '2023-05-24', '1684883266.jpg', 9),
                                                                                                 ('player4', 'p4', 'b@b.lt', '2023-05-24', '1684883280.jpg', 10),
                                                                                                 ('player5', 'p5', 'c@c.lt', '2023-05-24', '1684883297.jpg', 11),
                                                                                                 ('player6', 'p6', 'p6@p.lt', '2023-05-24', '1684883313.jpg', 12),
                                                                                                 ('player7', 'p7', 'p7@p.lt', '2023-05-24', '1684883328.jpg', 13),
                                                                                                 ('player10', 'p10', 'p10@p.lt', '2023-05-24', '1684883575.jpg', 14),
                                                                                                 ('p8', 'p8', 'p8@lt.lt', '2023-05-24', '1684946856.jpg', 15),
                                                                                                 ('p9', 'p9', '9p@po.lt', '2023-05-24', '1684946871.jpg', 16),
                                                                                                 ('p10', 'p10', 'p10@p10.lt', '2023-05-24', '1684946888.jpg', 17),
                                                                                                 ('p11', 'p11', 'p11@jfaf.tl', '2023-05-24', '1684946903.jpg', 18),
                                                                                                 ('p12', 'p12', 'jafjaf@kf.lt', '2023-05-24', '1684946918.jpg', 19),
                                                                                                 ('p13', 'p13', 'p13@pp.lt', '2023-05-24', '1684946957.jpg', 20),
                                                                                                 ('p14', 'p14', 'p14@14p.lt', '2023-05-24', '1684946971.jpg', 21),
                                                                                                 ('p15', 'p15', 'p15@pp.lt', '2023-05-24', '1684946988.jpg', 22);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `administrator`
--
ALTER TABLE `administrator`
    ADD CONSTRAINT `administrator_ibfk_1` FOREIGN KEY (`id`) REFERENCES `user` (`id`);

--
-- Constraints for table `belongs2`
--
ALTER TABLE `belongs2`
    ADD CONSTRAINT `belongs2_player` FOREIGN KEY (`fk_Playerid`) REFERENCES `player` (`id`),
  ADD CONSTRAINT `belongs2_team` FOREIGN KEY (`fk_Teamid`) REFERENCES `team` (`id`);

--
-- Constraints for table `bet`
--
ALTER TABLE `bet`
    ADD CONSTRAINT `has3` FOREIGN KEY (`fk_Teamid`) REFERENCES `team` (`id`),
  ADD CONSTRAINT `performs_bet` FOREIGN KEY (`fk_Playerid`) REFERENCES `player` (`id`);

--
-- Constraints for table `elo`
--
ALTER TABLE `elo`
    ADD CONSTRAINT `belongs` FOREIGN KEY (`fk_Gameid`) REFERENCES `game` (`id`),
  ADD CONSTRAINT `has2` FOREIGN KEY (`fk_Playerid`) REFERENCES `player` (`id`);

--
-- Constraints for table `game_mode`
--
ALTER TABLE `game_mode`
    ADD CONSTRAINT `turi` FOREIGN KEY (`fk_Gameid`) REFERENCES `game` (`id`);

--
-- Constraints for table `has1`
--
ALTER TABLE `has1`
    ADD CONSTRAINT `has1_game` FOREIGN KEY (`fk_Gameid`) REFERENCES `game` (`id`),
  ADD CONSTRAINT `has1_genre` FOREIGN KEY (`fk_Genreid`) REFERENCES `genre` (`id`);

--
-- Constraints for table `matches`
--
ALTER TABLE `matches`
    ADD CONSTRAINT `lower1` FOREIGN KEY (`fk_lower1`) REFERENCES `matches` (`id`),
  ADD CONSTRAINT `lower2` FOREIGN KEY (`fk_lower2`) REFERENCES `matches` (`id`),
  ADD CONSTRAINT `made_of` FOREIGN KEY (`fk_Matchesid`) REFERENCES `matches` (`id`),
  ADD CONSTRAINT `matches_ibfk_1` FOREIGN KEY (`fk_Teamid`) REFERENCES `team` (`id`),
  ADD CONSTRAINT `participates1` FOREIGN KEY (`fk_Teamid2`) REFERENCES `team` (`id`),
  ADD CONSTRAINT `participates2` FOREIGN KEY (`fk_Teamid1`) REFERENCES `team` (`id`);

--
-- Constraints for table `organizer`
--
ALTER TABLE `organizer`
    ADD CONSTRAINT `organizer_ibfk_1` FOREIGN KEY (`id`) REFERENCES `player` (`id`);

--
-- Constraints for table `participates_in`
--
ALTER TABLE `participates_in`
    ADD CONSTRAINT `participates_in_player` FOREIGN KEY (`fk_Playerid`) REFERENCES `player` (`id`),
  ADD CONSTRAINT `participates_in_tournament` FOREIGN KEY (`fk_Tournamentid`) REFERENCES `tournament` (`id`);

--
-- Constraints for table `player`
--
ALTER TABLE `player`
    ADD CONSTRAINT `player_ibfk_1` FOREIGN KEY (`id`) REFERENCES `user` (`id`);

--
-- Constraints for table `team`
--
ALTER TABLE `team`
    ADD CONSTRAINT `participates_in1` FOREIGN KEY (`fk_Tournamentid`) REFERENCES `tournament` (`id`);

--
-- Constraints for table `tournament`
--
ALTER TABLE `tournament`
    ADD CONSTRAINT `confirms` FOREIGN KEY (`fk_Administratorid`) REFERENCES `administrator` (`id`),
  ADD CONSTRAINT `controls` FOREIGN KEY (`fk_Organizerid`) REFERENCES `organizer` (`id`),
  ADD CONSTRAINT `has` FOREIGN KEY (`fk_Gamemodeid`) REFERENCES `game_mode` (`id`);

--
-- Constraints for table `tournament_player`
--
ALTER TABLE `tournament_player`
    ADD CONSTRAINT `tournament_player_ibfk_1` FOREIGN KEY (`fk_Tournamentid`) REFERENCES `tournament` (`id`),
  ADD CONSTRAINT `tournament_player_ibfk_2` FOREIGN KEY (`fk_Playerid`) REFERENCES `player` (`id`);

--
-- Constraints for table `transaction`
--
ALTER TABLE `transaction`
    ADD CONSTRAINT `performs` FOREIGN KEY (`fk_Playerid`) REFERENCES `player` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
