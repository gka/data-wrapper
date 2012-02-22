-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Ven 20 Janvier 2012 à 14:21
-- Version du serveur: 5.1.36
-- Version de PHP: 5.3.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `datastory`
--

-- --------------------------------------------------------

--
-- Structure de la table `charts`
--

CREATE TABLE IF NOT EXISTS `charts` (
  `chart_id` int(11) NOT NULL AUTO_INCREMENT,
  `additional_text` text NOT NULL,
  `id_text` varchar(6) NOT NULL,
  `user_id` int(11) NOT NULL,
  `chart_csv_data` text NOT NULL,
  `chart_js_code` text NOT NULL,
  `date_create` datetime NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `date_deleted` datetime NOT NULL,
  `chart_library` varchar(20) NOT NULL,
  `chart_theme` varchar(30) NOT NULL DEFAULT 'default',
  `chart_type` varchar(20) NOT NULL,
  `chart_title` varchar(255) NOT NULL,
  `horizontal_headers` tinyint(1) NOT NULL DEFAULT '0',
  `vertical_headers` tinyint(1) NOT NULL DEFAULT '0',
  `source` varchar(255) NOT NULL,
  `source_url` varchar(255) NOT NULL,
  `chart_lang` varchar(10) NOT NULL DEFAULT 'en_US',
  PRIMARY KEY (`chart_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `pwd` varchar(255) DEFAULT NULL,
  `date_created` datetime DEFAULT NULL,
  `date_modified` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `date_deleted` datetime DEFAULT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT '0',
  `token` varchar(50) NOT NULL,
  `quickstart_show` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
