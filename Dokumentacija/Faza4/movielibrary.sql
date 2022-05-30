-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 30, 2022 at 10:00 PM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `movielibrary`
--

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

--
-- Dumping data for table `cuva_korisnika`
--

INSERT INTO `cuva_korisnika` (`idCuva`, `idCuvan`) VALUES
(1, 2),
(1, 3),
(1, 4),
(2, 3),
(4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `cuva_listu`
--

DROP TABLE IF EXISTS `cuva_listu`;
CREATE TABLE IF NOT EXISTS `cuva_listu` (
  `Korisnik_id_cuva` int(11) NOT NULL,
  `Lista_id_cuvana` int(11) NOT NULL,
  PRIMARY KEY (`Korisnik_id_cuva`,`Lista_id_cuvana`),
  KEY `fk_Cuva_Listu_Lista1_idx` (`Lista_id_cuvana`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cuva_listu`
--

INSERT INTO `cuva_listu` (`Korisnik_id_cuva`, `Lista_id_cuvana`) VALUES
(1, 1),
(1, 2),
(1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `film`
--

DROP TABLE IF EXISTS `film`;
CREATE TABLE IF NOT EXISTS `film` (
  `idFilm` int(11) NOT NULL AUTO_INCREMENT,
  `Naziv` varchar(45) NOT NULL,
  `Opis` varchar(500) NOT NULL,
  `Reziseri` varchar(45) NOT NULL,
  `Pisci` varchar(45) NOT NULL,
  `Zanrovi` varchar(45) NOT NULL,
  `Datum_Objave` date DEFAULT NULL,
  `Trajanje` time DEFAULT NULL,
  `BrojLajk` int(11) NOT NULL DEFAULT '0',
  `BrojDislajk` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idFilm`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `film`
--

INSERT INTO `film` (`idFilm`, `Naziv`, `Opis`, `Reziseri`, `Pisci`, `Zanrovi`, `Datum_Objave`, `Trajanje`, `BrojLajk`, `BrojDislajk`) VALUES
(1, 'Fantastic Beasts: The Secrets of Dumbledore', 'Professor Albus Dumbledore knows the powerful, dark wizard Gellert Grindelwald is moving to seize control of the wizarding world. Unable to stop him alone, he entrusts magizoologist Newt Scamander to lead an intrepid team of wizards and witches. They soon encounter an array of old and new beasts as ', 'Rosalinda Lopez', 'Pedro Miceli', 'Akcija, Drama', '1990-02-03', '01:00:18', 60, 39),
(2, 'Morbius', 'Dangerously ill with a rare blood disorder, and determined to save others suffering his same fate, Dr. Michael Morbius attempts a desperate gamble. What at first appears to be a radical success soon reveals itself to be a remedy potentially worse than the disease.', 'Opal Shipton', 'Guy Benson', 'Akcija, Drama', '1990-02-03', '01:00:18', 37, 50),
(3, 'The Lost City', 'A reclusive romance novelist was sure nothing could be worse than getting stuck on a book tour with her cover model until a kidnapping attempt sweeps them both into a cutthroat jungle adventure, proving life can be so much stranger, and more romantic, than any of her paperback fictions.', 'Bessie Kamaka', 'Benjamin Dean', 'Akcija, Drama', '1990-02-03', '01:00:18', 29, 2),
(4, 'Sonic the Hedgehog 2', 'After settling in Green Hills, Sonic is eager to prove he has what it takes to be a true hero. His test comes when Dr. Robotnik returns, this time with a new partner, Knuckles, in search for an emerald that has the power to destroy civilizations. Sonic teams up with his own sidekick, Tails, and toge', 'Robert Stephenson', 'Margaret Vasquez', 'Akcija, Drama', '1990-02-03', '01:00:18', 80, 36),
(5, 'The Northman', 'Prince Amleth is on the verge of becoming a man when his father is brutally murdered by his uncle, who kidnaps the boys mother. Two decades later, Amleth is now a Viking whos on a mission to save his mother, kill his uncle and avenge his father.', 'John Thornton', 'Jessica Nichols', 'Akcija, Drama', '1990-02-03', '01:00:18', 90, 97),
(6, 'Uncharted', 'A young street-smart, Nathan Drake and his wisecracking partner Victor “Sully” Sullivan embark on a dangerous pursuit of “the greatest treasure never found” while also tracking clues that may lead to Nathans long-lost brother.', 'Richard Clouse', 'Cindy Hernandez', 'Akcija, Drama', '1990-02-03', '01:00:18', 88, 28),
(7, 'The Batman', 'In his second year of fighting crime, Batman uncovers corruption in Gotham City that connects to his own family while facing a serial killer known as the Riddler.', 'Patricia Arnold', 'Heather Ranney', 'Akcija, Drama', '1990-02-03', '01:00:18', 14, 16),
(8, 'Doctor Strange in the Multiverse of Madness', 'Doctor Strange, with the help of mystical allies both old and new, traverses the mind-bending and dangerous alternate realities of the Multiverse to confront a mysterious new adversary.', 'Margaret Moore', 'Herbert Carpenter', 'Akcija, Drama', '1990-02-03', '01:00:18', 1, 60),
(9, 'Spider-Man: No Way Home', 'Peter Parker is unmasked and no longer able to separate his normal life from the high-stakes of being a super-hero. When he asks for help from Doctor Strange the stakes become even more dangerous, forcing him to discover what it truly means to be Spider-Man.', 'Michael Schwartz', 'Lillian Molina', 'Akcija, Drama', '1990-02-03', '01:00:18', 79, 41),
(10, 'A Day to Die', 'A disgraced parole officer is indebted to a local gang leader and forced to pull off a series of dangerous drug heists within twelve hours in order to pay the $2 million dollars he owes, rescue his kidnapped pregnant wife, and settle a score with the citys corrupt police chief, who is working with t', 'Harry Mcclean', 'Madeline Fuller', 'Akcija, Drama', '1990-02-03', '01:00:18', 46, 93),
(11, 'The Exorcism of God', 'An American priest working in Mexico is considered a saint by many local parishioners. However, due to a botched exorcism, he carries a secret thats eating him alive until he gets an opportunity to face his demon one final time.', 'Benjamin Lavalette', 'Ronald Jones', 'Akcija, Drama', '1990-02-03', '01:00:18', 47, 10),
(12, 'The Contractor', 'After being involuntarily discharged from the U.S. Special Forces, James Harper decides to support his family by joining a private contracting organization alongside his best friend and under the command of a fellow veteran. Overseas on a covert mission, Harper must evade those trying to kill him wh', 'John Brown', 'John Thomas', 'Akcija, Drama', '1990-02-03', '01:00:18', 50, 96),
(13, 'Turning Red', 'Thirteen-year-old Mei is experiencing the awkwardness of being a teenager with a twist – when she gets too excited, she transforms into a giant red panda.', 'John Fennell', 'John Cotton', 'Akcija, Drama', '1990-02-03', '01:00:18', 13, 50),
(14, 'The Bad Guys', 'When the infamous Bad Guys are finally caught after years of countless heists and being the worlds most-wanted villains, Mr. Wolf brokers a deal to save them all from prison.', 'Mary Coleman', 'Margaret Wolfe', 'Akcija, Drama', '1990-02-03', '01:00:18', 51, 14),
(15, 'Memory', 'Alex, an assassin-for-hire, finds that hes become a target after he refuses to complete a job for a dangerous criminal organization. With the crime syndicate and FBI in hot pursuit, Alex has the skills to stay ahead, except for one thing: he is struggling with severe memory loss, affecting his every', 'John Marshall', 'Donald Finney', 'Akcija, Drama', '1990-02-03', '01:00:18', 14, 96),
(16, 'Moonfall', 'A mysterious force knocks the moon from its orbit around Earth and sends it hurtling on a collision course with life as we know it.', 'Edward Cordova', 'Antonio Pate', 'Akcija, Drama', '1990-02-03', '01:00:18', 46, 82),
(17, 'Ambulance', 'Decorated veteran Will Sharp, desperate for money to cover his wifes medical bills, asks for help from his adoptive brother Danny. A charismatic career criminal, Danny instead offers him a score: the biggest bank heist in Los Angeles history: $32 million.', 'John Michael', 'Audrey Crutcher', 'Akcija, Drama', '1990-02-03', '01:00:18', 72, 25),
(18, 'Virus:32', 'A virus is unleashed and a chilling massacre runs through the streets of Montevideo.', 'Latrice Dickerson', 'John Kirkpatrick', 'Akcija, Drama', '1990-02-03', '01:00:18', 23, 93),
(19, 'Chip n Dale: Rescue Rangers', 'Decades after their successful television series was canceled, Chip and Dale must repair their broken friendship and take on their Rescue Rangers detective personas once again when a former cast mate mysteriously disappears.', 'Susan Ankrom', 'Karen Griffin', 'Akcija, Drama', '1990-02-03', '01:00:18', 100, 73),
(20, 'Doctor Strange', 'After his career is destroyed, a brilliant but arrogant surgeon gets a new lease on life when a sorcerer takes him under her wing and trains him to defend the world against evil.', 'Vernon Lewis', 'Clarence Lewis', 'Akcija, Drama', '1990-02-03', '01:00:18', 75, 84);

-- --------------------------------------------------------

--
-- Table structure for table `glumac`
--

DROP TABLE IF EXISTS `glumac`;
CREATE TABLE IF NOT EXISTS `glumac` (
  `idGlumac` int(11) NOT NULL AUTO_INCREMENT,
  `Ime` varchar(45) NOT NULL,
  `Opis` varchar(500) NOT NULL,
  `Datum_Rodjenja` date DEFAULT NULL,
  `BrojLajk` int(11) NOT NULL DEFAULT '0',
  `BrojDislajk` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idGlumac`),
  UNIQUE KEY `idGlumac_UNIQUE` (`idGlumac`)
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `glumac`
--

INSERT INTO `glumac` (`idGlumac`, `Ime`, `Opis`, `Datum_Rodjenja`, `BrojLajk`, `BrojDislajk`) VALUES
(1, 'Eddie Redmayne', 'Neki opis', '1980-01-02', 28, 90),
(2, 'Jude Law', 'Neki opis', '1980-01-02', 39, 8),
(3, 'Mads Mikkelsen', 'Neki opis', '1980-01-02', 47, 10),
(4, 'Ezra Miller', 'Neki opis', '1980-01-02', 49, 13),
(5, 'Jared Leto', 'Neki opis', '1980-01-02', 81, 64),
(6, 'Matt Smith', 'Neki opis', '1980-01-02', 30, 37),
(7, 'Adria Arjona', 'Neki opis', '1980-01-02', 14, 29),
(8, 'Jared Harris', 'Neki opis', '1980-01-02', 99, 64),
(9, 'Sandra Bullock', 'Neki opis', '1980-01-02', 45, 8),
(10, 'Channing Tatum', 'Neki opis', '1980-01-02', 4, 43),
(11, 'Daniel Radcliffe', 'Neki opis', '1980-01-02', 87, 36),
(12, 'Brad Pitt', 'Neki opis', '1980-01-02', 53, 63),
(13, 'James Marsden', 'Neki opis', '1980-01-02', 93, 35),
(14, 'Ben Schwartz', 'Neki opis', '1980-01-02', 24, 16),
(15, 'Tika Sumpter', 'Neki opis', '1980-01-02', 3, 67),
(16, 'Natasha Rothwell', 'Neki opis', '1980-01-02', 23, 14),
(17, 'Alexander Skarsgård', 'Neki opis', '1980-01-02', 81, 79),
(18, 'Nicole Kidman', 'Neki opis', '1980-01-02', 21, 49),
(19, 'Claes Bang', 'Neki opis', '1980-01-02', 35, 41),
(20, 'Ethan Hawke', 'Neki opis', '1980-01-02', 96, 48),
(21, 'Tom Holland', 'Neki opis', '1980-01-02', 56, 39),
(22, 'Mark Wahlberg', 'Neki opis', '1980-01-02', 55, 77),
(23, 'Sophia Ali', 'Neki opis', '1980-01-02', 77, 46),
(24, 'Tati Gabrielle', 'Neki opis', '1980-01-02', 66, 3),
(25, 'Robert Pattinson', 'Neki opis', '1980-01-02', 2, 36),
(26, 'Zoë Kravitz', 'Neki opis', '1980-01-02', 42, 66),
(27, 'Paul Dano', 'Neki opis', '1980-01-02', 48, 15),
(28, 'Jeffrey Wright', 'Neki opis', '1980-01-02', 83, 69),
(29, 'Benedict Cumberbatch', 'Neki opis', '1980-01-02', 96, 74),
(30, 'Elizabeth Olsen', 'Neki opis', '1980-01-02', 61, 42),
(31, 'Chiwetel Ejiofor', 'Neki opis', '1980-01-02', 69, 7),
(32, 'Benedict Wong', 'Neki opis', '1980-01-02', 45, 4),
(33, 'Zendaya', 'Neki opis', '1980-01-02', 70, 7),
(34, 'Jacob Batalon', 'Neki opis', '1980-01-02', 100, 23),
(35, 'Kevin Dillon', 'Neki opis', '1980-01-02', 97, 19),
(36, 'Bruce Willis', 'Neki opis', '1980-01-02', 73, 16),
(37, 'Leon', 'Neki opis', '1980-01-02', 17, 100),
(38, 'Frank Grillo', 'Neki opis', '1980-01-02', 43, 32),
(39, 'Will Beinbrink', 'Neki opis', '1980-01-02', 55, 31),
(40, 'María Gabriela de Faría', 'Neki opis', '1980-01-02', 58, 23),
(41, 'Irán Castillo', 'Neki opis', '1980-01-02', 58, 16),
(42, 'Joseph Marcell', 'Neki opis', '1980-01-02', 91, 38),
(43, 'Chris Pine', 'Neki opis', '1980-01-02', 71, 86),
(44, 'Ben Foster', 'Neki opis', '1980-01-02', 57, 37),
(45, 'Gillian Jacobs', 'Neki opis', '1980-01-02', 10, 28),
(46, 'Eddie Marsan', 'Neki opis', '1980-01-02', 96, 42),
(47, 'Sandra Oh', 'Neki opis', '1980-01-02', 85, 42),
(48, 'Rosalie Chiang', 'Neki opis', '1980-01-02', 65, 78),
(49, 'Ava Morse', 'Neki opis', '1980-01-02', 36, 36),
(50, 'Maitreyi Ramakrishnan', 'Neki opis', '1980-01-02', 22, 32),
(51, 'Sam Rockwell', 'Neki opis', '1980-01-02', 87, 12),
(52, 'Marc Maron', 'Neki opis', '1980-01-02', 59, 5),
(53, 'Awkwafina', 'Neki opis', '1980-01-02', 26, 87),
(54, 'Craig Robinson', 'Neki opis', '1980-01-02', 66, 76),
(55, 'Liam Neeson', 'Neki opis', '1980-01-02', 26, 53),
(56, 'Guy Pearce', 'Neki opis', '1980-01-02', 55, 39),
(57, 'Taj Atwal', 'Neki opis', '1980-01-02', 31, 14),
(58, 'Harold Torres', 'Neki opis', '1980-01-02', 96, 12),
(59, 'Halle Berry', 'Neki opis', '1980-01-02', 12, 48),
(60, 'Patrick Wilson', 'Neki opis', '1980-01-02', 97, 27),
(61, 'John Bradley', 'Neki opis', '1980-01-02', 17, 95),
(62, 'Charlie Plummer', 'Neki opis', '1980-01-02', 85, 1),
(63, 'Jake Gyllenhaal', 'Neki opis', '1980-01-02', 24, 4),
(64, 'Yahya Abdul-Mateen II', 'Neki opis', '1980-01-02', 66, 29),
(65, 'Eiza González', 'Neki opis', '1980-01-02', 10, 51),
(66, 'Garret Dillahunt', 'Neki opis', '1980-01-02', 22, 88),
(67, 'Daniel Hendler', 'Neki opis', '1980-01-02', 48, 51),
(68, 'Paula Silva', 'Neki opis', '1980-01-02', 62, 38),
(69, 'Franco Rilla', 'Neki opis', '1980-01-02', 21, 98),
(70, 'Sofía González', 'Neki opis', '1980-01-02', 18, 82),
(71, 'Andy Samberg', 'Neki opis', '1980-01-02', 42, 51),
(72, 'John Mulaney', 'Neki opis', '1980-01-02', 100, 28),
(73, 'KiKi Layne', 'Neki opis', '1980-01-02', 84, 21),
(74, 'Will Arnett', 'Neki opis', '1980-01-02', 64, 6),
(75, 'Rachel McAdams', 'Neki opis', '1980-01-02', 55, 10);

-- --------------------------------------------------------

--
-- Table structure for table `glumi`
--

DROP TABLE IF EXISTS `glumi`;
CREATE TABLE IF NOT EXISTS `glumi` (
  `Film_idFilm` int(11) NOT NULL,
  `Glumac_idGlumac` int(11) NOT NULL,
  `Ime_uloge` varchar(45) NOT NULL,
  PRIMARY KEY (`Film_idFilm`,`Glumac_idGlumac`),
  KEY `fk_Glumi_Glumac1_idx` (`Glumac_idGlumac`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `glumi`
--

INSERT INTO `glumi` (`Film_idFilm`, `Glumac_idGlumac`, `Ime_uloge`) VALUES
(1, 1, 'Newt Scamander'),
(1, 2, 'Albus Dumbledore'),
(1, 3, 'Gellert Grindelwald'),
(1, 4, 'Credence Barebone / Aurelius Dumbledore'),
(2, 5, 'Dr. Michael Morbius / Morbius'),
(2, 6, 'Milo / Lucien'),
(2, 7, 'Martine Bancroft'),
(2, 8, 'Dr. Emil Nicholas'),
(3, 9, 'Loretta Sage / Angela'),
(3, 10, 'Alan / Dash'),
(3, 11, 'Abigail Fairfax'),
(3, 12, 'Jack Trainer'),
(4, 13, 'Tom Wachowski'),
(4, 14, 'Sonic the Hedgehog (voice)'),
(4, 15, 'Maddie Wachowski'),
(4, 16, 'Rachel'),
(5, 17, 'Amleth'),
(5, 18, 'Queen Gudrún'),
(5, 19, 'Fjölnir The Brotherless'),
(5, 20, 'King Aurvandil War-Raven'),
(6, 21, 'Nathan Drake'),
(6, 22, 'Victor \'Sully\' Sullivan'),
(6, 23, 'Chloe Frazer'),
(6, 24, 'Jo Braddock'),
(7, 25, 'Bruce Wayne / The Batman'),
(7, 26, 'Selina Kyle / Catwoman'),
(7, 27, 'Edward Nashton / The Riddler'),
(7, 28, 'Lt. James Gordon'),
(8, 29, 'Dr. Stephen Strange / Sinister Strange / Defe'),
(8, 30, 'Wanda Maximoff / The Scarlet Witch'),
(8, 31, 'Baron Karl Mordo'),
(8, 32, 'Wong'),
(9, 21, 'Peter Parker / Spider-Man'),
(9, 29, 'Stephen Strange / Doctor Strange'),
(9, 33, 'Michelle \'MJ\' Jones'),
(9, 34, 'Ned Leeds'),
(10, 35, 'Connor'),
(10, 36, 'Alston'),
(10, 37, 'Pettis'),
(10, 38, 'Mason'),
(11, 39, 'Father Peter Williams'),
(11, 40, 'Esperanza'),
(11, 41, 'Magali'),
(11, 42, 'Father Michael Lewis'),
(12, 43, 'James Harper'),
(12, 44, 'Mike'),
(12, 45, 'Brianne'),
(12, 46, 'Virgil'),
(13, 47, 'Ming (voice)'),
(13, 48, 'Meilin \'Mei\' Lee (voice)'),
(13, 49, 'Miriam (voice)'),
(13, 50, 'Priya (voice)'),
(14, 51, 'Mr. Wolf (voice)'),
(14, 52, 'Mr. Snake (voice)'),
(14, 53, 'Ms. Tarantula (voice)'),
(14, 54, 'Mr. Shark (voice)'),
(15, 55, 'Alex Lewis'),
(15, 56, 'Vincent Serra'),
(15, 57, 'Linda Amistead'),
(15, 58, 'Hugo Marquez'),
(16, 59, 'Jo Fowler'),
(16, 60, 'Brian Harper'),
(16, 61, 'K.C. Houseman'),
(16, 62, 'Sonny Harper'),
(17, 63, 'Danny Sharp'),
(17, 64, 'Will Sharp'),
(17, 65, 'Cam Thompson'),
(17, 66, 'Captain Monroe'),
(18, 67, 'Luis'),
(18, 68, 'Iris'),
(18, 69, 'Javier'),
(18, 70, 'Miriam'),
(19, 71, 'Dale (voice)'),
(19, 72, 'Chip (voice)'),
(19, 73, 'Ellie Steckler'),
(19, 74, 'Sweet Pete (voice)'),
(20, 29, 'Stephen Strange / Doctor Strange'),
(20, 31, 'Karl Mordo'),
(20, 32, 'Wong'),
(20, 75, 'Dr. Christine Palmer');

-- --------------------------------------------------------

--
-- Table structure for table `komentar`
--

DROP TABLE IF EXISTS `komentar`;
CREATE TABLE IF NOT EXISTS `komentar` (
  `idKomentar` int(11) NOT NULL AUTO_INCREMENT,
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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `korisnik`
--

INSERT INTO `korisnik` (`idKorisnik`, `KorisnickoIme`, `Ime`, `email`, `Sifra`, `Vrsta`, `Opis`) VALUES
(1, 'brucewillis', 'John McClane', 'bruce@movielibrary.com', 'bruce123', 1, 'Ja sam admin.'),
(2, 'alanrickman', 'Hans Gruber', 'alan@movielibrary.com', 'alan123', 0, 'Ja nisam admin.'),
(3, 'bonniebedelia', 'Holly Gennaro', 'holly@movielibrary.com', 'bonnie123', 0, 'Novajlija ovde.'),
(4, 'reginaldveljohnson', 'Sgt. Al Powell', 'reginald@movielibrary.com', 'reginald123', 0, 'Novajlija ovde.');

-- --------------------------------------------------------

--
-- Table structure for table `lajk_dislajk`
--

DROP TABLE IF EXISTS `lajk_dislajk`;
CREATE TABLE IF NOT EXISTS `lajk_dislajk` (
  `idLajk_Dislajk` int(11) NOT NULL AUTO_INCREMENT,
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
  `idLista` int(11) NOT NULL AUTO_INCREMENT,
  `Ime` varchar(45) NOT NULL,
  `Korisnik_idKorisnik` int(11) NOT NULL,
  `BrojLajk` int(11) NOT NULL DEFAULT '0',
  `BrojDislajk` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idLista`),
  UNIQUE KEY `idLista_UNIQUE` (`idLista`),
  KEY `fk_Lista_Korisnik_idx` (`Korisnik_idKorisnik`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `lista`
--

INSERT INTO `lista` (`idLista`, `Ime`, `Korisnik_idKorisnik`, `BrojLajk`, `BrojDislajk`) VALUES
(1, 'Epic Lista', 1, 0, 0),
(2, 'Jos Bolja', 2, 5, 0),
(3, 'Najbolja Lista', 3, 0, 3);

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
-- Dumping data for table `u_listi`
--

INSERT INTO `u_listi` (`Lista_idLista`, `Film_idFilm`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cuva_listu`
--
ALTER TABLE `cuva_listu`
  ADD CONSTRAINT `fk_Cuva_Listu_Korisnik1` FOREIGN KEY (`Korisnik_id_cuva`) REFERENCES `korisnik` (`idKorisnik`) ON DELETE NO ACTION ON UPDATE NO ACTION,
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
