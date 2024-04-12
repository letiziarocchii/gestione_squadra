-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Apr 12, 2024 alle 12:47
-- Versione del server: 10.4.28-MariaDB
-- Versione PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gestione_squadra`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `atleta`
--

CREATE TABLE `atleta` (
  `id` int(11) NOT NULL,
  `nome` varchar(30) DEFAULT NULL,
  `cognome` varchar(30) DEFAULT NULL,
  `data_nascita` date DEFAULT NULL,
  `ruolo` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dump dei dati per la tabella `atleta`
--

INSERT INTO `atleta` (`id`, `nome`, `cognome`, `data_nascita`, `ruolo`) VALUES
(13, 'letizia', 'rocchi', '2005-05-19', 'attaccante_banda'),
(14, 'asia', 'zanotti', '2005-04-20', 'attaccante_centrale'),
(16, 'sabrina', 'giorgi', '2002-10-04', 'palleggiatore'),
(17, 'giorgia', 'bianchi', '2006-04-21', 'attaccante_centrale'),
(18, 'jessica', 'franzoni', '2003-01-06', 'attaccante_opposto'),
(19, 'giada', 'resconi', '2002-12-04', 'attaccante_banda'),
(20, 'giada', 'scalvini', '2005-10-14', 'libero'),
(21, 'irene', 'passagno', '2005-06-15', 'attaccante_banda');

-- --------------------------------------------------------

--
-- Struttura della tabella `evento`
--

CREATE TABLE `evento` (
  `id` int(11) NOT NULL,
  `tipo` varchar(30) DEFAULT NULL,
  `data_ora_inizio` datetime DEFAULT NULL,
  `descrizione` varchar(100) DEFAULT NULL,
  `luogo` varchar(50) DEFAULT NULL,
  `durata` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dump dei dati per la tabella `evento`
--

INSERT INTO `evento` (`id`, `tipo`, `data_ora_inizio`, `descrizione`, `luogo`, `durata`) VALUES
(43, 'partita', '2024-04-10 21:00:00', 'volley torbole casaglia VS cusBrescia volley', 'Brescia', 90),
(44, 'partita', '2024-03-27 21:00:00', 'volley torbole casaglia VS Leno', 'Leno', 120),
(45, 'partita', '2024-03-22 21:00:00', 'volley torbole casaglia VS Valvolley', 'Villa Carcina', 90),
(46, 'partita', '2024-03-15 21:00:00', 'volley torbole casaglia VS Ponte Zanano', 'Torbole Casaglia', 80);

-- --------------------------------------------------------

--
-- Struttura della tabella `informazioni_mediche`
--

CREATE TABLE `informazioni_mediche` (
  `fkAtleta` int(11) NOT NULL,
  `data_ora_visita` datetime DEFAULT NULL,
  `tipo_infortunio` varchar(50) DEFAULT NULL,
  `descrizione` varchar(100) DEFAULT NULL,
  `altre_informazioni` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dump dei dati per la tabella `informazioni_mediche`
--

INSERT INTO `informazioni_mediche` (`fkAtleta`, `data_ora_visita`, `tipo_infortunio`, `descrizione`, `altre_informazioni`) VALUES
(13, '2024-04-03 00:00:00', 'calo di pressione', 'visita cardiologica ', '/');

-- --------------------------------------------------------

--
-- Struttura della tabella `partecipa`
--

CREATE TABLE `partecipa` (
  `id` int(11) NOT NULL,
  `fkAtleta` int(11) DEFAULT NULL,
  `fkEvento` int(11) DEFAULT NULL,
  `punti_segnati` int(11) DEFAULT NULL,
  `errori` int(11) DEFAULT NULL,
  `percentuale_successo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dump dei dati per la tabella `partecipa`
--

INSERT INTO `partecipa` (`id`, `fkAtleta`, `fkEvento`, `punti_segnati`, `errori`, `percentuale_successo`) VALUES
(31, 13, 43, 11, 10, 52),
(32, 14, 43, 4, 3, 57),
(33, 13, 44, 8, 8, 50);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `atleta`
--
ALTER TABLE `atleta`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `evento`
--
ALTER TABLE `evento`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `informazioni_mediche`
--
ALTER TABLE `informazioni_mediche`
  ADD PRIMARY KEY (`fkAtleta`);

--
-- Indici per le tabelle `partecipa`
--
ALTER TABLE `partecipa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fkAtleta` (`fkAtleta`),
  ADD KEY `fkEvento` (`fkEvento`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `atleta`
--
ALTER TABLE `atleta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT per la tabella `evento`
--
ALTER TABLE `evento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT per la tabella `partecipa`
--
ALTER TABLE `partecipa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `informazioni_mediche`
--
ALTER TABLE `informazioni_mediche`
  ADD CONSTRAINT `informazioni_mediche_ibfk_1` FOREIGN KEY (`fkAtleta`) REFERENCES `atleta` (`id`);

--
-- Limiti per la tabella `partecipa`
--
ALTER TABLE `partecipa`
  ADD CONSTRAINT `partecipa_ibfk_1` FOREIGN KEY (`fkAtleta`) REFERENCES `atleta` (`id`),
  ADD CONSTRAINT `partecipa_ibfk_2` FOREIGN KEY (`fkEvento`) REFERENCES `evento` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
