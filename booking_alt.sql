-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 15, 2025 at 03:06 AM
-- Server version: 8.0.44-0ubuntu0.24.04.1
-- PHP Version: 8.3.6

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
  `pavadinimas` varchar(50) COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `kaina_nuo` double NOT NULL,
  `kaina_iki` double NOT NULL,
  `kambariu_skaicius` int NOT NULL,
  `id` int NOT NULL,
  `fk_Vartotojas` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `filtravimo_konfiguracijos_tag`
--

CREATE TABLE `filtravimo_konfiguracijos_tag` (
  `reiksme` varchar(50) COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `parametro_tipas` enum('kaina_nuo','kaina_iki','sezonas','tag') COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `id` int NOT NULL,
  `fk_Tag` int NOT NULL,
  `fk_Filtravimo_Konfiguracija` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `komentaras`
--

CREATE TABLE `komentaras` (
  `turinys` varchar(255) COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `sukurimo_data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `redagavimo_data` datetime NOT NULL,
  `patvirtinimas` int NOT NULL,
  `id` int NOT NULL,
  `fk_Komentaras` int DEFAULT NULL,
  `fk_Vartotojas` int NOT NULL,
  `fk_Viesbutis` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

--
-- Dumping data for table `komentaras`
--

INSERT INTO `komentaras` (`turinys`, `sukurimo_data`, `redagavimo_data`, `patvirtinimas`, `id`, `fk_Komentaras`, `fk_Vartotojas`, `fk_Viesbutis`) VALUES
('geriausia vieta kokioje esu buves!!!!!!!!!!!!! XD', '2025-12-14 17:41:27', '2025-12-14 15:40:45', 2, 1, NULL, 1, 1),
('omg bad vieta lmao!', '2025-12-14 23:46:02', '2025-12-14 21:45:37', 2, 2, NULL, 1, 1),
('wup', '2025-12-14 23:46:24', '2025-12-14 21:46:04', 2, 3, NULL, 1, 1),
('xzcvdw', '2025-12-14 23:46:38', '2025-12-14 21:46:26', 2, 4, NULL, 1, 1),
('rshtrh', '2025-12-14 23:46:59', '2025-12-14 21:46:43', 2, 5, NULL, 1, 1),
('jkluiyk', '2025-12-14 23:47:19', '2025-12-14 21:47:00', 2, 6, NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `megstamiausias_viesbutis`
--

CREATE TABLE `megstamiausias_viesbutis` (
  `pridejimo_data` date NOT NULL,
  `aprasas` varchar(255) COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `id` int NOT NULL,
  `fk_Viesbutis` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `megstamiausias_viesbutis_vartotojas`
--

CREATE TABLE `megstamiausias_viesbutis_vartotojas` (
  `fk_Megstamiausias_Viesbutis` int NOT NULL,
  `fk_Vartotojas` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nuotraukos`
--

CREATE TABLE `nuotraukos` (
  `url` varchar(255) COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `ikelimo_data` date NOT NULL,
  `formatas` varchar(5) COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `dydis` double NOT NULL,
  `id` int NOT NULL,
  `fk_Viesbutis` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `patvirtinimas`
--

CREATE TABLE `patvirtinimas` (
  `id` int NOT NULL,
  `name` char(14) COLLATE utf8mb4_lithuanian_ci NOT NULL
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
  `pradzios_data` datetime NOT NULL,
  `pabaigos_data` datetime NOT NULL,
  `sukurimo_data` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `busena` int NOT NULL,
  `id` int NOT NULL,
  `fk_Vartotojas` int NOT NULL,
  `fk_Viesbutis` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sezonas`
--

CREATE TABLE `sezonas` (
  `id` int NOT NULL,
  `name` char(9) COLLATE utf8mb4_lithuanian_ci NOT NULL
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
  `kategorija` varchar(50) COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `pavadinimas` varchar(50) COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `tipas` varchar(30) COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

--
-- Dumping data for table `tag`
--

INSERT INTO `tag` (`kategorija`, `pavadinimas`, `tipas`, `id`) VALUES
('style', 'luxury', 'hotel', 1),
('style', 'budget', 'hotel', 2),
('location', 'beachfront', 'hotel', 3),
('location', 'city-center', 'hotel', 4),
('style', 'ski-resort', 'hotel', 5),
('audience', 'family-friendly', 'hotel', 6),
('style', 'boutique', 'hotel', 7),
('audience', 'romantic', 'hotel', 8),
('amenities', 'spa', 'hotel', 9),
('amenities', 'pet-friendly', 'hotel', 10);

-- --------------------------------------------------------

--
-- Table structure for table `vartotojas`
--

CREATE TABLE `vartotojas` (
  `vartotojo_vardas` varchar(11) COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `asmens_kodas` varchar(11) COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `vardas` varchar(30) COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `pavarde` varchar(25) COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `el_pastas` varchar(70) COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `slaptazodis` varchar(255) COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `tipas` int NOT NULL,
  `id` int NOT NULL,
  `twofa_secret` varchar(64) COLLATE utf8mb4_lithuanian_ci DEFAULT NULL,
  `twofa_enabled` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

--
-- Dumping data for table `vartotojas`
--

INSERT INTO `vartotojas` (`vartotojo_vardas`, `asmens_kodas`, `vardas`, `pavarde`, `el_pastas`, `slaptazodis`, `tipas`, `id`, `twofa_secret`, `twofa_enabled`) VALUES
('admin', '5023502350', 'admin', 'admin', 'admin@admin.com', 'admin', 1, 1, NULL, 0),
('admin3', '2345346346', 'admin3', 'admin3', 'admin3@admin3.com', '$2y$10$C3w0iEyYywxWkajOQY/rJeWU6.cgx.HWfLzVNb96G7nabOWRpY6bS', 3, 3, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `vartotojo_istorija`
--

CREATE TABLE `vartotojo_istorija` (
  `perziuros_data` date NOT NULL,
  `id` int NOT NULL,
  `fk_Vartotojas` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vartotoju_tipas`
--

CREATE TABLE `vartotoju_tipas` (
  `id` int NOT NULL,
  `name` char(15) COLLATE utf8mb4_lithuanian_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

--
-- Dumping data for table `vartotoju_tipas`
--

INSERT INTO `vartotoju_tipas` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'user'),
(3, 'unverified'),
(4, 'guest');

-- --------------------------------------------------------

--
-- Table structure for table `vertinimas`
--

CREATE TABLE `vertinimas` (
  `bendras` float NOT NULL,
  `svara` int NOT NULL,
  `lokacija` int NOT NULL,
  `patogumas` int NOT NULL,
  `komunikacija` int NOT NULL,
  `id` int NOT NULL,
  `fk_Komentaras` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

--
-- Dumping data for table `vertinimas`
--

INSERT INTO `vertinimas` (`bendras`, `svara`, `lokacija`, `patogumas`, `komunikacija`, `id`, `fk_Komentaras`) VALUES
(10, 3, 5, 7, 5, 1, 1),
(7.5, 4, 2, 7, 5, 4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `viesbutis`
--

CREATE TABLE `viesbutis` (
  `pavadinimas` varchar(50) COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `aprasymas` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `trumpas_aprasymas` varchar(255) COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `nuolaida` double NOT NULL,
  `sukurimo_data` date NOT NULL,
  `kaina` float NOT NULL,
  `reitingas` double NOT NULL,
  `kambariu_skaicius` int NOT NULL,
  `sezonas` int NOT NULL,
  `id` int NOT NULL,
  `fk_Vietove` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

--
-- Dumping data for table `viesbutis`
--

INSERT INTO `viesbutis` (`pavadinimas`, `aprasymas`, `trumpas_aprasymas`, `nuolaida`, `sukurimo_data`, `kaina`, `reitingas`, `kambariu_skaicius`, `sezonas`, `id`, `fk_Vietove`) VALUES
('Venice Retreat', '## A Place to Unwind\r\n\r\nVenice Retreat is designed as a sanctuary away from the crowds, balancing comfort and elegance with the unmistakable character of Venice. Natural light, muted tones, and carefully curated details create an atmosphere of calm, making it an ideal setting for rest and reflection after a day of exploration.\r\n\r\n## Immersed in Venetian Charm\r\n\r\nLocated just steps from iconic landmarks and hidden neighborhood gems, the retreat places guests at the crossroads of history and daily Venetian life. Morning walks along quiet canals, afternoons spent in local cafés, and evenings watching gondolas glide by are all part of the experience.\r\n\r\n## Thoughtful Comforts\r\n\r\nEvery space within Venice Retreat is crafted with intention, offering modern amenities while honoring the city’s historic roots. Guests can expect:\r\n\r\n- Comfortable, well-appointed rooms  \r\n- Elegant interiors inspired by Venetian design  \r\n- Peaceful common spaces for reading or conversation  \r\n- Easy access to cultural attractions and dining  \r\n\r\n## An Invitation to Slow Living\r\n\r\nVenice Retreat is more than a place to stay—it is an invitation to embrace a slower pace. Here, time feels unhurried, encouraging guests to savor each moment, whether enjoying a quiet breakfast, journaling by a window overlooking the canal, or simply listening to the rhythm of the city.\r\n\r\n## A Memorable Stay\r\n\r\nWhether visiting for a romantic getaway, a creative retreat, or a peaceful escape, Venice Retreat offers a setting that lingers in memory long after departure. It is a place where the spirit of Venice is felt not in grand gestures, but in subtle, beautiful moments.', 'Romantic getaway.', 0, '2025-01-01', 199, 4.8, 25, 1, 1, 1),
('Florence Suites', 'Elegant suites in the heart of Florence.', 'Artistic comfort.', 5, '2025-02-10', 249, 4.7, 30, 2, 2, 2),
('Zermatt Alpine Lodge', 'Cozy winter lodge in the Swiss Alps.', 'Winter paradise.', 10, '2025-03-05', 300, 4.9, 40, 3, 3, 3),
('Paris Elegance', 'Luxury boutique hotel in Paris.', 'City of love.', 0, '2025-01-15', 220, 4.6, 20, 2, 4, 4),
('Oslo Fjord Resort', 'Modern resort by the Oslo fjord.', 'Scandinavian style.', 15, '2025-04-01', 180, 4.5, 35, 4, 5, 5),
('Innsbruck Mountain Hotel', 'Alpine hotel near ski slopes.', 'Winter & adventure.', 20, '2025-03-12', 270, 4.8, 45, 3, 6, 6),
('Miami Beach Resort', 'Tropical beach resort in Miami.', 'Sun & sand.', 0, '2025-02-20', 199, 4.4, 50, 1, 7, 7),
('Sapporo Snow Inn', 'Perfect winter stay in Sapporo.', 'Ski and snow.', 10, '2025-03-18', 210, 4.7, 30, 3, 8, 8),
('Whistler Peak Hotel', 'Ski resort in Canada’s Rockies.', 'Snow adventure.', 5, '2025-04-05', 320, 4.9, 25, 3, 9, 9),
('Barcelona City Hotel', 'Modern hotel in the heart of Barcelona.', 'Culture & nightlife.', 0, '2025-01-28', 200, 4.3, 40, 2, 10, 10);

-- --------------------------------------------------------

--
-- Table structure for table `viesbutis_tag`
--

CREATE TABLE `viesbutis_tag` (
  `reiksme` varchar(40) COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `id` int NOT NULL,
  `fk_Tag` int NOT NULL,
  `fk_Viesbutis` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

--
-- Dumping data for table `viesbutis_tag`
--

INSERT INTO `viesbutis_tag` (`reiksme`, `id`, `fk_Tag`, `fk_Viesbutis`) VALUES
('luxury', 1, 1, 1),
('romantic', 2, 8, 1),
('boutique', 3, 7, 2),
('luxury', 4, 1, 2),
('ski-resort', 5, 5, 3),
('luxury', 6, 1, 3),
('city-center', 7, 4, 4),
('luxury', 8, 1, 4),
('fjord-view', 9, 3, 5),
('family-friendly', 10, 6, 5),
('ski-resort', 11, 5, 6),
('luxury', 12, 1, 6),
('beachfront', 13, 3, 7),
('family-friendly', 14, 6, 7),
('ski-resort', 15, 5, 8),
('luxury', 16, 1, 8),
('ski-resort', 17, 5, 9),
('luxury', 18, 1, 9),
('city-center', 19, 4, 10),
('boutique', 20, 7, 10);

-- --------------------------------------------------------

--
-- Table structure for table `vietove`
--

CREATE TABLE `vietove` (
  `salis` varchar(50) COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `miestas` varchar(30) COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `adresas` varchar(50) COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

--
-- Dumping data for table `vietove`
--

INSERT INTO `vietove` (`salis`, `miestas`, `adresas`, `id`) VALUES
('Italy', 'Venice', '123 Canal St', 1),
('Italy', 'Florence', '45 Renaissance Ave', 2),
('Switzerland', 'Zermatt', '12 Alpine Rd', 3),
('France', 'Paris', '78 Champs Elysees', 4),
('Norway', 'Oslo', '5 Fjord St', 5),
('Austria', 'Innsbruck', '22 Mountain Rd', 6),
('USA', 'Miami', '101 Ocean Drive', 7),
('Japan', 'Sapporo', '33 Snow St', 8),
('Canada', 'Whistler', '7 Ski Lane', 9),
('Spain', 'Barcelona', '9 Gaudi Blvd', 10);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `filtravimo_konfiguracija`
--
ALTER TABLE `filtravimo_konfiguracija`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `filtravimo_konfiguracijos_tag`
--
ALTER TABLE `filtravimo_konfiguracijos_tag`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `komentaras`
--
ALTER TABLE `komentaras`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `megstamiausias_viesbutis`
--
ALTER TABLE `megstamiausias_viesbutis`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nuotraukos`
--
ALTER TABLE `nuotraukos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `patvirtinimas`
--
ALTER TABLE `patvirtinimas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `rezervacija`
--
ALTER TABLE `rezervacija`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sezonas`
--
ALTER TABLE `sezonas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `vartotojas`
--
ALTER TABLE `vartotojas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vartotojo_istorija`
--
ALTER TABLE `vartotojo_istorija`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vartotoju_tipas`
--
ALTER TABLE `vartotoju_tipas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `vertinimas`
--
ALTER TABLE `vertinimas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `viesbutis`
--
ALTER TABLE `viesbutis`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `viesbutis_tag`
--
ALTER TABLE `viesbutis_tag`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `vietove`
--
ALTER TABLE `vietove`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
  ADD CONSTRAINT `atsako` FOREIGN KEY (`fk_Komentaras`) REFERENCES `komentaras` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT,
  ADD CONSTRAINT `komentaras_ibfk_1` FOREIGN KEY (`patvirtinimas`) REFERENCES `patvirtinimas` (`id`),
  ADD CONSTRAINT `komentaras_turi` FOREIGN KEY (`fk_Viesbutis`) REFERENCES `viesbutis` (`id`),
  ADD CONSTRAINT `pateikia` FOREIGN KEY (`fk_Vartotojas`) REFERENCES `vartotojas` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

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
