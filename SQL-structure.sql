-- phpMyAdmin SQL Dump
-- version 3.5.8.1deb1
-- http://www.phpmyadmin.net
--
-- Värd: localhost
-- Skapad: 18 maj 2013 kl 09:33
-- Serverversion: 5.5.31-0ubuntu0.13.04.1
-- PHP-version: 5.4.9-4ubuntu2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Databas: `filmDB`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `actors`
--

CREATE TABLE IF NOT EXISTS `actors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `actor` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

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
-- Tabellstruktur `directors`
--

CREATE TABLE IF NOT EXISTS `directors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `director` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `genre` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imdbid` varchar(20) NOT NULL,
  `title` varchar(60) NOT NULL,
  `plot` text NOT NULL,
  `year` int(10) NOT NULL,
  `poster` varchar(100) NOT NULL,
  `type` varchar(11) NOT NULL,
  `sub` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `movietype`
--

CREATE TABLE IF NOT EXISTS `movietype` (
  `short` varchar(5) NOT NULL,
  `type` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `movietype` (`short`, `type`) VALUES
('M', 'Film'),
('TVS', 'TV Serie'),
('TV', 'TV Film'),
('V', 'Video'),
('VG', 'Dator spel');

-- --------------------------------------------------------

--
-- Tabellstruktur `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` mediumtext NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `queue`
--

CREATE TABLE IF NOT EXISTS `queue` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `imdb` varchar(20) NOT NULL,
  `title` varchar(60) NOT NULL,
  `year` int(10) NOT NULL,
  `added` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `towatch`
--

CREATE TABLE IF NOT EXISTS `towatch` (
  `movieid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tabellstruktur `usercomment`
--

CREATE TABLE IF NOT EXISTS `usercomment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `movieid` int(11) NOT NULL,
  `comment` text NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Tabellstruktur `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0 ;

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
  `value` int(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
