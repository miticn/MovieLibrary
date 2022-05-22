-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 20, 2022 at 01:07 PM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `movielibrary`
--
CREATE DATABASE IF NOT EXISTS `movielibrary`;
USE `movielibrary`;
-- --------------------------------------------------------

--
-- Table structure for table `cuva_korisnika`
--

DROP TABLE IF EXISTS `cuva_korisnika`;
CREATE TABLE IF NOT EXISTS `cuva_korisnika` (
  `idCuva` int(11) NOT NULL,
  `idCuvan` int(11) NOT NULL,
  PRIMARY KEY (`idCuva`,`idCuvan`),
  KEY `fk_Cuva_Korisnika_Korisnik2_idx` (`idCuva`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cuva_listu`
--

DROP TABLE IF EXISTS `cuva_listu`;
CREATE TABLE IF NOT EXISTS `cuva_listu` (
  `Korsinik_id_cuva` int(11) NOT NULL,
  `Lista_id_cuvana` int(11) NOT NULL,
  PRIMARY KEY (`Korsinik_id_cuva`,`Lista_id_cuvana`),
  KEY `fk_Cuva_Listu_Lista1_idx` (`Lista_id_cuvana`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `film`
--

DROP TABLE IF EXISTS `film`;
CREATE TABLE IF NOT EXISTS `film` (
  `idFilm` int(11) NOT NULL AUTO_INCREMENT,
  `Naziv` varchar(45) NOT NULL,
  `Opis` varchar(500) NOT NULL,
  `BrojLajk` int(11) NOT NULL,
  `BrojDislajk` int(11) NOT NULL,
  PRIMARY KEY (`idFilm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `glumac`
--

DROP TABLE IF EXISTS `glumac`;
CREATE TABLE IF NOT EXISTS `glumac` (
  `idGlumac` int(11) NOT NULL,
  `Ime` varchar(45) NOT NULL,
  `Opis` varchar(500) NOT NULL,
  `BrojLajk` int(11) NOT NULL,
  `BrojDislajk` int(11) NOT NULL,
  PRIMARY KEY (`idGlumac`),
  UNIQUE KEY `idGlumac_UNIQUE` (`idGlumac`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `glumi`
--

DROP TABLE IF EXISTS `glumi`;
CREATE TABLE IF NOT EXISTS `glumi` (
  `Film_idFilm` int(11) NOT NULL,
  `Glumac_idGlumac` int(11) NOT NULL,
  PRIMARY KEY (`Film_idFilm`,`Glumac_idGlumac`),
  KEY `fk_Glumi_Glumac1_idx` (`Glumac_idGlumac`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `komentar`
--

DROP TABLE IF EXISTS `komentar`;
CREATE TABLE IF NOT EXISTS `komentar` (
  `idKomentar` int(11) NOT NULL,
  `Tekst` varchar(200) NOT NULL,
  `Korisnik_idKorisnik` int(11) NOT NULL,
  `Indikator` int(11) NOT NULL,
  `Stranica` int(11) NOT NULL,
  PRIMARY KEY (`idKomentar`),
  KEY `fk_Komentar_Korisnik1` (`Korisnik_idKorisnik`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `korisnik`
--

DROP TABLE IF EXISTS `korisnik`;
CREATE TABLE IF NOT EXISTS `korisnik` (
  `idKorisnik` int(11) NOT NULL AUTO_INCREMENT,
  `KorisnickoIme` varchar(45) NOT NULL,
  `Ime` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `Sifra` varchar(60) NOT NULL,
  `Vrsta` tinyint(1) NOT NULL,
  `Opis` varchar(120) DEFAULT 'Novajlija ovde.',
  PRIMARY KEY (`idKorisnik`),
  UNIQUE KEY `idKor_UNIQUE` (`idKorisnik`),
  UNIQUE KEY `KorisnickoIme_UNIQUE` (`KorisnickoIme`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`KorisnickoIme`, `Ime`, `email`, `Sifra`, `Vrsta`, `Opis`) VALUES
('brucewillis', 'John McClane', 'bruce@movielibrary.com', 'bruce123', '1', 'Ja sam admin.'),
('alanrickman', 'Hans Gruber', 'alan@movielibrary.com', 'alan123', '0', 'Ja nisam admin.');

-- --------------------------------------------------------

--
-- Table structure for table `lajk_dislajk`
--

DROP TABLE IF EXISTS `lajk_dislajk`;
CREATE TABLE IF NOT EXISTS `lajk_dislajk` (
  `idLajk_Dislajk` int(11) NOT NULL,
  `Korisnik_idKorisnik` int(11) NOT NULL,
  `Indikator` int(11) NOT NULL,
  `Lokacija` int(11) NOT NULL,
  `Vrsta` int(11) DEFAULT NULL,
  PRIMARY KEY (`idLajk_Dislajk`),
  UNIQUE KEY `Lokacija_UNIQUE` (`Lokacija`),
  KEY `fk_Lajk_Dislajk_Korisnik1` (`Korisnik_idKorisnik`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lista`
--

DROP TABLE IF EXISTS `lista`;
CREATE TABLE IF NOT EXISTS `lista` (
  `idLista` int(11) NOT NULL,
  `Ime` varchar(45) NOT NULL,
  `Korisnik_idKorisnik` int(11) NOT NULL,
  `BrojLajk` int(11) NOT NULL,
  `BrojDislajk` int(11) NOT NULL,
  PRIMARY KEY (`idLista`),
  UNIQUE KEY `idLista_UNIQUE` (`idLista`),
  KEY `fk_Lista_Korisnik_idx` (`Korisnik_idKorisnik`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `prikazuje_se`
--

DROP TABLE IF EXISTS `prikazuje_se`;
CREATE TABLE IF NOT EXISTS `prikazuje_se` (
  `Film_idFilm` int(11) NOT NULL,
  `URL` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Film_idFilm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `u_listi`
--

DROP TABLE IF EXISTS `u_listi`;
CREATE TABLE IF NOT EXISTS `u_listi` (
  `Lista_idLista` int(11) NOT NULL,
  `Film_idFilm` int(11) NOT NULL,
  PRIMARY KEY (`Lista_idLista`,`Film_idFilm`),
  KEY `fk_U_Listi_Film1_idx` (`Film_idFilm`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cuva_listu`
--
ALTER TABLE `cuva_listu`
  ADD CONSTRAINT `fk_Cuva_Listu_Korisnik1` FOREIGN KEY (`Korsinik_id_cuva`) REFERENCES `korisnik` (`idKorisnik`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Cuva_Listu_Lista1` FOREIGN KEY (`Lista_id_cuvana`) REFERENCES `lista` (`idLista`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `glumi`
--
ALTER TABLE `glumi`
  ADD CONSTRAINT `fk_Glumi_Film1` FOREIGN KEY (`Film_idFilm`) REFERENCES `film` (`idFilm`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Glumi_Glumac1` FOREIGN KEY (`Glumac_idGlumac`) REFERENCES `glumac` (`idGlumac`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `komentar`
--
ALTER TABLE `komentar`
  ADD CONSTRAINT `fk_Komentar_Korisnik1` FOREIGN KEY (`Korisnik_idKorisnik`) REFERENCES `korisnik` (`idKorisnik`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `lajk_dislajk`
--
ALTER TABLE `lajk_dislajk`
  ADD CONSTRAINT `fk_Lajk_Dislajk_Korisnik1` FOREIGN KEY (`Korisnik_idKorisnik`) REFERENCES `korisnik` (`idKorisnik`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `lista`
--
ALTER TABLE `lista`
  ADD CONSTRAINT `fk_Lista_Korisnik` FOREIGN KEY (`Korisnik_idKorisnik`) REFERENCES `korisnik` (`idKorisnik`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `prikazuje_se`
--
ALTER TABLE `prikazuje_se`
  ADD CONSTRAINT `fk_table1_Film1` FOREIGN KEY (`Film_idFilm`) REFERENCES `film` (`idFilm`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `u_listi`
--
ALTER TABLE `u_listi`
  ADD CONSTRAINT `fk_U_Listi_Film1` FOREIGN KEY (`Film_idFilm`) REFERENCES `film` (`idFilm`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_U_Listi_Lista1` FOREIGN KEY (`Lista_idLista`) REFERENCES `lista` (`idLista`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;