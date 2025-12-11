-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 11, 2025 at 07:11 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `booking`
--

-- --------------------------------------------------------

--
-- Table structure for table `filtravimo_konfiguracija`
--

CREATE TABLE `filtravimo_konfiguracija` (
  `pavadinimas` varchar(50) NOT NULL,
  `kaina_nuo` double NOT NULL,
  `kaina_iki` double NOT NULL,
  `kambariu_skaicius` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `fk_Vartotojas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `filtravimo_konfiguracijos_tag`
--

CREATE TABLE `filtravimo_konfiguracijos_tag` (
  `reiksme` varchar(50) NOT NULL,
  `parametro_tipas` enum('kaina_nuo','kaina_iki','sezonas','tag') NOT NULL,
  `id` int(11) NOT NULL,
  `fk_Tag` int(11) NOT NULL,
  `fk_Filtravimo_Konfiguracija` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `komentaras`
--

CREATE TABLE `komentaras` (
  `turinys` varchar(255) NOT NULL,
  `sukurimo_data` date NOT NULL,
  `redagavimo_data` date NOT NULL,
  `patvirtinimas` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `fk_Komentaras` int(11) DEFAULT NULL,
  `fk_Vartotojas` int(11) NOT NULL,
  `fk_Viesbutis` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `megstamiausias_viesbutis`
--

CREATE TABLE `megstamiausias_viesbutis` (
  `pridejimo_data` date NOT NULL,
  `aprasas` varchar(255) NOT NULL,
  `id` int(11) NOT NULL,
  `fk_Viesbutis` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `megstamiausias_viesbutis_vartotojas`
--

CREATE TABLE `megstamiausias_viesbutis_vartotojas` (
  `fk_Megstamiausias_Viesbutis` int(11) NOT NULL,
  `fk_Vartotojas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nuotraukos`
--

CREATE TABLE `nuotraukos` (
  `url` varchar(255) NOT NULL,
  `ikelimo_data` date NOT NULL,
  `formatas` varchar(5) NOT NULL,
  `dydis` double NOT NULL,
  `id` int(11) NOT NULL,
  `fk_Viesbutis` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patvirtinimas`
--

CREATE TABLE `patvirtinimas` (
  `id` int(11) NOT NULL,
  `name` char(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

--
-- Dumping data for table `patvirtinimas`
--

INSERT INTO `patvirtinimas` (`id`, `name`) VALUES
(1, 'laukiamas'),
(2, 'patvirtintas'),
(3, 'nepatvirtintas');

-- --------------------------------------------------------

--
-- Table structure for table `rezervacija`
--

CREATE TABLE `rezervacija` (
  `pradzios_data` date NOT NULL,
  `pabaigos_data` date NOT NULL,
  `sukurimo_data` date NOT NULL,
  `busena` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `fk_Vartotojas` int(11) NOT NULL,
  `fk_Viesbutis` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sezonas`
--

CREATE TABLE `sezonas` (
  `id` int(11) NOT NULL,
  `name` char(9) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

--
-- Dumping data for table `sezonas`
--

INSERT INTO `sezonas` (`id`, `name`) VALUES
(1, 'vasara'),
(2, 'ruduo'),
(3, 'ziema'),
(4, 'pavasaris');

-- --------------------------------------------------------

--
-- Table structure for table `tag`
--

CREATE TABLE `tag` (
  `kategorija` varchar(50) NOT NULL,
  `pavadinimas` varchar(50) NOT NULL,
  `tipas` varchar(30) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vartotojas`
--

CREATE TABLE `vartotojas` (
  `asmens_kodas` varchar(11) NOT NULL,
  `vardas` varchar(30) NOT NULL,
  `pavarde` varchar(25) NOT NULL,
  `el_pastas` varchar(70) NOT NULL,
  `tipas` int(11) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vartotojo_istorija`
--

CREATE TABLE `vartotojo_istorija` (
  `perziuros_data` date NOT NULL,
  `id` int(11) NOT NULL,
  `fk_Vartotojas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vartotoju_tipas`
--

CREATE TABLE `vartotoju_tipas` (
  `id` int(11) NOT NULL,
  `name` char(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

--
-- Dumping data for table `vartotoju_tipas`
--

INSERT INTO `vartotoju_tipas` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Table structure for table `vertinimas`
--

CREATE TABLE `vertinimas` (
  `bendras` int(11) NOT NULL,
  `svara` int(11) NOT NULL,
  `lokacija` int(11) NOT NULL,
  `patogumas` int(11) NOT NULL,
  `komunikacija` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `fk_Komentaras` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `viesbutis`
--

CREATE TABLE `viesbutis` (
  `pavadinimas` varchar(50) NOT NULL,
  `aprasymas` varchar(255) NOT NULL,
  `trumpas_aprasymas` varchar(255) NOT NULL,
  `nuolaida` double NOT NULL,
  `sukurimo_data` date NOT NULL,
  `kaina` float NOT NULL,
  `reitingas` double NOT NULL,
  `kambariu_skaicius` int(11) NOT NULL,
  `sezonas` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `fk_Vietove` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `viesbutis_tag`
--

CREATE TABLE `viesbutis_tag` (
  `reiksme` varchar(40) NOT NULL,
  `id` int(11) NOT NULL,
  `fk_Tag` int(11) NOT NULL,
  `fk_Viesbutis` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vietove`
--

CREATE TABLE `vietove` (
  `salis` varchar(50) NOT NULL,
  `miestas` varchar(30) NOT NULL,
  `adresas` varchar(50) NOT NULL,
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `filtravimo_konfiguracija`
--
ALTER TABLE `filtravimo_konfiguracija`
  ADD PRIMARY KEY (`id`),
  ADD KEY `koreguoja` (`fk_Vartotojas`);

--
-- Indexes for table `filtravimo_konfiguracijos_tag`
--
ALTER TABLE `filtravimo_konfiguracijos_tag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nurodo` (`fk_Tag`),
  ADD KEY `filtravimo_konfig_turi` (`fk_Filtravimo_Konfiguracija`);

--
-- Indexes for table `komentaras`
--
ALTER TABLE `komentaras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patvirtinimas` (`patvirtinimas`),
  ADD KEY `atsako` (`fk_Komentaras`),
  ADD KEY `pateikia` (`fk_Vartotojas`),
  ADD KEY `komentaras_turi` (`fk_Viesbutis`);

--
-- Indexes for table `megstamiausias_viesbutis`
--
ALTER TABLE `megstamiausias_viesbutis`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_Viesbutis` (`fk_Viesbutis`);

--
-- Indexes for table `megstamiausias_viesbutis_vartotojas`
--
ALTER TABLE `megstamiausias_viesbutis_vartotojas`
  ADD PRIMARY KEY (`fk_Megstamiausias_Viesbutis`,`fk_Vartotojas`),
  ADD KEY `fk_Vartotojas` (`fk_Vartotojas`);

--
-- Indexes for table `nuotraukos`
--
ALTER TABLE `nuotraukos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nuotraukos_turi` (`fk_Viesbutis`);

--
-- Indexes for table `patvirtinimas`
--
ALTER TABLE `patvirtinimas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rezervacija`
--
ALTER TABLE `rezervacija`
  ADD PRIMARY KEY (`id`),
  ADD KEY `busena` (`busena`),
  ADD KEY `uzsako` (`fk_Vartotojas`),
  ADD KEY `yra_rezervuojamas` (`fk_Viesbutis`);

--
-- Indexes for table `sezonas`
--
ALTER TABLE `sezonas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tag`
--
ALTER TABLE `tag`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vartotojas`
--
ALTER TABLE `vartotojas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipas` (`tipas`);

--
-- Indexes for table `vartotojo_istorija`
--
ALTER TABLE `vartotojo_istorija`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vartotojo_istorija_turi` (`fk_Vartotojas`);

--
-- Indexes for table `vartotoju_tipas`
--
ALTER TABLE `vartotoju_tipas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vertinimas`
--
ALTER TABLE `vertinimas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fk_Komentaras` (`fk_Komentaras`);

--
-- Indexes for table `viesbutis`
--
ALTER TABLE `viesbutis`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `fk_Vietove` (`fk_Vietove`),
  ADD KEY `sezonas` (`sezonas`);

--
-- Indexes for table `viesbutis_tag`
--
ALTER TABLE `viesbutis_tag`
  ADD PRIMARY KEY (`id`),
  ADD KEY `apibudina` (`fk_Tag`),
  ADD KEY `viesbutis_tag_turi` (`fk_Viesbutis`);

--
-- Indexes for table `vietove`
--
ALTER TABLE `vietove`
  ADD PRIMARY KEY (`id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `filtravimo_konfiguracija`
--
ALTER TABLE `filtravimo_konfiguracija`
  ADD CONSTRAINT `koreguoja` FOREIGN KEY (`fk_Vartotojas`) REFERENCES `vartotojas` (`id`);

--
-- Constraints for table `filtravimo_konfiguracijos_tag`
--
ALTER TABLE `filtravimo_konfiguracijos_tag`
  ADD CONSTRAINT `filtravimo_konfig_turi` FOREIGN KEY (`fk_Filtravimo_Konfiguracija`) REFERENCES `filtravimo_konfiguracija` (`id`),
  ADD CONSTRAINT `nurodo` FOREIGN KEY (`fk_Tag`) REFERENCES `tag` (`id`);

--
-- Constraints for table `komentaras`
--
ALTER TABLE `komentaras`
  ADD CONSTRAINT `atsako` FOREIGN KEY (`fk_Komentaras`) REFERENCES `komentaras` (`id`),
  ADD CONSTRAINT `komentaras_ibfk_1` FOREIGN KEY (`patvirtinimas`) REFERENCES `patvirtinimas` (`id`),
  ADD CONSTRAINT `komentaras_turi` FOREIGN KEY (`fk_Viesbutis`) REFERENCES `viesbutis` (`id`),
  ADD CONSTRAINT `pateikia` FOREIGN KEY (`fk_Vartotojas`) REFERENCES `vartotojas` (`id`);

--
-- Constraints for table `megstamiausias_viesbutis`
--
ALTER TABLE `megstamiausias_viesbutis`
  ADD CONSTRAINT `megstamiausias_viesbutis_ibfk_1` FOREIGN KEY (`fk_Viesbutis`) REFERENCES `viesbutis` (`id`);

--
-- Constraints for table `megstamiausias_viesbutis_vartotojas`
--
ALTER TABLE `megstamiausias_viesbutis_vartotojas`
  ADD CONSTRAINT `megstamiausias_viesbutis_vartotojas_ibfk_1` FOREIGN KEY (`fk_Megstamiausias_Viesbutis`) REFERENCES `megstamiausias_viesbutis` (`id`),
  ADD CONSTRAINT `megstamiausias_viesbutis_vartotojas_ibfk_2` FOREIGN KEY (`fk_Vartotojas`) REFERENCES `vartotojas` (`id`);

--
-- Constraints for table `nuotraukos`
--
ALTER TABLE `nuotraukos`
  ADD CONSTRAINT `nuotraukos_turi` FOREIGN KEY (`fk_Viesbutis`) REFERENCES `viesbutis` (`id`);

--
-- Constraints for table `rezervacija`
--
ALTER TABLE `rezervacija`
  ADD CONSTRAINT `rezervacija_ibfk_1` FOREIGN KEY (`busena`) REFERENCES `patvirtinimas` (`id`),
  ADD CONSTRAINT `uzsako` FOREIGN KEY (`fk_Vartotojas`) REFERENCES `vartotojas` (`id`),
  ADD CONSTRAINT `yra_rezervuojamas` FOREIGN KEY (`fk_Viesbutis`) REFERENCES `viesbutis` (`id`);

--
-- Constraints for table `vartotojas`
--
ALTER TABLE `vartotojas`
  ADD CONSTRAINT `vartotojas_ibfk_1` FOREIGN KEY (`tipas`) REFERENCES `vartotoju_tipas` (`id`);

--
-- Constraints for table `vartotojo_istorija`
--
ALTER TABLE `vartotojo_istorija`
  ADD CONSTRAINT `vartotojo_istorija_turi` FOREIGN KEY (`fk_Vartotojas`) REFERENCES `vartotojas` (`id`);

--
-- Constraints for table `vertinimas`
--
ALTER TABLE `vertinimas`
  ADD CONSTRAINT `priklauso` FOREIGN KEY (`fk_Komentaras`) REFERENCES `komentaras` (`id`);

--
-- Constraints for table `viesbutis`
--
ALTER TABLE `viesbutis`
  ADD CONSTRAINT `viesbutis_ibfk_1` FOREIGN KEY (`sezonas`) REFERENCES `sezonas` (`id`),
  ADD CONSTRAINT `yra` FOREIGN KEY (`fk_Vietove`) REFERENCES `vietove` (`id`);

--
-- Constraints for table `viesbutis_tag`
--
ALTER TABLE `viesbutis_tag`
  ADD CONSTRAINT `apibudina` FOREIGN KEY (`fk_Tag`) REFERENCES `tag` (`id`),
  ADD CONSTRAINT `viesbutis_tag_turi` FOREIGN KEY (`fk_Viesbutis`) REFERENCES `viesbutis` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
