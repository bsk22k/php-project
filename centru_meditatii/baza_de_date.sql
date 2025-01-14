-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gazdă: 127.0.0.1
-- Timp de generare: ian. 14, 2025 la 03:32 PM
-- Versiune server: 10.4.32-MariaDB
-- Versiune PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Bază de date: `centru_meditatii`
--

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `admins`
--

INSERT INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin', 'parola123');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL,
  `subject_id` int(11) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `day` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `courses`
--

INSERT INTO `courses` (`id`, `teacher_id`, `subject_id`, `start_time`, `end_time`, `day`) VALUES
(60, 8, 65, '17:38:00', '17:36:00', 'Miercuri'),
(64, 8, 65, '18:45:00', '17:47:00', 'Duminică'),
(71, 8, 65, '19:04:00', '20:00:00', 'Luni'),
(74, 11, 79, '18:00:00', '20:00:00', 'Marți'),
(75, 11, 79, '18:26:00', '18:26:00', 'Luni');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `course_students`
--

CREATE TABLE `course_students` (
  `id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `course_students`
--

INSERT INTO `course_students` (`id`, `course_id`, `student_id`) VALUES
(24, 60, 4),
(29, 64, 4),
(30, 64, 5),
(52, 71, 3),
(53, 71, 4),
(54, 71, 5),
(55, 71, 6),
(56, 71, 7),
(57, 71, 8),
(58, 71, 9),
(62, 74, 4),
(63, 74, 8),
(64, 74, 9),
(65, 75, 5);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `students`
--

INSERT INTO `students` (`id`, `name`, `email`) VALUES
(3, 'Adrian', 'da@da.com'),
(4, 'Andrei', '21@21.com'),
(5, 'Anda', 'sda@sa.htn'),
(6, 'Carlos', '21@sa.cs'),
(7, 'Elena', 'el@s.sa'),
(8, 'Marius', 'sda@faf.jhg'),
(9, 'Bogdan', 'a@2.trt');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `subjects`
--

INSERT INTO `subjects` (`id`, `name`, `teacher_id`) VALUES
(65, 'Biologie', 8),
(69, 'Informatica', 2),
(72, 'Istorie', 9),
(73, 'Sport', 2),
(79, 'Chimie', 11);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `subject_teacher`
--

CREATE TABLE `subject_teacher` (
  `subject_id` int(11) NOT NULL,
  `teacher_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `subject_teacher`
--

INSERT INTO `subject_teacher` (`subject_id`, `teacher_id`) VALUES
(65, 8),
(69, 2),
(69, 8),
(69, 13),
(72, 3),
(72, 9),
(73, 2),
(79, 11);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `teachers`
--

INSERT INTO `teachers` (`id`, `name`, `email`) VALUES
(2, 'Daniel Spataru', 'bogdanbusuioc2003@gmail.com'),
(3, 'Marius Olandezu', 'dawd@fsa.fgn'),
(8, 'Alina Demeter', 'cdsvvs@fsdgsd.nht'),
(9, 'Ionut Lungu', 'fdsg@gdsg.mjy'),
(11, 'Dragos Voda', 'dragonasu@gmail.com'),
(12, 'Diana Predescu', 'calu123@gmail.com'),
(13, 'Ionel Ganea', 'saas@saaa.khg');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(3, 'user', 'user123'),
(6, 'anda', 'anda123'),
(7, 'bogdan', 'bogdan123'),
(8, 'useru', 'useru123'),
(9, '112', '112'),
(10, 'DANKE0101', '123');

--
-- Indexuri pentru tabele eliminate
--

--
-- Indexuri pentru tabele `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexuri pentru tabele `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `subject_id` (`subject_id`),
  ADD KEY `courses_ibfk_1` (`teacher_id`);

--
-- Indexuri pentru tabele `course_students`
--
ALTER TABLE `course_students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `course_id` (`course_id`),
  ADD KEY `student_id` (`student_id`);

--
-- Indexuri pentru tabele `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexuri pentru tabele `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexuri pentru tabele `subject_teacher`
--
ALTER TABLE `subject_teacher`
  ADD PRIMARY KEY (`subject_id`,`teacher_id`),
  ADD KEY `teacher_id` (`teacher_id`);

--
-- Indexuri pentru tabele `teachers`
--
ALTER TABLE `teachers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexuri pentru tabele `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT pentru tabele eliminate
--

--
-- AUTO_INCREMENT pentru tabele `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pentru tabele `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT pentru tabele `course_students`
--
ALTER TABLE `course_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT pentru tabele `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pentru tabele `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT pentru tabele `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pentru tabele `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constrângeri pentru tabele eliminate
--

--
-- Constrângeri pentru tabele `courses`
--
ALTER TABLE `courses`
  ADD CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `courses_ibfk_2` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE;

--
-- Constrângeri pentru tabele `course_students`
--
ALTER TABLE `course_students`
  ADD CONSTRAINT `course_students_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `course_students_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;

--
-- Constrângeri pentru tabele `subjects`
--
ALTER TABLE `subjects`
  ADD CONSTRAINT `subjects_ibfk_1` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;

--
-- Constrângeri pentru tabele `subject_teacher`
--
ALTER TABLE `subject_teacher`
  ADD CONSTRAINT `subject_teacher_ibfk_1` FOREIGN KEY (`subject_id`) REFERENCES `subjects` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `subject_teacher_ibfk_2` FOREIGN KEY (`teacher_id`) REFERENCES `teachers` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
