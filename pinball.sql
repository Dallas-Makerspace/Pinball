-- phpMyAdmin SQL Dump
-- version 4.0.6deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 05, 2014 at 12:39 PM
-- Server version: 5.5.35-0ubuntu0.13.10.2
-- PHP Version: 5.5.9-1+sury.org~saucy+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pinball`
--
CREATE DATABASE IF NOT EXISTS `pinball` DEFAULT CHARACTER SET utf16 COLLATE utf16_general_ci;
USE `pinball`;

-- --------------------------------------------------------

--
-- Table structure for table `machines`
--

CREATE TABLE IF NOT EXISTS `machines` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `isActive` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`migration`, `batch`) VALUES
('2014_03_02_212924_create_user_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `mpictures`
--

CREATE TABLE IF NOT EXISTS `mpictures` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `machine_id` int(11) NOT NULL,
  `pic_url` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=6 ;

--
-- Dumping data for table `mpictures`
--

INSERT INTO `mpictures` (`id`, `machine_id`, `pic_url`, `created_at`, `updated_at`) VALUES
(1, 1, 'ec308451c1d095c528cfa3c009ea7235.jpg', '2014-03-15 13:29:23', '2014-03-15 13:29:23'),
(2, 1, 'ab35e84a215f0f711ed629c2abb9efa0.jpg', '2014-03-15 13:29:23', '2014-03-15 13:29:23'),
(3, 2, 'f9c340648e746ce4f8ea6dde4e3538f9.jpg', '2014-03-19 05:35:55', '2014-03-19 05:35:55'),
(4, 2, '5229803558d4b78950dbe86955292f03.jpg', '2014-03-19 05:35:55', '2014-03-19 05:35:55'),
(5, 2, 'c62d9e9c826d00c9a58597558f117ad8.jpg', '2014-03-19 05:35:55', '2014-03-19 05:35:55');

-- --------------------------------------------------------

--
-- Table structure for table `scores`
--

CREATE TABLE IF NOT EXISTS `scores` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `picture_url` text COLLATE utf8_unicode_ci NOT NULL,
  `score` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `machine_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=50 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  `temp_password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `code`, `isAdmin`, `temp_password`, `password`, `enabled`, `created_at`, `updated_at`) VALUES
(1, 'nglaser', 'glaserpower@gmail.com', '', 1, '', '$2y$10$QsxnAgPH1Y5noByl/wvnme3jKn/MvmRhC/FSVNouXVCcUsezbjtLC', 1, '2014-03-15 13:03:22', '2014-04-05 22:34:11');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
