-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 19, 2024 at 03:22 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stes`
--

-- --------------------------------------------------------

--
-- Table structure for table `applicants`
--

CREATE TABLE `applicants` (
  `form_id` int NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `existence` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `program_name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT '-',
  `location` varchar(255) COLLATE utf8mb4_general_ci DEFAULT '-',
  `reason` varchar(255) COLLATE utf8mb4_general_ci DEFAULT '-',
  `organizer` varchar(255) COLLATE utf8mb4_general_ci DEFAULT '-',
  `time_leave` time NOT NULL,
  `time_back` time NOT NULL,
  `start_date` date NOT NULL,
  `final_date` date NOT NULL,
  `evidence` varchar(255) COLLATE utf8mb4_general_ci DEFAULT '-',
  `leave_type` varchar(200) COLLATE utf8mb4_general_ci DEFAULT '-'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `applicants`
--

INSERT INTO `applicants` (`form_id`, `user_id`, `name`, `existence`, `program_name`, `location`, `reason`, `organizer`, `time_leave`, `time_back`, `start_date`, `final_date`, `evidence`, `leave_type`) VALUES
(1, 1, 'Muhammad Taufiq Bin Mohd Nizam', 'Absent', '', '', 'Demam', '-', '07:13:00', '13:33:00', '2023-10-18', '2023-10-18', 'uploads/RESUME_TAUFIQ_F1049.pdf', '-'),
(2, 1, 'Muhammad Taufiq Bin Mohd Nizam', 'Emergency', '-', '', 'Nenek tidak sihat', '-', '07:44:00', '01:44:00', '2023-10-20', '2023-10-20', 'uploads/RESUME_TAUFIQ_F1049.pdf', '-'),
(3, 1, 'Muhammad Taufiq Bin Mohd Nizam', 'Official Business', 'Kursus Kerja', 'Pontian', '-', 'MDP', '07:46:00', '17:46:00', '2023-11-02', '2023-11-02', 'uploads/RESUME_TAUFIQ_F1049.pdf', '-'),
(12, 1, 'Muhammad Taufiq Bin Mohd Nizam', 'Official Business', 'Kursus Kerja', 'hihi', '-', 'MDP', '07:54:00', '08:54:00', '2023-10-30', '2023-11-11', 'uploads/borangjawapan_25DDT21F1049.pdf', '-'),
(13, 1, 'Muhammad Taufiq Bin Mohd Nizam', 'Absent', '-', '', 'Demam', '-', '09:08:00', '13:00:00', '2023-11-03', '2023-11-30', 'uploads/WIN_20220926_11_39_14_Pro.jpg', '-'),
(15, 1, 'Muhammad Taufiq Bin Mohd Nizam', 'Absent', '-', '', 'malas', '-', '08:33:00', '10:33:00', '2023-11-04', '2023-11-04', 'uploads/WIN_20220926_11_39_14_Pro.jpg', '-'),
(17, 3, 'Farah Hanis Binti Azaman', 'Cuti Lain', '-', '', 'Hari Raya ', '-', '17:18:00', '05:20:00', '2023-11-07', '2023-11-24', 'uploads/LAB TASK 1_ 25DDT21F1023 (1).pdf', '-'),
(18, 3, 'Farah Hanis Binti Azaman', 'Absent', '-', '', 'Sakit Perut', '-', '07:23:00', '20:30:00', '2023-11-08', '2023-11-10', 'uploads/PBE1_25DDT21F1023 (1).pdf', '-'),
(19, 3, 'Farah Hanis Binti Azaman', 'CRK', '-', '', '', '-', '07:00:00', '19:00:00', '2023-11-08', '2023-11-15', 'uploads/ilovepdf_merged.pdf', '-'),
(20, 3, 'Farah Hanis Binti Azaman', 'Haji Umrah', '-', '', '', '-', '09:00:00', '08:00:00', '2023-11-12', '2023-11-26', 'uploads/PBE1_25DDT21F1023 (1).pdf', '-'),
(21, 3, 'Farah Hanis Binti Azaman', 'Bersalin', '-', '', '', '-', '07:00:00', '07:00:00', '2023-11-01', '2024-01-01', 'uploads/Borang Jawapan LI.pdf', '-'),
(22, 3, 'Farah Hanis Binti Azaman', 'Keberadaan Jam ', '-', '', 'Hantar anak pergi hospital', '-', '09:00:00', '11:00:00', '2023-11-08', '2023-11-08', 'uploads/PBE1_25DDT21F1023 (1).pdf', '-'),
(23, 3, 'Farah Hanis Binti Azaman', 'Haji Umrah', '-', '', '', '-', '08:00:00', '07:00:00', '2023-11-07', '2023-12-19', 'uploads/PBT 1 F1023_F1025.pdf', '-'),
(24, 3, 'Farah Hanis Binti Azaman', 'Keberadaan Jam', '-', '', 'Pergi Sekolah Anak ', '-', '09:00:00', '10:00:00', '2023-11-08', '2023-11-08', 'uploads/RESUME FARAH HANIS BINTI AZAMAN.pdf', '-'),
(25, 3, 'Farah Hanis Binti Azaman', 'Keberadaan Jam', '-', '', 'Medical Checkup ', '-', '11:00:00', '12:00:00', '2023-11-08', '2023-11-08', 'uploads/Rubric_LT2_25DDT21F1023.pdf', '-'),
(26, 3, 'Farah Hanis Binti Azaman', 'Others', '-', '', 'Medical Checkup ', '-', '11:00:00', '12:00:00', '2023-11-08', '2023-11-08', 'uploads/Rubric_LT2_25DDT21F1023.pdf', '-'),
(27, 3, 'Farah Hanis Binti Azaman', 'Cuti Bersalin', '-', '', '', '-', '10:00:00', '08:00:00', '2023-11-08', '2024-01-08', 'uploads/PROBLEM BASED TASK 1_F1037_F1023.pdf', '-'),
(28, 3, 'Farah Hanis Binti Azaman', 'Haji Umrah', '-', '', '', '-', '06:00:00', '07:00:00', '2023-11-08', '2023-11-22', 'uploads/ilovepdf_merged.pdf', '-'),
(41, 1, 'Muhammad Taufiq Bin Mohd Nizam', 'Absent', '-', '', 'Demam', '-', '22:01:00', '23:01:00', '2023-11-15', '2023-11-15', '-', '-'),
(42, 2, 'Siti Ra\'biah Binti Abdul Jabbar', 'Absent', '-', '', 'Demam', '-', '22:01:00', '23:01:00', '2023-11-15', '2023-11-15', '-', '-'),
(43, 3, 'Farah Hanis Binti Azaman', 'Absent', '-', '', 'Demam', '-', '22:01:00', '23:01:00', '2023-11-15', '2023-11-15', '-', '-'),
(44, 1, 'Muhammad Taufiq Bin Mohd Nizam', 'Official Business', 'Kursus Kerja', 'Pontian', '-', 'MDP', '22:02:00', '23:02:00', '2023-11-15', '2023-11-15', 'uploads/PROJECT.pdf', '-'),
(45, 2, 'Siti Ra\'biah Binti Abdul Jabbar', 'Official Business', 'Kursus Kerja', 'Pontian', '-', 'MDP', '22:02:00', '23:02:00', '2023-11-15', '2023-11-15', 'uploads/PROJECT.pdf', '-'),
(46, 3, 'Farah Hanis Binti Azaman', 'Official Business', 'Kursus Kerja', 'Pontian', '-', 'MDP', '22:02:00', '23:02:00', '2023-11-15', '2023-11-15', 'uploads/PROJECT.pdf', '-'),
(47, 1, 'Muhammad Taufiq Bin Mohd Nizam', 'Cuti Lain', '-', '', 'Demam', '-', '22:03:00', '23:03:00', '2023-11-15', '2023-11-15', '-', '-'),
(48, 2, 'Siti Ra\'biah Binti Abdul Jabbar', 'Cuti Lain', '-', '', 'Demam', '-', '22:03:00', '23:03:00', '2023-11-15', '2023-11-15', '-', '-'),
(49, 3, 'Farah Hanis Binti Azaman', 'Cuti Lain', '-', '', 'Demam', '-', '22:03:00', '23:03:00', '2023-11-15', '2023-11-15', '-', '-'),
(50, 1, 'Muhammad Taufiq Bin Mohd Nizam', 'CRK', '-', '', '-', '-', '22:07:00', '23:07:00', '2023-11-15', '2023-11-15', '-', '-'),
(51, 2, 'Siti Ra\'biah Binti Abdul Jabbar', 'CRK', '-', '', '-', '-', '22:07:00', '23:07:00', '2023-11-15', '2023-11-15', '-', '-'),
(52, 3, 'Farah Hanis Binti Azaman', 'CRK', '-', '', '-', '-', '22:07:00', '23:07:00', '2023-11-15', '2023-11-15', '-', '-'),
(53, 1, 'Muhammad Taufiq Bin Mohd Nizam', 'Cuti Lain', '-', '', '-', '-', '22:00:00', '23:30:00', '2023-11-15', '2023-11-15', '-', 'hehehehe'),
(54, 2, 'Siti Ra\'biah Binti Abdul Jabbar', 'Cuti Lain', '-', '', '-', '-', '22:00:00', '23:30:00', '2023-11-15', '2023-11-15', '-', 'hehehehe'),
(55, 3, 'Farah Hanis Binti Azaman', 'Cuti Lain', '-', '', '-', '-', '22:00:00', '23:30:00', '2023-11-15', '2023-11-15', '-', 'hehehehe'),
(56, 1, 'Muhammad Taufiq Bin Mohd Nizam', 'Official Business', 'Csr', 'Smk Mersing', '-', 'PPD Mersing ', '08:30:00', '17:01:00', '2023-11-18', '2023-11-19', 'uploads/STES POSTER FYP.pdf', '-'),
(57, 2, 'Siti Ra\'biah Binti Abdul Jabbar', 'Official Business', 'Csr', 'Smk Mersing', '-', 'PPD Mersing ', '08:30:00', '17:01:00', '2023-11-18', '2023-11-19', 'uploads/STES POSTER FYP.pdf', '-'),
(58, 3, 'Farah Hanis Binti Azaman', 'Official Business', 'Csr', 'Smk Mersing', '-', 'PPD Mersing ', '08:30:00', '17:01:00', '2023-11-18', '2023-11-19', 'uploads/STES POSTER FYP.pdf', '-'),
(60, 1, 'Muhammad Taufiq Bin Mohd Nizam', 'Official Business', 'Kursus Pengawas peperiksaan', 'SMK Batu Pahat', '-', 'PPD Batu Pahat', '08:00:00', '17:11:00', '2023-11-20', '2023-11-21', 'uploads/STES POSTER FYP.pdf', '-'),
(61, 2, 'Siti Ra\'biah Binti Abdul Jabbar', 'Official Business', 'Kursus Pengawas peperiksaan', 'SMK Batu Pahat', '-', 'PPD Batu Pahat', '08:00:00', '17:11:00', '2023-11-20', '2023-11-21', 'uploads/STES POSTER FYP.pdf', '-'),
(62, 3, 'Farah Hanis Binti Azaman', 'Official Business', 'Kursus Pengawas peperiksaan', 'SMK Batu Pahat', '-', 'PPD Batu Pahat', '08:00:00', '17:11:00', '2023-11-20', '2023-11-21', 'uploads/STES POSTER FYP.pdf', '-'),
(76, 1, 'Muhammad Taufiq Bin Mohd Nizam', 'Official Business', 'Kursus CSR', 'Pontian, Johor', '-', 'MDP', '08:31:00', '14:25:00', '2023-11-24', '2023-11-24', 'uploads/Lab Task 4 - Question.pdf', '-'),
(77, 2, 'Siti Rabi\'ah Binti Abdul Jabbar', 'Official Business', 'Kursus CSR', 'Pontian, Johor', '-', 'MDP', '08:31:00', '14:25:00', '2023-11-24', '2023-11-24', 'uploads/Lab Task 4 - Question.pdf', '-'),
(78, 3, 'Farah Hanis Binti Azaman', 'Official Business', 'Kursus CSR', 'Pontian, Johor', '-', 'MDP', '08:31:00', '14:25:00', '2023-11-24', '2023-11-24', 'uploads/Lab Task 4 - Question.pdf', '-'),
(80, 1, 'Muhammad Taufiq Bin Mohd Nizam', 'Official Business', 'Kursus Kepimpinan', 'Kem Terendak', '-', 'PPD Mersing', '06:30:00', '18:00:00', '2023-11-26', '2023-11-26', 'uploads/PE2.pdf', '-'),
(81, 2, 'Siti Rabi\'ah Binti Abdul Jabbar', 'Official Business', 'Kursus Kepimpinan', 'Kem Terendak', '-', 'PPD Mersing', '06:30:00', '18:00:00', '2023-11-26', '2023-11-26', 'uploads/PE2.pdf', '-'),
(82, 3, 'Farah Hanis Binti Azaman', 'Official Business', 'Kursus Kepimpinan', 'Kem Terendak', '-', 'PPD Mersing', '06:30:00', '18:00:00', '2023-11-26', '2023-11-26', 'uploads/PE2.pdf', '-'),
(86, 1, 'Muhammad Taufiq Bin Mohd Nizam', 'Official Business', 'Kursus Kepimpinan', 'Kem Terendak', '-', 'PPD Mersing', '06:30:00', '18:00:00', '2023-11-25', '2023-11-25', 'uploads/PE2.pdf', '-'),
(87, 2, 'Siti Rabi\'ah Binti Abdul Jabbar', 'Official Business', 'Kursus Kepimpinan', 'Kem Terendak', '-', 'PPD Mersing', '06:30:00', '18:00:00', '2023-11-25', '2023-11-25', 'uploads/PE2.pdf', '-'),
(88, 3, 'Farah Hanis Binti Azaman', 'Official Business', 'Kursus Kepimpinan', 'Kem Terendak', '-', 'PPD Mersing', '06:30:00', '18:00:00', '2023-11-25', '2023-11-25', 'uploads/PE2.pdf', '-'),
(93, 3, 'Farah Aminah', 'Emergency', '-', '', 'Hantar anak pergi hospital', '-', '12:10:00', '13:10:00', '2023-11-25', '2023-11-25', '-', '-'),
(94, 1, 'Muhammad Taufiq Bin Mohd Nizam', 'Absent', '-', '', 'Demam', '-', '07:37:00', '08:38:00', '2023-11-27', '2023-11-27', '-', '-'),
(95, 2, 'Siti Rabi\'ah Binti Abdul Jabbar', 'Absent', '-', '', 'Demam', '-', '07:37:00', '08:38:00', '2023-11-27', '2023-11-27', '-', '-'),
(96, 3, 'Farah Aminah', 'Absent', '-', '', 'Demam', '-', '07:37:00', '08:38:00', '2023-11-27', '2023-11-27', '-', '-'),
(97, 1, 'Muhammad Taufiq Bin Mohd Nizam', 'Absent', '-', '', 'Demam', '-', '07:37:00', '08:38:00', '2023-11-27', '2023-11-27', '-', '-'),
(98, 2, 'Siti Rabi\'ah Binti Abdul Jabbar', 'Absent', '-', '', 'Demam', '-', '07:37:00', '08:38:00', '2023-11-27', '2023-11-27', '-', '-'),
(99, 3, 'Farah Aminah', 'Absent', '-', '', 'Demam', '-', '07:37:00', '08:38:00', '2023-11-27', '2023-11-27', '-', '-'),
(100, 1, 'Muhammad Taufiq Bin Mohd Nizam', 'Official Business', 'Kursus Peperiksaan', 'PPD Mersing', '-', 'PPD Mersing', '08:00:00', '14:00:00', '2023-11-27', '2023-11-27', 'uploads/CS_ipt.pdf', '-'),
(106, 3, 'Farah Aminah', 'Absent', '-', '', 'Balik Kampung', '-', '23:55:00', '17:00:00', '2023-11-27', '2023-11-29', '-', '-'),
(107, 3, 'Farah Aminah', 'Emergency', '-', '', 'Kes kematian', '-', '08:15:00', '06:00:00', '2023-11-28', '2023-11-29', '-', '-'),
(110, 3, 'Farah Aminah', 'Absent', '-', '', 'sakit mata', '-', '09:14:00', '07:00:00', '2023-11-28', '2023-11-30', '-', '-'),
(112, 2, 'Siti Rabi\'ah Binti Abdul Jabbar', 'Official Business', 'Kursus CSR', 'Pontian, Johor', '-', 'Sukarelawan Pontian', '10:07:00', '17:07:00', '2023-11-28', '2023-11-28', 'uploads/Program Luar.pdf', '-'),
(113, 3, 'Farah Aminah', 'Official Business', 'Kursus CSR', 'Pontian, Johor', '-', 'Sukarelawan Pontian', '10:07:00', '17:07:00', '2023-11-28', '2023-11-28', 'uploads/Program Luar.pdf', '-'),
(115, 2, 'Siti Rabi\'ah Binti Abdul Jabbar', 'Official Business', 'Kursus CSR', 'Pontian, Johor', '-', 'MDP', '10:46:00', '17:46:00', '2023-11-28', '2023-11-28', 'uploads/Program Luar.pdf', '-'),
(116, 3, 'Farah Aminah', 'Official Business', 'Kursus CSR', 'Pontian, Johor', '-', 'MDP', '10:46:00', '17:46:00', '2023-11-28', '2023-11-28', 'uploads/Program Luar.pdf', '-'),
(117, 3, 'Farah Aminah', 'Official Business', 'Kursus CSR', 'Pontian, Johor', '-', 'MDP', '11:26:00', '17:26:00', '2023-11-28', '2023-11-28', 'uploads/Program Luar.pdf', '-'),
(118, 589, 'Siti Rabi\'ah Binti Abdul Jabbar', 'Official Business', 'Kursus CSR', 'Pontian, Johor', '-', 'MDP', '11:26:00', '17:26:00', '2023-11-28', '2023-11-28', 'uploads/Program Luar.pdf', '-'),
(120, 3, 'Farah Aminah', 'Cuti Bersalin', '-', '', '-', '-', '12:40:00', '06:00:00', '2023-11-28', '2024-02-28', '-', '-'),
(121, 2, 'Siti Rabi\'ah Binti Abdul Jabbar', 'Absent', '-', '', 'demam', '-', '14:38:00', '06:17:00', '2023-11-28', '2023-11-29', '-', '-'),
(122, 3, 'Farah Aminah', 'Keberadaan Jam', '-', '', '-', '-', '14:52:00', '15:52:00', '2023-11-28', '2023-11-28', '-', '-'),
(123, 3, 'Farah Aminah', 'Absent', '-', '', 'Pergi hospital', '-', '17:12:00', '07:00:00', '2023-11-28', '2023-11-28', '-', '-'),
(124, 3, 'Farah Aminah', 'Emergency', '-', '', 'kematian', '-', '07:15:00', '09:20:00', '2023-11-28', '2023-11-28', '-', '-'),
(125, 614, 'Nurin Yusrina', 'CRK', '-', '', '-', '-', '22:20:00', '21:20:00', '2023-12-05', '2024-12-31', '-', '-'),
(126, 1, 'Taufiq Bin Nizam', 'Official Business', 'Program Csr', 'Pontian, Johor', '-', 'MDP', '08:31:00', '05:31:00', '2023-12-13', '2023-12-13', 'uploads/IMG_20231128_080209_324.jpg', '-'),
(127, 3, 'Farah Aminah', 'Official Business', 'Program Csr', 'Pontian, Johor', '-', 'MDP', '08:31:00', '05:31:00', '2023-12-13', '2023-12-13', 'uploads/IMG_20231128_080209_324.jpg', '-'),
(128, 1, 'Taufiq Bin Nizam', 'Official Business', 'Program Csr', 'Pontian, Johor', '-', 'MDP', '08:33:00', '05:33:00', '2023-12-12', '2023-12-12', 'uploads/IMG_20231128_080215_002.jpg', '-'),
(129, 3, 'Farah Aminah', 'Official Business', 'Program Csr', 'Pontian, Johor', '-', 'MDP', '08:33:00', '05:33:00', '2023-12-12', '2023-12-12', 'uploads/IMG_20231128_080215_002.jpg', '-');

