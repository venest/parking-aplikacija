-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Jun 06, 2020 at 08:08 AM
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
CREATE DATABASE IF NOT EXISTS `parking_aplikacija` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
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
  `datumIzlaska` date DEFAULT NULL,
  `vremeIzlaska` time DEFAULT NULL,
  `idRacuna` int(11) DEFAULT NULL,
  PRIMARY KEY (`idBoravka`),
  KEY `idKartice` (`idKartice`),
  KEY `idRacuna` (`idRacuna`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `boravak`
--

INSERT INTO `boravak` (`idBoravka`, `idKartice`, `datumUlaska`, `vremeUlaska`, `datumIzlaska`, `vremeIzlaska`, `idRacuna`) VALUES
(16, 27, '2020-06-02', '13:00:00', NULL, NULL, NULL),
(17, 7, '2020-06-01', '05:00:00', NULL, NULL, NULL),
(18, 8, '2020-06-04', '07:00:00', NULL, NULL, NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `isplata`
--

INSERT INTO `isplata` (`idIsplate`, `idKartice`, `idRacuna`) VALUES
(57, 8, 116),
(58, 7, 126),
(70, 14, 182),
(71, 10, 185),
(72, 10, 186),
(73, 10, 187);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `izdavanje`
--

INSERT INTO `izdavanje` (`idKartice`, `idRacuna`) VALUES
(14, 131);

-- --------------------------------------------------------

--
-- Table structure for table `kartica`
--

DROP TABLE IF EXISTS `kartica`;
CREATE TABLE IF NOT EXISTS `kartica` (
  `idKartice` int(11) NOT NULL AUTO_INCREMENT,
  `automobil` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `idKorisnika` int(11) DEFAULT NULL,
  `vaziDo` date DEFAULT NULL,
  `stanje` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`idKartice`),
  KEY `idKorisnika` (`idKorisnika`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kartica`
--

INSERT INTO `kartica` (`idKartice`, `automobil`, `idKorisnika`, `vaziDo`, `stanje`) VALUES
(7, 'tablice1', 1, '2020-07-08', '22400.00'),
(8, 'tablice2', 1, '2020-02-01', '800.00'),
(9, 'tablice3', 2, '2020-04-01', '4000.00'),
(10, 'tablice4', 2, '2020-05-05', '1000.00'),
(11, 'tablice5', 2, '2020-06-03', '0.00'),
(14, 'tablice6', 5, '2020-05-14', '3.00'),
(27, 'gost1', NULL, NULL, NULL),
(37, 'gost2', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kazna`
--

DROP TABLE IF EXISTS `kazna`;
CREATE TABLE IF NOT EXISTS `kazna` (
  `idKazne` int(11) NOT NULL AUTO_INCREMENT,
  `idBoravka` int(11) NOT NULL,
  `tipPrekrsaja` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `iznos` decimal(10,2) NOT NULL,
  PRIMARY KEY (`idKazne`),
  KEY `idBoravka` (`idBoravka`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `kazna`
--

INSERT INTO `kazna` (`idKazne`, `idBoravka`, `tipPrekrsaja`, `iznos`) VALUES
(18, 18, 'PARKIRANJE SA KARTICOM CIJE JE VAZENJE ISTEKLO.', '1500.00'),
(19, 18, 'PARKIRANJE SA KARTICOM CIJE JE VAZENJE ISTEKLO.', '1500.00'),
(20, 18, 'PARKIRANJE SA KARTICOM CIJE JE VAZENJE ISTEKLO.', '1500.00'),
(21, 18, 'PARKIRANJE SA KARTICOM CIJE JE VAZENJE ISTEKLO.', '1500.00'),
(22, 16, 'PARKIRANJE NA MESTU ZA INVALIDE.', '1200.00'),
(23, 17, 'PARKIRANJE NA MESTU ZA INVALIDE.', '1200.00'),
(24, 16, 'PARKIRANJE NA MESTU ZA INVALIDE.', '1200.00'),
(25, 18, 'PARKIRANJE SA KARTICOM CIJE JE VAZENJE ISTEKLO.', '1500.00'),
(26, 16, 'PARKIRANJE NA MESTU ZA INVALIDE.', '1200.00'),
(27, 17, 'PARKIRANJE NA MESTU ZA INVALIDE.', '1200.00'),
(28, 17, 'PARKIRANJE NA MESTU ZA INVALIDE.', '1200.00'),
(29, 16, 'PARKIRANJE NA MESTU ZA TRUDNICE.', '1500.00'),
(30, 16, 'PARKIRANJE NA MESTU ZA TRUDNICE.', '1500.00'),
(31, 18, 'PARKIRANJE SA KARTICOM CIJE JE VAZENJE ISTEKLO.', '1500.00');

-- --------------------------------------------------------

--
-- Table structure for table `obnova`
--

DROP TABLE IF EXISTS `obnova`;
CREATE TABLE IF NOT EXISTS `obnova` (
  `idObnove` int(11) NOT NULL AUTO_INCREMENT,
  `idKartice` int(11) NOT NULL,
  `idRacuna` int(11) NOT NULL,
  PRIMARY KEY (`idObnove`),
  KEY `idKartice` (`idKartice`),
  KEY `idRacuna` (`idRacuna`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `obnova`
--

INSERT INTO `obnova` (`idObnove`, `idKartice`, `idRacuna`) VALUES
(27, 7, 117),
(28, 7, 118),
(29, 7, 119),
(30, 7, 120),
(31, 7, 121),
(32, 7, 122),
(33, 7, 123),
(34, 7, 124),
(35, 7, 125),
(36, 7, 127),
(37, 7, 128);

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
  `opis` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`idRacuna`)
) ENGINE=InnoDB AUTO_INCREMENT=188 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `racun`
--

INSERT INTO `racun` (`idRacuna`, `datum`, `vreme`, `iznos`, `opis`) VALUES
(116, '2020-05-07', '22:46:37', '700.00', 'transfer'),
(117, '2020-05-08', '00:09:00', '200.00', 'obnova dan'),
(118, '2020-05-08', '00:11:12', '200.00', 'obnova dan'),
(119, '2020-05-08', '00:14:59', '200.00', 'obnova dan'),
(120, '2020-05-08', '09:42:10', '200.00', 'obnova dan'),
(121, '2020-05-08', '09:43:10', '800.00', 'obnova sedmica'),
(122, '2020-05-08', '09:43:34', '800.00', 'obnova sedmica'),
(123, '2020-05-08', '09:43:47', '800.00', 'obnova sedmica'),
(124, '2020-05-08', '09:43:56', '800.00', 'obnova sedmica'),
(125, '2020-05-08', '09:44:16', '2000.00', 'obnova mesec'),
(126, '2020-05-08', '09:45:10', '800.00', 'transfer'),
(127, '2020-05-13', '20:47:29', '200.00', 'obnova dan'),
(128, '2020-05-13', '23:09:26', '200.00', 'obnova dan'),
(129, '2020-05-13', '23:22:31', '1200.00', 'izdavanje i pocetna dopuna dan'),
(130, '2020-05-13', '23:23:52', '1200.00', 'izdavanje i pocetna dopuna dan'),
(131, '2020-05-13', '23:25:14', '1200.00', 'izdavanje i pocetna dopuna dan'),
(132, '2020-05-14', '21:26:46', '1200.00', 'izdavanje i pocetna dopuna dan'),
(133, '2020-05-14', '21:32:39', '1200.00', 'izdavanje i pocetna dopuna dan'),
(134, '2020-05-14', '21:32:39', '1300.00', 'uplata'),
(135, '2020-05-14', '23:16:34', '0.00', 'isplata zbog gubitka'),
(136, '2020-05-14', '23:18:44', '0.00', 'isplata zbog gubitka'),
(137, '2020-05-14', '23:19:32', '0.00', 'isplata zbog gubitka'),
(138, '2020-05-14', '23:20:05', '0.00', 'isplata zbog gubitka'),
(139, '2020-05-14', '23:21:15', '0.00', 'isplata zbog gubitka'),
(140, '2020-05-14', '23:25:13', '0.00', 'isplata zbog gubitka'),
(141, '2020-05-15', '00:16:40', '1200.00', 'izdavanje i pocetna dopuna dan'),
(142, '2020-05-15', '00:16:40', '1300.00', 'uplata'),
(143, '2020-05-15', '00:16:57', '100.00', 'isplata zbog gubitka'),
(144, '2020-05-15', '00:18:22', '1200.00', 'izdavanje i pocetna dopuna dan'),
(145, '2020-05-15', '00:18:23', '1300.00', 'uplata'),
(146, '2020-05-15', '00:18:43', '100.00', 'isplata zbog gubitka'),
(147, '2020-05-15', '00:18:56', '1200.00', 'izdavanje i pocetna dopuna dan'),
(148, '2020-05-15', '00:18:56', '1300.00', 'uplata'),
(149, '2020-05-15', '00:19:33', '100.00', 'isplata zbog gubitka'),
(150, '2020-05-15', '00:24:25', '1200.00', 'izdavanje i pocetna dopuna dan'),
(151, '2020-05-15', '00:24:25', '1330.00', 'uplata'),
(152, '2020-05-15', '00:28:59', '1200.00', 'izdavanje i pocetna dopuna dan'),
(153, '2020-05-15', '00:28:59', '1300.00', 'uplata'),
(154, '2020-05-15', '00:29:27', '130.00', 'isplata zbog gubitka'),
(155, '2020-05-15', '00:29:49', '100.00', 'isplata zbog gubitka'),
(156, '2020-05-15', '00:32:25', '1200.00', 'izdavanje i pocetna dopuna dan'),
(157, '2020-05-15', '00:32:25', '1400.00', 'uplata'),
(158, '2020-05-15', '00:32:33', '200.00', 'isplata zbog gubitka'),
(159, '2020-05-15', '00:34:06', '1200.00', 'izdavanje i pocetna dopuna dan'),
(160, '2020-05-15', '00:34:06', '1400.00', 'uplata'),
(161, '2020-05-15', '00:34:15', '200.00', 'isplata zbog gubitka'),
(162, '2020-05-15', '00:35:02', '1200.00', 'izdavanje i pocetna dopuna dan'),
(163, '2020-05-15', '00:35:02', '5000.00', 'uplata'),
(164, '2020-05-15', '00:35:11', '3800.00', 'isplata zbog gubitka'),
(165, '2020-05-15', '00:37:37', '1200.00', 'izdavanje i pocetna dopuna dan'),
(166, '2020-05-15', '00:37:37', '5000.00', 'uplata'),
(167, '2020-05-15', '00:37:45', '3800.00', 'isplata zbog gubitka'),
(168, '2020-05-15', '00:39:50', '1200.00', 'izdavanje i pocetna dopuna dan'),
(169, '2020-05-15', '00:39:50', '3000.00', 'uplata'),
(170, '2020-05-15', '00:40:01', '1800.00', 'isplata zbog gubitka'),
(171, '2020-05-17', '13:57:11', '60.00', 'placanje izlaska'),
(172, '2020-06-02', '09:17:05', '60.00', 'placanje izlaska'),
(173, '2020-06-02', '09:52:34', '60.00', 'placanje izlaska'),
(174, '2020-06-02', '10:43:55', '1500.00', 'placanje izlaska'),
(175, '2020-06-02', '10:45:25', '2520.00', 'placanje izlaska'),
(176, '2020-06-02', '11:05:55', '60.00', 'placanje izlaska'),
(177, '2020-06-02', '12:26:10', '1200.00', 'izdavanje i pocetna dopuna dan'),
(178, '2020-06-02', '12:26:10', '131434.00', 'uplata'),
(179, '2020-06-02', '12:27:00', '200.00', 'obnova dan'),
(180, '2020-06-02', '15:44:06', '60.00', 'placanje izlaska'),
(181, '2020-06-02', '16:10:21', '13.00', 'uplata'),
(182, '2020-06-02', '16:11:46', '10.00', 'isplata'),
(183, '2020-06-05', '20:14:54', '400.00', 'uplata'),
(184, '2020-06-05', '20:15:20', '400.00', 'uplata'),
(185, '2020-06-05', '20:25:10', '500.00', 'isplata'),
(186, '2020-06-05', '20:27:11', '1500.00', 'isplata'),
(187, '2020-06-05', '20:28:45', '500.00', 'isplata');

-- --------------------------------------------------------

--
-- Table structure for table `registrovani`
--

DROP TABLE IF EXISTS `registrovani`;
CREATE TABLE IF NOT EXISTS `registrovani` (
  `idKorisnika` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `lozinka` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ime` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `prezime` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `grad` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `adresa` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `telefon` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`idKorisnika`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `registrovani`
--

INSERT INTO `registrovani` (`idKorisnika`, `email`, `lozinka`, `ime`, `prezime`, `grad`, `adresa`, `telefon`) VALUES
(1, 'pera@etf.rs', 'pera1234', 'Pera', 'Peric', 'Loznica', 'Pasiceva 14', '0648652312'),
(2, 'mika@etf.rs', 'mika123', 'Mika', 'Mikic', 'Loznica', 'Valjevski put 89', '0641355313'),
(3, 'zika@etf.rs', 'zika123', 'Zika', 'Zikic', 'Beograd', 'Bulevar Kralja Aleksandra 170', '0645490876'),
(5, 'toma@etf.rs', 'toma123', 'toma', 'tomic', 'Sabac', 'BB', '0645321'),
(10, 'mikaa@etf.rs', 'mika123', 'Mika', 'Mikic', 'Petrovac na Mlavi', 'Bulevar revolucije 456', '015866789');

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
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `uplata`
--

INSERT INTO `uplata` (`idUplate`, `idKartice`, `idRacuna`) VALUES
(34, 7, 116),
(35, 8, 126),
(49, 14, 181),
(50, 7, 183),
(51, 7, 184);

-- --------------------------------------------------------

--
-- Table structure for table `zaposleni`
--

DROP TABLE IF EXISTS `zaposleni`;
CREATE TABLE IF NOT EXISTS `zaposleni` (
  `idZaposlenog` int(11) NOT NULL AUTO_INCREMENT,
  `korisnickoIme` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `lozinka` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `tip` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`idZaposlenog`),
  UNIQUE KEY `korisnickoIme` (`korisnickoIme`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `zaposleni`
--

INSERT INTO `zaposleni` (`idZaposlenog`, `korisnickoIme`, `lozinka`, `tip`) VALUES
(1, 'pera', '123', 'o'),
(2, 'zika', '123', 'k'),
(3, 'mika', '123', 'a');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `boravak`
--
ALTER TABLE `boravak`
  ADD CONSTRAINT `boravak_ibfk_1` FOREIGN KEY (`idKartice`) REFERENCES `kartica` (`idKartice`) ON DELETE CASCADE,
  ADD CONSTRAINT `boravak_ibfk_2` FOREIGN KEY (`idRacuna`) REFERENCES `racun` (`idRacuna`);

--
-- Constraints for table `isplata`
--
ALTER TABLE `isplata`
  ADD CONSTRAINT `isplata_ibfk_1` FOREIGN KEY (`idKartice`) REFERENCES `kartica` (`idKartice`) ON DELETE CASCADE,
  ADD CONSTRAINT `isplata_ibfk_2` FOREIGN KEY (`idRacuna`) REFERENCES `racun` (`idRacuna`);

--
-- Constraints for table `izdavanje`
--
ALTER TABLE `izdavanje`
  ADD CONSTRAINT `izdavanje_ibfk_1` FOREIGN KEY (`idKartice`) REFERENCES `kartica` (`idKartice`) ON DELETE CASCADE,
  ADD CONSTRAINT `izdavanje_ibfk_2` FOREIGN KEY (`idRacuna`) REFERENCES `racun` (`idRacuna`);

--
-- Constraints for table `kartica`
--
ALTER TABLE `kartica`
  ADD CONSTRAINT `kartica_ibfk_1` FOREIGN KEY (`idKorisnika`) REFERENCES `registrovani` (`idKorisnika`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `kazna`
--
ALTER TABLE `kazna`
  ADD CONSTRAINT `kazna_ibfk_1` FOREIGN KEY (`idBoravka`) REFERENCES `boravak` (`idBoravka`) ON DELETE CASCADE;

--
-- Constraints for table `obnova`
--
ALTER TABLE `obnova`
  ADD CONSTRAINT `obnova_ibfk_1` FOREIGN KEY (`idKartice`) REFERENCES `kartica` (`idKartice`) ON DELETE CASCADE,
  ADD CONSTRAINT `obnova_ibfk_2` FOREIGN KEY (`idRacuna`) REFERENCES `racun` (`idRacuna`);

--
-- Constraints for table `uplata`
--
ALTER TABLE `uplata`
  ADD CONSTRAINT `uplata_ibfk_1` FOREIGN KEY (`idKartice`) REFERENCES `kartica` (`idKartice`) ON DELETE CASCADE,
  ADD CONSTRAINT `uplata_ibfk_2` FOREIGN KEY (`idRacuna`) REFERENCES `racun` (`idRacuna`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
