-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 25, 2020 at 08:29 AM
-- Server version: 8.0.18
-- PHP Version: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `parking_aplikacija`
--
CREATE DATABASE IF NOT EXISTS `parking_aplikacija` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE `parking_aplikacija`;

-- --------------------------------------------------------

--
-- Table structure for table `boravak`
--

DROP TABLE IF EXISTS `boravak`;
CREATE TABLE IF NOT EXISTS `boravak` (
  `idBoravka` int(11) NOT NULL AUTO_INCREMENT,
  `idKartice` int(11) NOT NULL,
  `datumUlaska` date NOT NULL,
  `vremeUlaska` time NOT NULL,
  `datumIzlaska` date NOT NULL,
  `vremeIzlaska` time NOT NULL,
  `idRacuna` int(11) NOT NULL,
  PRIMARY KEY (`idBoravka`),
  KEY `idKartice` (`idKartice`),
  KEY `idRacuna` (`idRacuna`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `isplata`
--

DROP TABLE IF EXISTS `isplata`;
CREATE TABLE IF NOT EXISTS `isplata` (
  `idIsplate` int(11) NOT NULL AUTO_INCREMENT,
  `idKartice` int(11) NOT NULL,
  `idRacuna` int(11) NOT NULL,
  PRIMARY KEY (`idIsplate`),
  KEY `idKartice` (`idKartice`),
  KEY `idRacuna` (`idRacuna`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `isplata`
--

INSERT INTO `isplata` (`idIsplate`, `idKartice`, `idRacuna`) VALUES
(44, 8, 71),
(45, 8, 79),
(46, 7, 81),
(47, 8, 83),
(48, 7, 85),
(49, 8, 89),
(50, 8, 91),
(51, 7, 98),
(52, 10, 100);

-- --------------------------------------------------------

--
-- Table structure for table `izdavanje`
--

DROP TABLE IF EXISTS `izdavanje`;
CREATE TABLE IF NOT EXISTS `izdavanje` (
  `idKartice` int(11) NOT NULL,
  `idRacuna` int(11) NOT NULL,
  PRIMARY KEY (`idKartice`),
  KEY `idRacuna` (`idRacuna`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kartica`
--

DROP TABLE IF EXISTS `kartica`;
CREATE TABLE IF NOT EXISTS `kartica` (
  `idKartice` int(11) NOT NULL AUTO_INCREMENT,
  `automobil` varchar(50) NOT NULL,
  `idKorisnika` int(11) NOT NULL,
  `datumVazenja` date NOT NULL,
  `iznos` decimal(10,2) NOT NULL,
  PRIMARY KEY (`idKartice`),
  KEY `idKorisnika` (`idKorisnika`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kartica`
--

INSERT INTO `kartica` (`idKartice`, `automobil`, `idKorisnika`, `datumVazenja`, `iznos`) VALUES
(7, 'LO-401-MN', 1, '2021-01-24', '0.00'),
(8, 'LO-400-RE', 1, '2021-01-24', '7000.00'),
(9, 'LO-980-PĐ', 2, '2020-07-03', '5000.00'),
(10, 'LO-512-ĆŽ', 2, '2020-05-05', '1000.00'),
(11, 'LO-678-QR', 2, '2020-04-18', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `kazna`
--

DROP TABLE IF EXISTS `kazna`;
CREATE TABLE IF NOT EXISTS `kazna` (
  `idKazne` int(11) NOT NULL AUTO_INCREMENT,
  `idBoravka` int(11) NOT NULL,
  `tipPrekrsaja` varchar(50) NOT NULL,
  `iznos` decimal(10,2) NOT NULL,
  PRIMARY KEY (`idKazne`),
  KEY `idBoravka` (`idBoravka`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produzenje`
--

DROP TABLE IF EXISTS `produzenje`;
CREATE TABLE IF NOT EXISTS `produzenje` (
  `idProduzenja` int(11) NOT NULL AUTO_INCREMENT,
  `idKartice` int(11) NOT NULL,
  `datumProduzetka` date NOT NULL,
  `idRacuna` int(11) NOT NULL,
  PRIMARY KEY (`idProduzenja`),
  KEY `idKartice` (`idKartice`),
  KEY `idRacuna` (`idRacuna`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `produzenje`
--

INSERT INTO `produzenje` (`idProduzenja`, `idKartice`, `datumProduzetka`, `idRacuna`) VALUES
(7, 7, '2021-01-15', 73),
(8, 8, '2021-01-23', 74),
(9, 8, '2021-01-24', 75),
(10, 7, '2021-01-16', 76),
(11, 7, '2021-01-17', 77),
(12, 7, '2021-01-18', 78),
(13, 7, '2021-01-19', 87),
(14, 7, '2021-01-20', 88),
(15, 9, '2020-07-03', 93),
(16, 7, '2021-01-21', 94),
(17, 7, '2021-01-22', 95),
(18, 7, '2021-01-23', 96),
(19, 7, '2021-01-24', 97);

-- --------------------------------------------------------

--
-- Table structure for table `racun`
--

DROP TABLE IF EXISTS `racun`;
CREATE TABLE IF NOT EXISTS `racun` (
  `idRacuna` int(11) NOT NULL AUTO_INCREMENT,
  `datum` date NOT NULL,
  `vreme` time NOT NULL,
  `iznos` decimal(10,2) NOT NULL,
  `opis` varchar(50) NOT NULL,
  PRIMARY KEY (`idRacuna`)
) ENGINE=InnoDB AUTO_INCREMENT=102 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `racun`
--

INSERT INTO `racun` (`idRacuna`, `datum`, `vreme`, `iznos`, `opis`) VALUES
(71, '2020-04-18', '10:50:04', '1000.00', 'isplata'),
(72, '2020-04-18', '10:50:04', '1000.00', 'uplata'),
(73, '2020-04-18', '12:50:24', '200.00', 'produzenje'),
(74, '2020-04-18', '12:51:16', '800.00', 'produzenje'),
(75, '2020-04-18', '12:51:48', '200.00', 'produzenje'),
(76, '2020-04-18', '12:55:53', '200.00', 'produzenje'),
(77, '2020-04-20', '15:20:45', '200.00', 'produzenje'),
(78, '2020-04-20', '16:05:12', '200.00', 'produzenje'),
(79, '2020-04-20', '21:28:42', '1000.00', 'isplata'),
(80, '2020-04-20', '21:28:42', '1000.00', 'uplata'),
(81, '2020-04-20', '21:30:42', '200.00', 'isplata'),
(82, '2020-04-20', '21:30:42', '200.00', 'uplata'),
(83, '2020-04-20', '21:31:14', '200.00', 'isplata'),
(84, '2020-04-20', '21:31:14', '200.00', 'uplata'),
(85, '2020-04-20', '21:44:53', '200.00', 'isplata'),
(86, '2020-04-20', '21:44:53', '200.00', 'uplata'),
(87, '2020-04-20', '23:45:06', '200.00', 'produzenje'),
(88, '2020-04-20', '23:45:08', '200.00', 'produzenje'),
(89, '2020-04-20', '21:45:27', '200.00', 'isplata'),
(90, '2020-04-20', '21:45:27', '200.00', 'uplata'),
(91, '2020-04-22', '11:38:05', '200.00', 'isplata'),
(92, '2020-04-22', '11:38:05', '200.00', 'uplata'),
(93, '2020-04-22', '16:12:29', '200.00', 'produzenje'),
(94, '2020-04-23', '19:57:27', '200.00', 'produzenje'),
(95, '2020-04-23', '20:49:17', '200.00', 'produzenje'),
(96, '2020-04-23', '20:50:21', '200.00', 'produzenje'),
(97, '2020-04-23', '20:50:25', '200.00', 'produzenje'),
(98, '2020-04-23', '18:50:47', '200.00', 'isplata'),
(99, '2020-04-23', '18:50:47', '200.00', 'uplata'),
(100, '2020-04-24', '20:01:03', '200.00', 'isplata'),
(101, '2020-04-24', '20:01:03', '200.00', 'uplata');

-- --------------------------------------------------------

--
-- Table structure for table `registrovani`
--

DROP TABLE IF EXISTS `registrovani`;
CREATE TABLE IF NOT EXISTS `registrovani` (
  `idKorisnika` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `lozinka` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ime` varchar(50) NOT NULL,
  `prezime` varchar(50) NOT NULL,
  `grad` varchar(50) NOT NULL,
  `adresa` varchar(50) NOT NULL,
  `telefon` varchar(50) NOT NULL,
  PRIMARY KEY (`idKorisnika`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `registrovani`
--

INSERT INTO `registrovani` (`idKorisnika`, `email`, `lozinka`, `ime`, `prezime`, `grad`, `adresa`, `telefon`) VALUES
(1, 'pera@etf.rs', 'pera123', 'Pera', 'Peric', 'Loznica', 'Pasiceva 13', '0648652312'),
(2, 'mika@etf.rs', 'mika123', 'Mika', 'Mikic', 'Loznica', 'Valjevski put 89', '0641355313'),
(3, 'zika@etf.rs', 'zika123', 'Zika', 'Zikic', 'Beograd', 'Bulevar Kralja Aleksandra 170', '0645490876'),
(5, 'toma@etf.rs', 'toma123', 'toma', 'tomic', 'Sabac', 'BB', '0645321');

-- --------------------------------------------------------

--
-- Table structure for table `uplata`
--

DROP TABLE IF EXISTS `uplata`;
CREATE TABLE IF NOT EXISTS `uplata` (
  `idUplate` int(11) NOT NULL AUTO_INCREMENT,
  `idKartice` int(11) NOT NULL,
  `idRacuna` int(11) NOT NULL,
  PRIMARY KEY (`idUplate`),
  KEY `idKartice` (`idKartice`),
  KEY `idRacuna` (`idRacuna`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `uplata`
--

INSERT INTO `uplata` (`idUplate`, `idKartice`, `idRacuna`) VALUES
(20, 7, 72),
(21, 7, 80),
(22, 8, 82),
(23, 7, 84),
(24, 8, 86),
(25, 7, 90),
(26, 7, 92),
(27, 8, 99),
(28, 9, 101);

-- --------------------------------------------------------

--
-- Table structure for table `zaposleni`
--

DROP TABLE IF EXISTS `zaposleni`;
CREATE TABLE IF NOT EXISTS `zaposleni` (
  `idZaposlenog` int(11) NOT NULL AUTO_INCREMENT,
  `korisnickoIme` varchar(50) NOT NULL,
  `lozinka` varchar(50) NOT NULL,
  `tip` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  PRIMARY KEY (`idZaposlenog`),
  UNIQUE KEY `korisnickoIme` (`korisnickoIme`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `zaposleni`
--

INSERT INTO `zaposleni` (`idZaposlenog`, `korisnickoIme`, `lozinka`, `tip`) VALUES
(1, 'pera', '123', 'o'),
(2, 'zika', '123', 'k');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `boravak`
--
ALTER TABLE `boravak`
  ADD CONSTRAINT `boravak_ibfk_1` FOREIGN KEY (`idKartice`) REFERENCES `kartica` (`idKartice`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `boravak_ibfk_2` FOREIGN KEY (`idRacuna`) REFERENCES `racun` (`idRacuna`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `isplata`
--
ALTER TABLE `isplata`
  ADD CONSTRAINT `isplata_ibfk_1` FOREIGN KEY (`idKartice`) REFERENCES `kartica` (`idKartice`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `isplata_ibfk_2` FOREIGN KEY (`idRacuna`) REFERENCES `racun` (`idRacuna`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `izdavanje`
--
ALTER TABLE `izdavanje`
  ADD CONSTRAINT `izdavanje_ibfk_1` FOREIGN KEY (`idKartice`) REFERENCES `kartica` (`idKartice`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `izdavanje_ibfk_2` FOREIGN KEY (`idRacuna`) REFERENCES `racun` (`idRacuna`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `kartica`
--
ALTER TABLE `kartica`
  ADD CONSTRAINT `kartica_ibfk_1` FOREIGN KEY (`idKorisnika`) REFERENCES `registrovani` (`idKorisnika`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `kazna`
--
ALTER TABLE `kazna`
  ADD CONSTRAINT `kazna_ibfk_1` FOREIGN KEY (`idBoravka`) REFERENCES `boravak` (`idBoravka`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `produzenje`
--
ALTER TABLE `produzenje`
  ADD CONSTRAINT `produzenje_ibfk_1` FOREIGN KEY (`idKartice`) REFERENCES `kartica` (`idKartice`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `produzenje_ibfk_2` FOREIGN KEY (`idRacuna`) REFERENCES `racun` (`idRacuna`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `uplata`
--
ALTER TABLE `uplata`
  ADD CONSTRAINT `uplata_ibfk_1` FOREIGN KEY (`idKartice`) REFERENCES `kartica` (`idKartice`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `uplata_ibfk_2` FOREIGN KEY (`idRacuna`) REFERENCES `racun` (`idRacuna`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
