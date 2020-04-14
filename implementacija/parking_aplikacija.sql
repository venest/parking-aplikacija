-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 14, 2020 at 01:46 PM
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(7, 'LO-401-MN', 1, '2020-04-22', '401.90'),
(8, 'LO-400-RE', 1, '2020-04-30', '0.00'),
(9, 'LO-980-PĐ', 2, '2020-05-22', '0.00'),
(10, 'LO-512-ĆŽ', 2, '2020-05-05', '0.00'),
(11, 'LO-678-QR', 2, '2020-04-17', '0.00');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `registrovani`
--

INSERT INTO `registrovani` (`idKorisnika`, `email`, `lozinka`, `ime`, `prezime`, `grad`, `adresa`, `telefon`) VALUES
(1, 'pera@etf.rs', 'pera123', 'Pera', 'Peric', 'Loznica', 'Pasiceva 13', '0648652312'),
(2, 'mika@etf.rs', 'mika123', 'Mika', 'Mikic', 'Loznica', 'Valjevski put 89', '0641355313'),
(3, 'zika@etf.rs', 'zika123', 'Zika', 'Zikic', 'Beograd', 'Bulevar Kralja Aleksandra 170', '0645490876');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
