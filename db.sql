-- phpMyAdmin SQL Dump
-- version 4.2.12deb2
-- http://www.phpmyadmin.net
--
-- Värd: localhost
-- Tid vid skapande: 23 jul 2015 kl 15:17
-- Serverversion: 5.6.24-0ubuntu2
-- PHP-version: 5.6.4-4ubuntu6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Databas: `db`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `actors`
--

CREATE TABLE IF NOT EXISTS `actors` (
`id` int(11) NOT NULL,
  `actor` varchar(50) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `actorsinmovies`
--

CREATE TABLE IF NOT EXISTS `actorsinmovies` (
  `movie_id` int(11) NOT NULL,
  `actor_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Ersättningsstruktur för vy `allMovies`
--
CREATE TABLE IF NOT EXISTS `allMovies` (
`id` int(11)
,`title` varchar(100)
,`year` int(10)
,`genreid` text
,`genre` text
);
-- --------------------------------------------------------

--
-- Tabellstruktur `directors`
--

CREATE TABLE IF NOT EXISTS `directors` (
`id` int(11) NOT NULL,
  `director` varchar(50) CHARACTER SET utf8 COLLATE utf8_swedish_ci NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `directorsinmovies`
--

CREATE TABLE IF NOT EXISTS `directorsinmovies` (
  `director_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `genres`
--

CREATE TABLE IF NOT EXISTS `genres` (
`id` int(11) NOT NULL,
  `genre` varchar(50) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `genresinmovies`
--

CREATE TABLE IF NOT EXISTS `genresinmovies` (
  `movie_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `genresinqueue`
--

CREATE TABLE IF NOT EXISTS `genresinqueue` (
  `movie_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `movies`
--

CREATE TABLE IF NOT EXISTS `movies` (
`id` int(11) NOT NULL,
  `imdbid` varchar(20) NOT NULL,
  `title` varchar(100) NOT NULL,
  `plot` text NOT NULL,
  `year` int(10) NOT NULL,
  `poster` varchar(100) NOT NULL,
  `type` varchar(11) NOT NULL,
  `sub` varchar(30) NOT NULL,
  `runtime` int(11) NOT NULL,
  `youtube` char(100) NOT NULL,
  `date` datetime NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `moviesinseries`
--

CREATE TABLE IF NOT EXISTS `moviesinseries` (
  `movieID` int(11) NOT NULL,
  `seriesID` int(11) NOT NULL,
  `number` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `movietype`
--

CREATE TABLE IF NOT EXISTS `movietype` (
  `short` varchar(5) NOT NULL,
  `type` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `news`
--

CREATE TABLE IF NOT EXISTS `news` (
`id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `description` mediumtext NOT NULL,
  `date` date NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `queue`
--

CREATE TABLE IF NOT EXISTS `queue` (
`id` int(11) NOT NULL,
  `imdb` varchar(20) NOT NULL,
  `title` varchar(60) NOT NULL,
  `year` int(10) NOT NULL,
  `added` date NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `series`
--

CREATE TABLE IF NOT EXISTS `series` (
`id` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `infopage` varchar(200) NOT NULL,
  `adDate` datetime NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `towatch`
--

CREATE TABLE IF NOT EXISTS `towatch` (
  `movieid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `usercomment`
--

CREATE TABLE IF NOT EXISTS `usercomment` (
`id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `movieid` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date` date NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `users`
--

CREATE TABLE IF NOT EXISTS `users` (
`id` int(11) NOT NULL,
  `name` varchar(40) NOT NULL,
  `password` char(130) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `userviewed`
--

CREATE TABLE IF NOT EXISTS `userviewed` (
  `userid` int(11) NOT NULL,
  `movieid` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `uservote`
--

CREATE TABLE IF NOT EXISTS `uservote` (
  `user_id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `value` int(1) NOT NULL,
  `date` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur för vy `allMovies`
--
DROP TABLE IF EXISTS `allMovies`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `allMovies` AS select `movies`.`id` AS `id`,`movies`.`title` AS `title`,`movies`.`year` AS `year`,group_concat(`genres`.`id` separator ',') AS `genreid`,group_concat(concat(`genres`.`id`,':',`genres`.`genre`) order by `genres`.`genre` ASC separator '|') AS `genre` from ((`movies` join `genresinmovies` on((`movies`.`id` = `genresinmovies`.`movie_id`))) join `genres` on((`genresinmovies`.`genre_id` = `genres`.`id`))) group by `movies`.`id` order by `movies`.`title`,`genres`.`genre`;

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `actors`
--
ALTER TABLE `actors`
 ADD PRIMARY KEY (`id`);

--
-- Index för tabell `directors`
--
ALTER TABLE `directors`
 ADD PRIMARY KEY (`id`);

--
-- Index för tabell `genres`
--
ALTER TABLE `genres`
 ADD PRIMARY KEY (`id`);

--
-- Index för tabell `movies`
--
ALTER TABLE `movies`
 ADD PRIMARY KEY (`id`);

--
-- Index för tabell `news`
--
ALTER TABLE `news`
 ADD PRIMARY KEY (`id`);

--
-- Index för tabell `queue`
--
ALTER TABLE `queue`
 ADD PRIMARY KEY (`id`);

--
-- Index för tabell `series`
--
ALTER TABLE `series`
 ADD PRIMARY KEY (`id`);

--
-- Index för tabell `usercomment`
--
ALTER TABLE `usercomment`
 ADD PRIMARY KEY (`id`);

--
-- Index för tabell `users`
--
ALTER TABLE `users`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `actors`
--
ALTER TABLE `actors`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;
--
-- AUTO_INCREMENT för tabell `directors`
--
ALTER TABLE `directors`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;
--
-- AUTO_INCREMENT för tabell `genres`
--
ALTER TABLE `genres`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;
--
-- AUTO_INCREMENT för tabell `movies`
--
ALTER TABLE `movies`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;
--
-- AUTO_INCREMENT för tabell `news`
--
ALTER TABLE `news`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;
--
-- AUTO_INCREMENT för tabell `queue`
--
ALTER TABLE `queue`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;
--
-- AUTO_INCREMENT för tabell `series`
--
ALTER TABLE `series`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;
--
-- AUTO_INCREMENT för tabell `usercomment`
--
ALTER TABLE `usercomment`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;
--
-- AUTO_INCREMENT för tabell `users`
--
ALTER TABLE `users`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=0;
