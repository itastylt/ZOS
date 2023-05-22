-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 22, 2023 at 10:11 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.0.13

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

CREATE TABLE `administrator` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `administrator`
--

INSERT INTO `administrator` (`id`) VALUES
(3);

-- --------------------------------------------------------

--
-- Table structure for table `belongs2`
--

CREATE TABLE `belongs2` (
  `fk_Teamid` int(11) NOT NULL,
  `fk_Playerid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `bet`
--

CREATE TABLE `bet` (
  `placed_sum` float NOT NULL,
  `winning_sum` float NOT NULL,
  `id` int(11) NOT NULL,
  `fk_Teamid` int(11) NOT NULL,
  `fk_Playerid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
(3, 3.75, 7, 1, 6);

-- --------------------------------------------------------

--
-- Table structure for table `elo`
--

CREATE TABLE `elo` (
  `points` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `fk_Playerid` int(11) NOT NULL,
  `fk_Gameid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE `game` (
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `description` varchar(255) COLLATE utf8_bin NOT NULL,
  `image_url` varchar(255) COLLATE utf8_bin NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `game`
--

INSERT INTO `game` (`name`, `description`, `image_url`, `id`) VALUES
('Counter-Strike 1.6', 'Žaidimo esmė yra kovoti vienai komandai prieš kitą šaunamaisiais ginklais, peiliais arba granatomis. Yra dvi komandos: teroristai ir policijos specialiosios pajėgos. Už kiekvieną nušautą kitos komandos žaidėją gaunamas taškas. Raundą laimi komanda, nukovu', '1684765314.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `game_mode`
--

CREATE TABLE `game_mode` (
  `team_size` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `id` int(11) NOT NULL,
  `fk_Gameid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `game_mode`
--

INSERT INTO `game_mode` (`team_size`, `name`, `id`, `fk_Gameid`) VALUES
(5, 'AutoMIX', 11, 1);

-- --------------------------------------------------------

--
-- Table structure for table `genre`
--

CREATE TABLE `genre` (
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `has1`
--

CREATE TABLE `has1` (
  `fk_Genreid` int(11) NOT NULL,
  `fk_Gameid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `matches`
--

CREATE TABLE `matches` (
  `result` varchar(255) COLLATE utf8_bin NOT NULL,
  `end_time` date NOT NULL,
  `start_time` date NOT NULL,
  `id` int(11) NOT NULL,
  `fk_Teamid` int(11) DEFAULT NULL,
  `fk_Teamid1` int(11) DEFAULT NULL,
  `fk_Matchesid` int(11) DEFAULT NULL,
  `fk_Teamid2` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `most_popular_game`
--

CREATE TABLE `most_popular_game` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `update_date` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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

CREATE TABLE `organizer` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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

CREATE TABLE `participates_in` (
  `fk_Playerid` int(11) NOT NULL,
  `fk_Tournamentid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `player`
--

CREATE TABLE `player` (
  `block_date` date DEFAULT NULL,
  `block_comment` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `player`
--

INSERT INTO `player` (`block_date`, `block_comment`, `id`) VALUES
('2023-05-21', 'saddas', 1),
(NULL, NULL, 2),
(NULL, NULL, 3),
(NULL, NULL, 5),
(NULL, NULL, 6);

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `coefficient` float NOT NULL,
  `stage` int(11) DEFAULT NULL,
  `id` int(11) NOT NULL,
  `fk_Tournamentid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`coefficient`, `stage`, `id`, `fk_Tournamentid`) VALUES
(0.25, 0, 1, 6),
(0.25, 0, 2, 6),
(0.25, 0, 3, 6),
(0.25, 0, 4, 6);

-- --------------------------------------------------------

--
-- Table structure for table `tournament`
--

CREATE TABLE `tournament` (
  `current_stage` int(11) DEFAULT NULL,
  `max_team_count` int(11) NOT NULL,
  `player_count` int(11) NOT NULL,
  `date` date NOT NULL,
  `prize_pool` float NOT NULL,
  `join_price` float NOT NULL,
  `registration_start` date NOT NULL,
  `registration_end` date NOT NULL,
  `tournament_start` date DEFAULT NULL,
  `status` enum('unconfirmed','confirmed','ongoing','ended','sent_to_admin') COLLATE utf8_bin NOT NULL,
  `id` int(11) NOT NULL,
  `fk_Gamemodeid` int(11) NOT NULL,
  `fk_Organizerid` int(11) NOT NULL,
  `fk_Administratorid` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `tournament`
--

INSERT INTO `tournament` (`current_stage`, `max_team_count`, `player_count`, `date`, `prize_pool`, `join_price`, `registration_start`, `registration_end`, `tournament_start`, `status`, `id`, `fk_Gamemodeid`, `fk_Organizerid`, `fk_Administratorid`) VALUES
(0, 16, 80, '0000-00-00', 1000, 100, '2023-05-24', '2023-05-30', '2023-05-31', '', 6, 11, 6, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tournament_player`
--

CREATE TABLE `tournament_player` (
  `fk_Tournamentid` int(11) NOT NULL,
  `fk_Playerid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `change_value` float NOT NULL,
  `comment` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `time` date NOT NULL,
  `id` int(11) NOT NULL,
  `fk_Playerid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

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
(-3, 'Sent 3 e transaction to PaySera', '2023-05-22', 10, 6);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(255) COLLATE utf8_bin NOT NULL,
  `password` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `registration_date` date NOT NULL,
  `image_url` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`, `email`, `registration_date`, `image_url`, `id`) VALUES
('User', 'slaptazodis', 'user@gmail.com', '2023-05-21', 'asdasdasdasd', 1),
('wadsda', 'asdawd', 'asdawd', '2023-05-22', 'asdawd', 2),
('admin', 'admin', 'admin@localhost.lt', '2023-05-22', '1684757086.png', 3),
('testas', 'ttt', 'mezencevas.andrius@gmail.com', '2023-05-22', '1684757102.png', 4),
('testas1', 'testas1', 'theandriux26a@gmail.com', '2023-05-22', '1684758745.png', 5),
('Organisator', 'Organisator', 'factionsbrawl@gmail.com', '2023-05-22', '1684762232.png', 6);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `belongs2`
--
ALTER TABLE `belongs2`
  ADD PRIMARY KEY (`fk_Teamid`,`fk_Playerid`),
  ADD KEY `belongs2_player` (`fk_Playerid`);

--
-- Indexes for table `bet`
--
ALTER TABLE `bet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `has3` (`fk_Teamid`),
  ADD KEY `performs_bet` (`fk_Playerid`);

--
-- Indexes for table `elo`
--
ALTER TABLE `elo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `has2` (`fk_Playerid`),
  ADD KEY `belongs` (`fk_Gameid`);

--
-- Indexes for table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `game_mode`
--
ALTER TABLE `game_mode`
  ADD PRIMARY KEY (`id`),
  ADD KEY `turi` (`fk_Gameid`);

--
-- Indexes for table `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `has1`
--
ALTER TABLE `has1`
  ADD PRIMARY KEY (`fk_Genreid`,`fk_Gameid`),
  ADD KEY `has1_game` (`fk_Gameid`);

--
-- Indexes for table `matches`
--
ALTER TABLE `matches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fk_Teamid` (`fk_Teamid`),
  ADD KEY `participates2` (`fk_Teamid1`),
  ADD KEY `made_of` (`fk_Matchesid`),
  ADD KEY `participates1` (`fk_Teamid2`);

--
-- Indexes for table `most_popular_game`
--
ALTER TABLE `most_popular_game`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `organizer`
--
ALTER TABLE `organizer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `participates_in`
--
ALTER TABLE `participates_in`
  ADD PRIMARY KEY (`fk_Playerid`,`fk_Tournamentid`),
  ADD KEY `participates_in_tournament` (`fk_Tournamentid`);

--
-- Indexes for table `player`
--
ALTER TABLE `player`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`id`),
  ADD KEY `participates_in1` (`fk_Tournamentid`);

--
-- Indexes for table `tournament`
--
ALTER TABLE `tournament`
  ADD PRIMARY KEY (`id`),
  ADD KEY `has` (`fk_Gamemodeid`),
  ADD KEY `controls` (`fk_Organizerid`),
  ADD KEY `confirms` (`fk_Administratorid`);

--
-- Indexes for table `tournament_player`
--
ALTER TABLE `tournament_player`
  ADD PRIMARY KEY (`fk_Tournamentid`,`fk_Playerid`),
  ADD KEY `fk_Playerid` (`fk_Playerid`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`),
  ADD KEY `performs` (`fk_Playerid`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bet`
--
ALTER TABLE `bet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `elo`
--
ALTER TABLE `elo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `game`
--
ALTER TABLE `game`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `game_mode`
--
ALTER TABLE `game_mode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `genre`
--
ALTER TABLE `genre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `matches`
--
ALTER TABLE `matches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `most_popular_game`
--
ALTER TABLE `most_popular_game`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `player`
--
ALTER TABLE `player`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tournament`
--
ALTER TABLE `tournament`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tournament_player`
--
ALTER TABLE `tournament_player`
  MODIFY `fk_Playerid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
