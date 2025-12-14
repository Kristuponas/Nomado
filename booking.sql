-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 14, 2025 at 08:22 PM
-- Server version: 8.0.43-0ubuntu0.24.04.2
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
  `sukurimo_data` date NOT NULL,
  `redagavimo_data` date NOT NULL,
  `patvirtinimas` int NOT NULL,
  `id` int NOT NULL,
  `fk_Komentaras` int DEFAULT NULL,
  `fk_Vartotojas` int NOT NULL,
  `fk_Viesbutis` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

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
  `pradzios_data` date NOT NULL,
  `pabaigos_data` date NOT NULL,
  `sukurimo_data` date NOT NULL,
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
('amenities', 'pet-friendly', 'hotel', 10),
('style', 'boutique', 'hotel', 11),
('style', 'luxury', 'hotel', 12),
('style', 'modern', 'hotel', 13),
('style', 'romantic', 'hotel', 14),
('location', 'city-center', 'hotel', 15),
('location', 'beachfront', 'hotel', 16),
('location', 'lakefront', 'hotel', 17),
('location', 'mountain', 'hotel', 18),
('amenities', 'spa', 'hotel', 19),
('amenities', 'pet-friendly', 'hotel', 20);

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
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

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
(3, 'unverified');

-- --------------------------------------------------------

--
-- Table structure for table `vertinimas`
--

