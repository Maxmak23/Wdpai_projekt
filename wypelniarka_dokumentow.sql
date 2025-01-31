-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 31 Sty 2025, 14:14
-- Wersja serwera: 10.4.21-MariaDB
-- Wersja PHP: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `wypelniarka_dokumentow`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `form_submissions`
--

CREATE TABLE `form_submissions` (
  `uniqueID` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `formName` varchar(255) NOT NULL,
  `formKey` varchar(255) NOT NULL,
  `formValue` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `form_submissions`
--

INSERT INTO `form_submissions` (`uniqueID`, `user_id`, `formName`, `formKey`, `formValue`) VALUES
(13, 1, 'rejestracja_pojazdu', 'rejestracja_pojazdu_data_miejscowosc', '\"Warszawa, 2024-12-14\"'),
(14, 1, 'rejestracja_pojazdu', 'rejestracja_pojazdu_miejscowosc', '\"Warszawa\"'),
(15, 1, 'rejestracja_pojazdu', 'rejestracja_pojazdu_nazwa_wlasciciela', '\"Jan Nowak Firma Stalbudpol\"'),
(16, 1, 'rejestracja_pojazdu', 'rejestracja_pojazdu_nabycie_zbycie', '\"0\"'),
(17, 3, 'wycinka_drzew', 'wycinka_drzew_data_miejscowosc', '\"Warszawa, 2025-01-09\"'),
(18, 3, 'rejestracja_pojazdu', 'rejestracja_pojazdu_data_miejscowosc', '\"Warszawa, 2025-01-09\"'),
(19, 3, 'rejestracja_pojazdu', 'rejestracja_pojazdu_miejscowosc', '\"Warszawa\"'),
(20, 3, 'rejestracja_pojazdu', 'rejestracja_pojazdu_nazwa_wlasciciela', '\"Jan Nowak Firma Stalbudpol\"'),
(21, 3, 'rejestracja_pojazdu', 'rejestracja_pojazdu_nabycie_zbycie', '\"0\"');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `role`) VALUES
(1, 'Kuba', '1', 1),
(2, 'Bartek', '1', 2),
(3, 'Adam', '1', 2),
(4, 'Marcin', '1', 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_documents_access`
--

CREATE TABLE `user_documents_access` (
  `user_id` int(11) NOT NULL,
  `document_key` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `user_documents_access`
--

INSERT INTO `user_documents_access` (`user_id`, `document_key`) VALUES
(2, 'rejestracja_pojazdu'),
(2, 'wydanie_dokumentow_szkolnych'),
(3, 'rejestracja_pojazdu'),
(3, 'wycinka_drzew'),
(3, 'wydanie_dokumentow_szkolnych');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `form_submissions`
--
ALTER TABLE `form_submissions`
  ADD PRIMARY KEY (`uniqueID`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `user_documents_access`
--
ALTER TABLE `user_documents_access`
  ADD PRIMARY KEY (`user_id`,`document_key`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `form_submissions`
--
ALTER TABLE `form_submissions`
  MODIFY `uniqueID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `user_documents_access`
--
ALTER TABLE `user_documents_access`
  ADD CONSTRAINT `user_documents_access_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