-- --------------------------------------------------------

--
-- Table structure for table `dashboard`
--

CREATE TABLE `dashboard` (
  `id` int NOT NULL,
  `absent_teacher_count` int NOT NULL,
  `official_business_teacher_count` int NOT NULL,
  `emergency_teacher_count` int NOT NULL,
  `crk_teacher_count` int NOT NULL,
  `cuti_lain_count` int NOT NULL,
  `cuti_bersalin_count` int NOT NULL,
  `cuti_hajiUmrah_count` int NOT NULL,
  `keberadaan_jam_count` int NOT NULL,
  `total_person_count` int NOT NULL,
  `date` date NOT NULL DEFAULT '1970-01-01',
  `last_updated` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dashboard`
--

INSERT INTO `dashboard` (`id`, `absent_teacher_count`, `official_business_teacher_count`, `emergency_teacher_count`, `crk_teacher_count`, `cuti_lain_count`, `cuti_bersalin_count`, `cuti_hajiUmrah_count`, `keberadaan_jam_count`, `total_person_count`, `date`, `last_updated`) VALUES
(12, 3, 5, 1, 3, 1, 0, 0, 1, 9, '2023-10-28', '2023-11-03 23:56:36'),
(13, 2, 7, 8, 2, 4, 2, 5, 4, 17, '2023-10-29', '2023-11-04 05:16:52'),
(14, 3, 2, 5, 7, 5, 2, 5, 7, 10, '2023-10-30', '2023-11-04 05:17:13'),
(15, 3, 9, 1, 0, 0, 2, 0, 0, 13, '2023-11-01', '2023-11-04 05:17:38'),
(16, 2, 2, 4, 0, 0, 0, 0, 0, 8, '2023-11-02', '2023-11-04 05:17:58'),
(17, 1, 3, 5, 4, 7, 9, 2, 5, 9, '2023-11-03', '2023-11-04 05:18:09'),
(18, 4, 2, 8, 0, 0, 0, 0, 0, 14, '2023-10-31', '2023-11-04 05:18:29'),
(19, 3, 1, 1, 0, 0, 0, 0, 0, 5, '2023-11-04', '2023-11-04 06:57:25'),
(20, 2, 1, 1, 0, 0, 0, 0, 0, 4, '2023-11-05', '2023-11-05 07:38:04'),
(21, 1, 1, 1, 0, 0, 0, 0, 0, 3, '2023-11-06', '2023-11-05 09:18:30'),
(22, 1, 1, 1, 0, 0, 0, 0, 0, 3, '2023-11-07', '2023-11-07 07:24:11'),
(23, 7, 5, 10, 6, 2, 7, 4, 3, 3, '2023-01-08', '2023-11-07 08:21:14'),
(24, 5, 9, 1, 2, 3, 23, 8, 7, 3, '2023-02-08', '2023-11-07 09:55:05'),
(25, 4, 2, 4, 2, 6, 3, 9, 1, 3, '2023-03-08', '2023-11-07 09:57:11'),
(26, 9, 1, 3, 5, 10, 22, 12, 1, 3, '2023-04-08', '2023-11-07 09:58:00'),
(27, 3, 6, 2, 7, 20, 6, 15, 2, 3, '2023-05-08', '2023-11-07 09:58:29'),
(28, 1, 4, 9, 2, 10, 14, 3, 9, 3, '2023-06-08', '2023-11-07 09:58:55'),
(29, 10, 5, 15, 5, 1, 8, 2, 10, 3, '2023-07-08', '2023-11-07 09:59:27'),
(30, 4, 1, 7, 2, 12, 8, 4, 6, 3, '2023-08-08', '2023-11-07 10:00:31'),
(31, 3, 3, 3, 9, 2, 10, 5, 1, 3, '2023-09-08', '2023-11-07 10:01:02'),
(32, 1, 1, 1, 6, 23, 6, 9, 6, 3, '2023-09-09', '2023-11-07 10:01:37'),
(33, 2, 1, 1, 1, 1, 1, 2, 2, 11, '2023-11-08', '2023-11-08 07:26:14'),
(34, 1, 0, 1, 1, 1, 1, 3, 0, 8, '2023-11-13', '2023-11-13 15:01:00'),
(35, 1, 0, 1, 1, 1, 1, 3, 0, 8, '2023-11-14', '2023-11-14 09:06:17'),
(36, 4, 0, 1, 1, 1, 1, 3, 0, 11, '2023-11-15', '2023-11-15 13:26:13'),
(37, 4, 4, 2, 0, 1, 1, 3, 0, 15, '2023-11-18', '2023-11-18 15:56:47'),
(38, 4, 4, 2, 0, 1, 1, 3, 0, 15, '2023-11-19', '2023-11-19 15:20:49'),
(39, 4, 3, 1, 0, 1, 1, 3, 0, 13, '2023-11-20', '2023-11-20 12:13:59'),
(40, 2, 0, 1, 0, 1, 1, 3, 0, 8, '2023-11-22', '2023-11-22 15:49:19'),
(41, 1, 0, 1, 0, 1, 1, 2, 0, 6, '2023-11-23', '2023-11-23 15:45:47'),
(42, 2, 3, 1, 1, 1, 1, 2, 0, 11, '2023-11-24', '2023-11-24 09:46:14'),
(43, 1, 6, 2, 0, 0, 1, 2, 0, 12, '2023-11-25', '2023-11-25 15:13:06'),
(44, 1, 6, 0, 0, 0, 1, 2, 0, 10, '2023-11-26', '2023-11-26 10:27:31'),
(45, 8, 1, 0, 0, 0, 1, 1, 0, 11, '2023-11-27', '2023-11-27 15:56:13'),
(46, 5, 9, 2, 0, 0, 1, 1, 3, 21, '2023-11-28', '2023-11-28 15:53:07'),
(47, 4, 0, 1, 0, 0, 1, 1, 0, 7, '2023-11-29', '2023-11-29 15:24:34'),
(48, 2, 0, 0, 0, 0, 1, 1, 0, 4, '2023-11-30', '2023-11-30 15:46:14'),
(49, 0, 0, 0, 0, 0, 1, 1, 0, 2, '2023-12-01', '2023-12-01 15:03:25'),
(50, 0, 0, 0, 0, 0, 1, 1, 0, 2, '2023-12-02', '2023-12-02 15:04:00'),
(51, 0, 0, 0, 0, 0, 1, 1, 0, 2, '2023-12-03', '2023-12-03 15:42:58'),
(52, 0, 0, 0, 0, 0, 1, 1, 0, 2, '2023-12-04', '2023-12-04 15:04:43'),
(53, 0, 0, 0, 1, 0, 1, 1, 0, 3, '2023-12-05', '2023-12-05 15:58:27'),
(54, 0, 0, 0, 1, 0, 1, 1, 0, 3, '2023-12-06', '2023-12-06 15:31:37'),
(55, 0, 0, 0, 1, 0, 1, 1, 0, 3, '2023-12-07', '2023-12-07 15:45:31'),
(56, 0, 0, 0, 1, 0, 1, 1, 0, 3, '2023-12-08', '2023-12-08 15:11:39'),
(57, 0, 0, 0, 1, 0, 1, 1, 0, 3, '2023-12-09', '2023-12-09 15:57:07'),
(58, 0, 0, 0, 1, 0, 1, 1, 0, 3, '2023-12-10', '2023-12-10 15:37:35'),
(59, 0, 0, 0, 1, 0, 1, 1, 0, 3, '2023-12-11', '2023-12-11 15:45:11'),
(60, 0, 2, 0, 1, 0, 1, 1, 0, 5, '2023-12-12', '2023-12-12 15:10:11'),
(61, 0, 2, 0, 1, 0, 1, 1, 0, 5, '2023-12-13', '2023-12-13 15:14:42'),
(62, 0, 0, 0, 1, 0, 1, 1, 0, 3, '2023-12-14', '2023-12-14 15:16:58'),
(63, 0, 0, 0, 1, 0, 1, 1, 0, 3, '2023-12-15', '2023-12-15 15:57:29'),
(64, 0, 0, 0, 1, 0, 1, 1, 0, 3, '2023-12-16', '2023-12-16 15:19:50'),
(65, 0, 0, 0, 1, 0, 1, 1, 0, 3, '2023-12-17', '2023-12-17 15:20:15'),
(66, 0, 0, 0, 1, 0, 1, 1, 0, 3, '2023-12-18', '2023-12-18 15:17:17'),
(67, 0, 0, 0, 1, 0, 1, 1, 0, 3, '2023-12-19', '2023-12-19 14:25:35'),
(68, 0, 0, 0, 1, 0, 1, 0, 0, 2, '2023-12-20', '2023-12-20 15:41:38'),
(69, 0, 0, 0, 1, 0, 1, 0, 0, 2, '2023-12-21', '2023-12-21 15:19:22'),
(70, 0, 0, 0, 1, 0, 1, 0, 0, 2, '2023-12-22', '2023-12-22 14:23:02'),
(71, 0, 0, 0, 1, 0, 1, 0, 0, 2, '2023-12-23', '2023-12-23 15:21:28'),
(72, 0, 0, 0, 1, 0, 1, 0, 0, 2, '2023-12-24', '2023-12-24 13:34:50'),
(73, 0, 0, 0, 1, 0, 1, 0, 0, 2, '2023-12-25', '2023-12-25 15:23:35'),
(74, 0, 0, 0, 1, 0, 1, 0, 0, 2, '2023-12-26', '2023-12-26 15:23:11'),
(75, 0, 0, 0, 1, 0, 1, 0, 0, 2, '2023-12-27', '2023-12-27 15:23:27'),
(76, 0, 0, 0, 1, 0, 1, 0, 0, 2, '2023-12-28', '2023-12-28 14:05:02'),
(77, 0, 0, 0, 1, 0, 1, 0, 0, 2, '2023-12-29', '2023-12-29 15:28:05'),
(78, 0, 0, 0, 1, 0, 1, 0, 0, 2, '2023-12-30', '2023-12-30 10:40:29'),
(79, 0, 0, 0, 1, 0, 1, 0, 0, 2, '2023-12-31', '2023-12-31 13:41:21'),
(80, 0, 0, 0, 1, 0, 1, 0, 0, 2, '2024-01-01', '2024-01-01 05:55:13'),
(81, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-01-02', '2024-01-02 15:45:06'),
(82, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-01-03', '2024-01-03 15:24:17'),
(83, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-01-04', '2024-01-04 15:25:27'),
(84, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-01-05', '2024-01-05 15:30:53'),
(85, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-01-06', '2024-01-06 15:23:32'),
(86, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-01-07', '2024-01-07 15:24:40'),
(87, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-01-08', '2024-01-08 15:41:37'),
(88, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-01-09', '2024-01-09 15:29:06'),
(89, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-01-10', '2024-01-10 15:24:41'),
(90, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-01-11', '2024-01-11 15:37:47'),
(91, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-01-12', '2024-01-12 12:36:18'),
(92, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-01-13', '2024-01-13 14:37:11'),
(93, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-01-14', '2024-01-14 13:55:04'),
(94, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-01-15', '2024-01-15 13:57:08'),
(95, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-01-16', '2024-01-16 15:32:44'),
(96, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-01-17', '2024-01-17 13:52:23'),
(97, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-01-18', '2024-01-18 15:37:53'),
(98, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-01-19', '2024-01-19 15:34:35'),
(99, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-01-20', '2024-01-20 15:39:14'),
(100, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-01-21', '2024-01-21 15:37:09'),
(101, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-01-22', '2024-01-22 15:07:35'),
(102, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-01-23', '2024-01-23 15:39:15'),
(103, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-01-24', '2024-01-24 15:34:56'),
(104, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-01-25', '2024-01-25 14:36:37'),
(105, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-01-26', '2024-01-26 15:54:46'),
(106, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-01-27', '2024-01-27 14:50:06'),
(107, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-01-28', '2024-01-28 14:10:55'),
(108, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-01-29', '2024-01-29 04:41:16'),
(109, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-01-30', '2024-01-30 10:06:20'),
(110, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-01-31', '2024-01-31 13:42:36'),
(111, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-02-01', '2024-02-01 15:51:45'),
(112, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-02-02', '2024-02-02 15:52:04'),
(113, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-02-03', '2024-02-03 13:19:39'),
(114, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-02-04', '2024-02-04 14:56:06'),
(115, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-02-05', '2024-02-05 14:21:06'),
(116, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-02-06', '2024-02-06 15:41:10'),
(117, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-02-07', '2024-02-07 07:25:37'),
(118, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-02-08', '2024-02-08 13:06:42'),
(119, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-02-09', '2024-02-09 12:57:39'),
(120, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-02-10', '2024-02-10 15:01:46'),
(121, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-02-11', '2024-02-11 13:43:03'),
(122, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-02-12', '2024-02-12 13:55:14'),
(123, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-02-13', '2024-02-13 11:57:52'),
(124, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-02-14', '2024-02-13 19:14:16'),
(125, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-02-15', '2024-02-15 15:01:24'),
(126, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-02-16', '2024-02-16 15:04:26'),
(127, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-02-17', '2024-02-17 15:02:37'),
(128, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-02-18', '2024-02-18 15:55:57'),
(129, 0, 0, 0, 1, 0, 0, 0, 0, 1, '2024-02-19', '2024-02-19 03:22:12');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `position` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `major` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `posting_date` date DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `ic` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pass` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `verification_code` text COLLATE utf8mb4_general_ci NOT NULL,
  `verification_code_timestamp` timestamp NULL DEFAULT NULL,
  `gender` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pic` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `is_admin` tinyint(1) DEFAULT '0',
  `remember_token` varchar(255) COLLATE utf8mb4_general_ci DEFAULT '-',
  `address` varchar(255) COLLATE utf8mb4_general_ci DEFAULT '-',
  `teacher_session` varchar(200) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `username`, `position`, `major`, `posting_date`, `email`, `ic`, `phone`, `pass`, `email_verified_at`, `verification_code`, `verification_code_timestamp`, `gender`, `pic`, `is_admin`, `remember_token`, `address`, `teacher_session`) VALUES
(1, 'Taufiq Bin Nizam', 'Sir Taufiq', 'Guru', 'Business', '2023-09-23', 'tzumi.10@gmail.com', '000102011335', '0197735855', '$2y$10$rQmTd.0vKssboEdjSDePMOadJsfmacxtWEveIab71EWGaBNI74DZG', '2023-11-28 01:15:28', '261539', '2023-11-27 17:15:28', 'male', 'uploads/STES POSTER (2).jpg', 0, '', 'Pontian, Johor', 'Sesi Pagi'),
(2, 'Siti Rabi\'ah Binti Abdul Jabbar', 'Cikgu Rabiah', 'GPK Pentadbiran', 'Sains', '2023-09-25', 'rabiah0353@gmail.com', '123456789', '0123456789', '$2y$10$7/bGXDavMPrLbo4ca4RjN.TgU8UuebfT4ZIpKd6x2xYueAjxEfk1q', '2023-11-02 23:53:00', '218432', '2023-11-26 16:18:23', 'female', 'uploads/biah.jpg', 1, '', 'Pasir Mas, Selangor', NULL),
(3, 'Farah Aminah', 'Cikgu Farah', 'Guru', 'Math', '2023-10-28', 'farahhanis030503@gmail.com', '010101010000', '0123456789', '$2y$10$bjF0yU6.fkC7Cgu2MwQf8unipKbDb.Ydajy0FrdBYIyGhhA6zqRlq', '2023-11-02 23:53:00', '840966', '2023-11-27 15:57:43', 'female', 'uploads/farah.jpg', 0, '0af61e631f50c9a603cf55ffc5be84c04d00c659c06d788db79481c57fd922d7', 'Kuantan, Pahang', 'Sesi Petang'),
(589, 'Siti Rabi\'ah Binti Abdul Jabbar', 'Cikgu Siti', 'Guru', 'Math', '2023-11-27', '25ddt21f1025@pmj.edu.my', '123456789', '0123456789', '$2y$10$JK8qywYb7fLwqxuGYFDOsO31dGElSQGJu4a1uhnrayGwqH.656hvK', '2023-11-27 01:05:24', '275600', '2023-11-26 17:05:00', 'female', 'uploads/biah.jpg', 0, '-', '-', 'Sesi Pagi'),
(614, 'Nurin Yusrina', 'Cikgu Nurin Yusrina yang jelita', 'GPK Hem', 'Guru Matapelajaran Biologi dan Geografi ', '2023-12-05', 'nurinyusrina17@gmail.com', '950817010123', '0123456789', '$2y$10$3FyTH.Yb4/f5cz5u13bs.e1iGKkKue01WqK69R7iLybm7MZUsUimi', '2023-12-05 22:17:28', '592552', '2023-12-05 14:16:24', 'female', NULL, 0, '-', '-', 'Pagi'),
(616, NULL, 'Cikgu Taufiq', NULL, NULL, NULL, '25ddt21f1049@pmj.edu.my', NULL, NULL, '$2y$10$ZIsw/DK9x/.HTAuAWiRkLe8dEUsSf1povH5V16icqIdCgWdCrrKPq', '2023-12-12 02:22:03', '949811', '2023-12-11 18:20:28', NULL, NULL, 0, '-', '-', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `applicants`
--
ALTER TABLE `applicants`
  ADD PRIMARY KEY (`form_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `dashboard`
--
ALTER TABLE `dashboard`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `applicants`
--
ALTER TABLE `applicants`
  MODIFY `form_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `dashboard`
--
ALTER TABLE `dashboard`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=130;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=617;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `applicants`
--
ALTER TABLE `applicants`
  ADD CONSTRAINT `applicants_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