CREATE TABLE `vertinimas` (
  `bendras` int NOT NULL,
  `svara` int NOT NULL,
  `lokacija` int NOT NULL,
  `patogumas` int NOT NULL,
  `komunikacija` int NOT NULL,
  `id` int NOT NULL,
  `fk_Komentaras` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

-- --------------------------------------------------------

--
-- Table structure for table `viesbutis`
--

CREATE TABLE `viesbutis` (
  `pavadinimas` varchar(50) COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `aprasymas` varchar(255) COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `trumpas_aprasymas` varchar(255) COLLATE utf8mb4_lithuanian_ci NOT NULL,
  `nuolaida` double NOT NULL,
  `sukurimo_data` date NOT NULL,
  `kaina` float NOT NULL,
  `reitingas` double NOT NULL,
  `kambariu_skaicius` int NOT NULL,
  `sezonas` int NOT NULL,
  `id` int NOT NULL,
  `fk_Vietove` int NOT NULL,
  `sveciu_skaicius` int NOT NULL DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

--
-- Dumping data for table `viesbutis`
--

INSERT INTO `viesbutis` (`pavadinimas`, `aprasymas`, `trumpas_aprasymas`, `nuolaida`, `sukurimo_data`, `kaina`, `reitingas`, `kambariu_skaicius`, `sezonas`, `id`, `fk_Vietove`, `sveciu_skaicius`) VALUES
('Venice Retreat', 'Luxury hotel along the canals of Venice.', 'Romantic getaway.', 0, '2025-01-01', 199, 4.8, 4, 1, 1, 1, 2),
('Florence Suites', 'Elegant suites in the heart of Florence.', 'Artistic comfort.', 5, '2025-02-10', 249, 4.7, 4, 2, 2, 2, 2),
('Zermatt Alpine Lodge', 'Cozy winter lodge in the Swiss Alps.', 'Winter paradise.', 10, '2025-03-05', 300, 4.9, 3, 3, 3, 3, 5),
('Paris Elegance', 'Luxury boutique hotel in Paris.', 'City of love.', 0, '2025-01-15', 220, 4.6, 2, 2, 4, 4, 5),
('Oslo Fjord Resort', 'Modern resort by the Oslo fjord.', 'Scandinavian style.', 15, '2025-04-01', 180, 4.5, 3, 4, 5, 5, 6),
('Innsbruck Mountain Hotel', 'Alpine hotel near ski slopes.', 'Winter & adventure.', 20, '2025-03-12', 270, 4.8, 4, 3, 6, 6, 3),
('Miami Beach Resort', 'Tropical beach resort in Miami.', 'Sun & sand.', 0, '2025-02-20', 199, 4.4, 3, 1, 7, 7, 5),
('Sapporo Snow Inn', 'Perfect winter stay in Sapporo.', 'Ski and snow.', 10, '2025-03-18', 210, 4.7, 3, 3, 8, 8, 5),
('Whistler Peak Hotel', 'Ski resort in Canada’s Rockies.', 'Snow adventure.', 5, '2025-04-05', 320, 4.9, 2, 3, 9, 9, 2),
('Barcelona City Hotel', 'Modern hotel in the heart of Barcelona.', 'Culture & nightlife.', 0, '2025-01-28', 200, 4.3, 2, 2, 10, 10, 4),
('Athens Paradise', 'Luxury hotel in the heart of Athens.', 'City center luxury.', 5, '2025-05-01', 220, 4.7, 4, 1, 11, 11, 4),
('Santorini Sunset', 'Romantic hotel with caldera view.', 'Romantic getaway.', 10, '2025-05-03', 350, 4.9, 2, 1, 12, 12, 2),
('Rome Imperial', 'Elegant suites near Colosseum.', 'Historic luxury.', 0, '2025-05-05', 280, 4.8, 3, 2, 13, 13, 4),
('Madrid Central', 'Modern hotel in downtown Madrid.', 'City style.', 5, '2025-05-07', 200, 4.5, 3, 2, 14, 14, 3),
('Lisbon Riverside', 'Hotel by the Tagus river.', 'Relaxing stay.', 0, '2025-05-09', 180, 4.3, 3, 2, 15, 15, 6),
('Amsterdam Canalside', 'Boutique hotel on canals.', 'Cozy & stylish.', 0, '2025-05-11', 210, 4.6, 4, 2, 16, 16, 6),
('Berlin Central', 'Luxury suites in Berlin.', 'Modern comfort.', 5, '2025-05-13', 230, 4.7, 2, 3, 17, 17, 4),
('Vienna Classic', 'Elegant hotel near Ring.', 'Historic elegance.', 10, '2025-05-15', 250, 4.8, 3, 3, 18, 18, 2),
('Nice Beachfront', 'Hotel with Mediterranean view.', 'Seaside luxury.', 15, '2025-05-17', 300, 4.9, 2, 1, 19, 19, 6),
('Lyon Central', 'Modern boutique hotel.', 'City getaway.', 0, '2025-05-19', 190, 4.4, 2, 2, 20, 20, 3),
('London Royal', 'Luxury suites near Big Ben.', 'Classic London stay.', 5, '2025-05-21', 330, 4.8, 4, 1, 21, 21, 4),
('Edinburgh Castle View', 'Historic hotel with castle view.', 'Historic charm.', 10, '2025-05-23', 240, 4.6, 4, 2, 22, 22, 5),
('Geneva Lakefront', 'Luxury hotel on lake.', 'Relaxing luxury.', 15, '2025-05-25', 360, 4.9, 4, 1, 23, 23, 6),
('Zurich Central', 'Boutique hotel in Zurich.', 'Modern comfort.', 0, '2025-05-27', 270, 4.7, 4, 3, 24, 24, 2),
('New York Skyline', 'Luxury hotel with skyline view.', 'City luxury.', 20, '2025-05-29', 400, 4.9, 4, 1, 25, 25, 2),
('Los Angeles Sunset', 'Modern hotel in LA.', 'Stylish & cozy.', 10, '2025-05-30', 350, 4.7, 2, 2, 26, 26, 3),
('Toronto Downtown', 'Elegant hotel in Toronto.', 'City comfort.', 0, '2025-06-01', 220, 4.5, 4, 2, 27, 27, 2),
('Montreal Old Town', 'Historic boutique hotel.', 'Classic style.', 5, '2025-06-03', 200, 4.4, 4, 2, 28, 28, 4),
('Tokyo Central', 'Modern hotel in Shibuya.', 'City life.', 0, '2025-06-05', 280, 4.6, 2, 3, 29, 29, 3),
('Kyoto Garden', 'Traditional hotel near temples.', 'Peaceful stay.', 10, '2025-06-07', 240, 4.7, 3, 3, 30, 30, 3);

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
('boutique', 20, 7, 10),
('boutique', 41, 11, 11),
('luxury', 42, 12, 11),
('spa', 43, 19, 11),
('romantic', 44, 14, 12),
('beachfront', 45, 16, 12),
('luxury', 46, 12, 12),
('luxury', 47, 12, 13),
('modern', 48, 13, 13),
('modern', 49, 13, 14),
('city-center', 50, 15, 14),
('luxury', 51, 12, 15),
('spa', 52, 19, 15),
('boutique', 53, 11, 16),
('modern', 54, 13, 16),
('pet-friendly', 55, 20, 16),
('modern', 56, 13, 17),
('luxury', 57, 12, 17),
('luxury', 58, 12, 18),
('spa', 59, 19, 18),
('romantic', 60, 14, 18),
('beachfront', 61, 16, 19),
('luxury', 62, 12, 19),
('boutique', 63, 11, 20),
('modern', 64, 13, 20),
('luxury', 65, 12, 21),
('modern', 66, 13, 21),
('spa', 67, 19, 21),
('romantic', 68, 14, 22),
('luxury', 69, 12, 22),
('lakefront', 70, 17, 23),
('luxury', 71, 12, 23),
('modern', 72, 13, 24),
('luxury', 73, 12, 24),
('luxury', 74, 12, 25),
('modern', 75, 13, 25),
('spa', 76, 19, 25),
('modern', 77, 13, 26),
('luxury', 78, 12, 26),
('city-center', 79, 15, 27),
('luxury', 80, 12, 27),
('boutique', 81, 11, 28),
('modern', 82, 13, 28),
('modern', 83, 13, 29),
('luxury', 84, 12, 29),
('romantic', 85, 14, 30),
('spa', 86, 19, 30),
('luxury', 87, 12, 30);

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
('Spain', 'Barcelona', '9 Gaudi Blvd', 10),
('Greece', 'Athens', '12 Acropolis St', 11),
('Greece', 'Santorini', '34 Sunset Blvd', 12),
('Italy', 'Rome', '56 Colosseum Ave', 13),
('Spain', 'Madrid', '78 Royal Plaza', 14),
('Portugal', 'Lisbon', '90 Alfama Rd', 15),
('Netherlands', 'Amsterdam', '22 Canal Rd', 16),
('Germany', 'Berlin', '44 Brandenburg St', 17),
('Austria', 'Vienna', '11 Ring St', 18),
('France', 'Nice', '33 Promenade Ave', 19),
('France', 'Lyon', '55 Old Town St', 20),
('UK', 'London', '1 Big Ben St', 21),
('UK', 'Edinburgh', '3 Castle Rd', 22),
('Switzerland', 'Geneva', '7 Lake View St', 23),
('Switzerland', 'Zurich', '9 Bahnhofstrasse', 24),
('USA', 'New York', '100 Broadway', 25),
('USA', 'Los Angeles', '200 Sunset Blvd', 26),
('Canada', 'Toronto', '50 Queen St', 27),
('Canada', 'Montreal', '60 St. Catherine St', 28),
('Japan', 'Tokyo', '10 Shibuya St', 29),
('Japan', 'Kyoto', '20 Gion St', 30);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sezonas`
--
ALTER TABLE `sezonas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tag`
--
ALTER TABLE `tag`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `vartotojas`
--
ALTER TABLE `vartotojas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vartotojo_istorija`
--
ALTER TABLE `vartotojo_istorija`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vartotoju_tipas`
--
ALTER TABLE `vartotoju_tipas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `vertinimas`
--
ALTER TABLE `vertinimas`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `viesbutis`
--
ALTER TABLE `viesbutis`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `viesbutis_tag`
--
ALTER TABLE `viesbutis_tag`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `vietove`
--
ALTER TABLE `vietove`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

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
