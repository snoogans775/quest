-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Sep 08, 2020 at 04:50 PM
-- Server version: 5.7.26
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `quest`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `username` varchar(30) DEFAULT NULL,
  `hashed_password` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`username`, `hashed_password`) VALUES
('quest_admin', '$2y$10$OThmNGNlZDcyMjA0YzlmZOseFO2nwkTvA');

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `content` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`id`, `title`, `timestamp`, `content`) VALUES
(1, 'The Quest has Ended', '2017-02-08 17:43:34', 'We have played some games. The Quest is now in wintry wonderland mode, and we\'ll be having a little party in Reno, NV to celebrate and review the games we\'ve played and what we\'ve gained. Anybody with a registered account will be receiving a private email with the location and date. Thanks y\'all!\r\n	-Kevin');

-- --------------------------------------------------------

--
-- Table structure for table `challenges`
--

CREATE TABLE `challenges` (
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `description` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `completion_commits`
--

CREATE TABLE `completion_commits` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `game_id` int(100) NOT NULL,
  `comments` varchar(500) NOT NULL,
  `source_user_id` int(11) NOT NULL,
  `confirmed` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `completion_commits`
--

INSERT INTO `completion_commits` (`id`, `user_id`, `game_id`, `comments`, `source_user_id`, `confirmed`) VALUES
(1, 20, 0, 'I beat tha gaem', 40, 0),
(2, 64, 42, ' asdfasd', 20, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `currently_following`
--

CREATE TABLE `currently_following` (
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `currently_following`
--

INSERT INTO `currently_following` (`user_id`, `game_id`) VALUES
(64, 42),
(64, 1);

-- --------------------------------------------------------

--
-- Table structure for table `currently_playing`
--

CREATE TABLE `currently_playing` (
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `challenge` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `currently_playing`
--

INSERT INTO `currently_playing` (`user_id`, `game_id`, `challenge`) VALUES
(20, 48, ''),
(20, 52, ''),
(20, 55, ''),
(20, 61, ''),
(20, 74, ''),
(20, 78, ''),
(20, 84, ''),
(20, 86, ''),
(42, 49, ''),
(44, 1, ''),
(44, 42, '');

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE `games` (
  `game_id` int(11) NOT NULL,
  `title` varchar(40) NOT NULL,
  `platform` varchar(20) NOT NULL,
  `developer` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`game_id`, `title`, `platform`, `developer`) VALUES
(1, 'Chrono Trigger', 'SNES', 'Squaresoft'),
(2, 'Light Crusader', 'Sega Genesis', 'Treasure'),
(3, 'Ikaruga', 'Sega Dreamcast', 'Treasure'),
(41, 'Splatoon', 'Nintendo WiiU', ''),
(42, 'Shadow of The Colossus', 'Sony Playstation 2', ''),
(43, 'Legend of Zelda: Wind Waker', 'Nintendo Gamecube', ''),
(44, 'Phantasy Star II', 'Sega Genesis', ''),
(45, 'Shin Megami Tensei: Nocturne', 'Sony Playstation 2', ''),
(46, 'Phantasy Star IV', 'Sega Genesis', ''),
(47, 'Shandalar', 'PC', ''),
(48, 'Odell Down Under', 'MAC Classic (Mac OS)', ''),
(49, 'The Walking Dead', 'PC', ''),
(50, 'Pikmin 2', 'Nintendo Wii', ''),
(51, 'Botanicula', 'PC', ''),
(52, 'Machinarium', 'PC', ''),
(53, 'Plants vs. Zombies', 'Tablet(Android)', ''),
(54, 'Katamari Damacy', 'Sony Playstation 2', ''),
(55, 'Riviera the Promised Land', 'Nintendo Gameboy Adv', ''),
(56, 'Railroad Tycoon 2', 'PC', ''),
(57, 'Freeciv', 'PC', ''),
(59, 'Battle for Wesnoth', 'PC', ''),
(60, 'Where we Remain', 'PC', ''),
(61, 'Kerbal Space Program', 'PC', ''),
(62, 'Convoy', 'PC', ''),
(63, 'Nethack', 'PC', ''),
(64, 'UFO Alien Invasion', 'PC', ''),
(74, 'Metal Gear Rising: Revengeance ', 'XBOX 360', ''),
(75, 'Final Fantasy X', 'Sony Playstation 2', ''),
(76, 'Metal Gear Solid 2: Sons of Liberty ', 'Sony Playstation 2', ''),
(77, 'Metal Gear Solid 3: Snake Eater', 'Sony Playstation 2', ''),
(78, 'Broken Age', 'PC', ''),
(79, 'Final Fantasy II (IV)', 'Super Nintendo', ''),
(80, 'Earthbound', 'Super Nintendo', ''),
(81, 'Mother 3', 'Nintendo Gameboy Adv', ''),
(82, 'Animal Crossing', 'Nintendo Gamecube', ''),
(83, 'The Legend of Zelda Twilight Princess', 'Nintendo Gamecube', ''),
(84, 'Undertale', 'PC', ''),
(85, 'Pokemon Soul Silver/Heart Gold', 'Nintendo DS', ''),
(86, 'Ori and the Blind Forest', 'PC', ''),
(87, 'Ace Combat 5', 'Sony Playstation 2', ''),
(88, 'Ratchet and Clank', 'Sony Playstation 2', ''),
(89, 'Spyro the Dragon', 'Sony Playstation', ''),
(90, 'Armored Core: For Answer', 'XBOX 360', ''),
(91, 'MLB \'09 the Show', 'Sony Playstation 2', ''),
(92, 'ikablooa', 'Nintendo 64', NULL),
(93, 'sdf', 'Nintendo 64', NULL),
(94, 'sdf', 'Nintendo 64', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `games_tags`
--

CREATE TABLE `games_tags` (
  `game_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `games_tags`
--

INSERT INTO `games_tags` (`game_id`, `tag_id`) VALUES
(42, 1),
(42, 4);

-- --------------------------------------------------------

--
-- Table structure for table `platforms`
--

CREATE TABLE `platforms` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `platforms`
--

INSERT INTO `platforms` (`id`, `name`) VALUES
(1, 'Nintendo Wii'),
(3, 'Nintendo Gamecube'),
(4, 'Nintendo 64'),
(5, 'Super Nintendo'),
(6, 'NES'),
(7, 'Famicom'),
(8, 'Super Famicom'),
(9, 'Sega Master System'),
(10, 'Sega Genesis'),
(11, 'Sega 32X'),
(12, 'Sega CD'),
(13, 'Sega Saturn'),
(14, 'Sega Dreamcast'),
(15, 'Sony Playstation'),
(16, 'Sony Playstation 2'),
(17, 'Sony Playstation 3'),
(18, 'Sony Playstation 4'),
(19, 'XBOX'),
(20, 'XBOX 360'),
(21, 'XBOX One'),
(22, 'Sony PSP'),
(23, 'Sony PS Vita'),
(24, 'Nintendo Gameboy'),
(25, 'Nintendo Gameboy Advance'),
(26, 'Nintendo DS'),
(27, 'Nintendo 3DS'),
(28, 'Neo Geo MVS'),
(29, 'Neo Geo Pocket Color'),
(30, 'MAC Classic (Mac OS)'),
(31, 'DOS'),
(32, 'PC'),
(33, 'Commodore 64'),
(34, 'Atari 2600'),
(35, 'Atari Jaguar'),
(36, 'Atari Lynx'),
(37, 'Turbo-Grafx 16'),
(38, 'PC Engine'),
(39, 'Nintendo WiiU'),
(40, 'Tablet(Android)');

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` mediumint(9) NOT NULL,
  `menu_name` varchar(20) NOT NULL,
  `position` mediumint(9) NOT NULL,
  `visible` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `menu_name`, `position`, `visible`) VALUES
(1, 'home', 1, 1),
(3, 'faq', 3, 1),
(4, 'contests', 4, 1),
(5, 'forum', 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tags`
--

INSERT INTO `tags` (`id`, `name`) VALUES
(1, 'beautiful'),
(2, 'puzzle'),
(3, 'immersive'),
(4, 'colorful'),
(5, 'challenging');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` mediumint(9) NOT NULL,
  `username` varchar(30) NOT NULL,
  `hashed_password` varchar(80) NOT NULL,
  `points` int(11) NOT NULL,
  `date_joined` date NOT NULL,
  `email` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `hashed_password`, `points`, `date_joined`, `email`) VALUES
(20, 'kevin', '$2y$10$ZDEyN2I0MGUwNDA5MTNlZOIaj.GV4msGD5eoTcuEb.kbweC.CUzcO', 400, '2016-04-13', 'kevin@rvgsymphony.com'),
(39, 'BubsyFan1', '$2y$10$NGUyMzA5NDY3NjZmMWRiZ.42HAL9yRymhuLvtvbDJz9hwWZYpPQdi', 400, '2016-04-15', ''),
(40, 'Dwf775', '$2y$10$NDgyOGQ0ZjQ5MzUwYTg3Yefr3JHAcRUUxE9NDkNFIm4XX3LotCWAS', 400, '2016-04-17', 'dwf775@gmail.com'),
(42, 'amusselm', '$2y$10$MmVkNzUyYjdkYjhkMzBkMegOIIV9B.Zg63w/7grxD3rrst9I2sqjK', 400, '2016-04-19', ''),
(44, 'S073 Joseph', '$2y$10$N2YxM2JhMjRmYjZkYjkyMuczllZbPf3Bqhgwl8YT22yP0EwIZSMJK', 400, '2016-04-19', 'Dublecoco73@gmail.com'),
(45, 'Jazoko', '$2y$10$ODg0MjcyMDJiM2Q0YWIzZOIa4NClO/.1cZJOMmxVFdIz/y7dAcC5S', 400, '2016-04-19', ''),
(46, 'ElizSchuler', '$2y$10$N2FjZWRjOWEwNGZjZmYyYeIzOh/CB7N6JQNlV0GdsJ8qpsuEql4UG', 400, '2016-04-20', 'fanfootedgecko@Yahoo.com'),
(47, 'Strayedphantom', '$2y$10$NmMyYTIyM2Y2YWU3Nzk5M.3Ho0iJj2yveXTYlhoxiBbz4cl2q.hKq', 400, '2016-04-20', 'cfsemail1000@gmail.com'),
(59, 'newKevin', '$2y$10$MDdmZTRkMDEwYjQ1Nzc1MuMPSE2FRmYBLnViiIGg/BKrFi.i1yATG', 400, '2020-08-21', 'snoogans775@gmail.com'),
(64, 'beefyG', '$2y$10$NmMyNzkyMTkxNGZiNTJkO.UL0.xsExqbe.fh.t/kka1z18NQ8N7zW', 400, '2020-09-08', 'kfrednv@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `users_games`
--

CREATE TABLE `users_games` (
  `user_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `challenge` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users_games`
--

INSERT INTO `users_games` (`user_id`, `game_id`, `challenge`) VALUES
(20, 1, 'Beat New Game+'),
(20, 41, 'Reach Level 20'),
(20, 42, ''),
(28, 43, ''),
(39, 44, ''),
(39, 45, ''),
(39, 44, ''),
(39, 46, ''),
(39, 47, ''),
(39, 48, 'Finish a Tournament'),
(40, 49, ''),
(40, 50, ''),
(40, 49, ''),
(40, 51, ''),
(40, 52, ''),
(40, 53, ''),
(20, 54, ''),
(39, 55, ''),
(42, 56, 'Complete the main campaign '),
(42, 57, 'Win a game against the AI '),
(42, 56, 'Complete the main campaign'),
(42, 59, 'Complete Delfador\'s Memiors'),
(42, 60, 'Get at least 2 endings'),
(42, 61, 'Plant a flag on the Mun'),
(42, 62, ''),
(42, 63, ''),
(42, 64, ''),
(44, 74, ''),
(44, 75, ''),
(44, 76, ''),
(44, 77, ''),
(45, 78, ''),
(46, 79, ''),
(46, 80, ''),
(46, 81, ''),
(46, 82, 'Pay off your house completely'),
(46, 83, 'Acceptable on Wii and Wii U also'),
(46, 84, 'Beat True Pacifist Ending'),
(46, 85, 'Collect all 16 badges and beat the leagu'),
(46, 86, ''),
(47, 87, ''),
(47, 88, ''),
(47, 89, ''),
(47, 90, 'Aquire MOONLIGHT'),
(39, 91, 'Talk to me. '),
(64, 1, ''),
(64, 1, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `completion_commits`
--
ALTER TABLE `completion_commits`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `currently_playing`
--
ALTER TABLE `currently_playing`
  ADD PRIMARY KEY (`user_id`,`game_id`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
  ADD PRIMARY KEY (`game_id`);

--
-- Indexes for table `platforms`
--
ALTER TABLE `platforms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `completion_commits`
--
ALTER TABLE `completion_commits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `game_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `platforms`
--
ALTER TABLE `platforms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` mediumint(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;
