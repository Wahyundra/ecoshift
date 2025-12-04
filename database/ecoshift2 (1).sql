-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2025 at 06:04 AM
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
-- Database: `ecoshift2`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `title`, `content`, `created_at`) VALUES
(1, 'Ada Sampah Menumpuk', 'Ada sampah menumpuk di depan ruang kelas 304, tolong siswa yang menempati ruang tersebut bisa segera untuk membuang ke TPA', '2025-10-29 14:09:52');

-- --------------------------------------------------------

--
-- Table structure for table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `class_name` varchar(50) NOT NULL,
  `major_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `classes`
--

INSERT INTO `classes` (`id`, `class_name`, `major_id`) VALUES
(1, 'X PPLG 1', 1),
(2, 'X PPLG 2', 1),
(3, 'XI RPL', 1),
(4, 'XI PG', 1),
(5, 'XII RPL', 1),
(6, 'XII PG', 1);

-- --------------------------------------------------------

--
-- Table structure for table `majors`
--

CREATE TABLE `majors` (
  `id` int(11) NOT NULL,
  `major_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `majors`
--

INSERT INTO `majors` (`id`, `major_name`) VALUES
(1, 'PPLG'),
(2, 'AKL'),
(3, 'TE'),
(4, 'MPLB'),
(5, 'PM'),
(6, 'AP'),
(7, 'BUSANA'),
(8, 'TJKT');

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `id` int(11) NOT NULL,
  `reporter_id` int(11) NOT NULL,
  `reporter_name` varchar(100) NOT NULL,
  `reporter_class` varchar(50) NOT NULL,
  `report_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `damage_type` varchar(100) NOT NULL,
  `location` varchar(255) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `status` enum('new','in_progress','done') NOT NULL DEFAULT 'new'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reports`
--

INSERT INTO `reports` (`id`, `reporter_id`, `reporter_name`, `reporter_class`, `report_date`, `damage_type`, `location`, `photo`, `status`) VALUES
(1, 145, 'WAHYU INDRA SETIAWAN', 'XI RPL', '2025-10-29 14:17:25', 'Sampah Menumpuk', 'di depan ruag guru', 'uploads/690221f5cdce70.43748101.jpg', 'done'),
(2, 115, 'ALWAN LUTFI MAULIDA', 'XI RPL', '2025-12-04 01:15:29', 'Sampah Menumpuk', 'depan lab advance', 'uploads/6930e0b11b7e51.02835536.jpeg', 'new'),
(3, 115, 'ALWAN LUTFI MAULIDA', 'XI RPL', '2025-12-04 01:19:22', 'Sampah Menumpuk', 'depan lab intermediete', 'uploads/6930e19a68b3b8.34705092.jpeg', 'new');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `task_date` date NOT NULL,
  `task_description` text NOT NULL,
  `status` enum('pending','completed','verified') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`id`, `user_id`, `task_date`, `task_description`, `status`) VALUES
(277, 5, '2025-11-04', 'Membuang sampah', 'pending'),
(278, 6, '2025-11-04', 'Membuang sampah', 'pending'),
(279, 41, '2025-11-04', 'Membuang sampah', 'pending'),
(280, 42, '2025-11-04', 'Membuang sampah', 'pending'),
(281, 112, '2025-11-04', 'Membuang sampah', 'pending'),
(282, 113, '2025-11-04', 'Membuang sampah', 'pending'),
(283, 77, '2025-11-04', 'Membuang sampah', 'pending'),
(284, 78, '2025-11-04', 'Membuang sampah', 'pending'),
(285, 182, '2025-11-04', 'Membuang sampah', 'pending'),
(286, 183, '2025-11-04', 'Membuang sampah', 'pending'),
(287, 147, '2025-11-04', 'Membuang sampah', 'pending'),
(288, 148, '2025-11-04', 'Membuang sampah', 'pending'),
(289, 7, '2025-11-05', 'Membuang sampah', 'pending'),
(290, 8, '2025-11-05', 'Membuang sampah', 'pending'),
(291, 43, '2025-11-05', 'Membuang sampah', 'pending'),
(292, 44, '2025-11-05', 'Membuang sampah', 'pending'),
(293, 114, '2025-11-05', 'Membuang sampah', 'pending'),
(294, 115, '2025-11-05', 'Membuang sampah', 'pending'),
(295, 79, '2025-11-05', 'Membuang sampah', 'pending'),
(296, 80, '2025-11-05', 'Membuang sampah', 'pending'),
(297, 184, '2025-11-05', 'Membuang sampah', 'pending'),
(298, 185, '2025-11-05', 'Membuang sampah', 'pending'),
(299, 149, '2025-11-05', 'Membuang sampah', 'pending'),
(300, 150, '2025-11-05', 'Membuang sampah', 'pending'),
(301, 9, '2025-11-06', 'Membuang sampah', 'pending'),
(302, 10, '2025-11-06', 'Membuang sampah', 'pending'),
(303, 45, '2025-11-06', 'Membuang sampah', 'pending'),
(304, 46, '2025-11-06', 'Membuang sampah', 'pending'),
(305, 116, '2025-11-06', 'Membuang sampah', 'pending'),
(306, 117, '2025-11-06', 'Membuang sampah', 'pending'),
(307, 81, '2025-11-06', 'Membuang sampah', 'pending'),
(308, 82, '2025-11-06', 'Membuang sampah', 'pending'),
(309, 186, '2025-11-06', 'Membuang sampah', 'pending'),
(310, 187, '2025-11-06', 'Membuang sampah', 'pending'),
(311, 151, '2025-11-06', 'Membuang sampah', 'pending'),
(312, 152, '2025-11-06', 'Membuang sampah', 'pending'),
(313, 11, '2025-11-07', 'Membuang sampah', 'pending'),
(314, 12, '2025-11-07', 'Membuang sampah', 'pending'),
(315, 47, '2025-11-07', 'Membuang sampah', 'pending'),
(316, 48, '2025-11-07', 'Membuang sampah', 'pending'),
(317, 118, '2025-11-07', 'Membuang sampah', 'pending'),
(318, 119, '2025-11-07', 'Membuang sampah', 'pending'),
(319, 83, '2025-11-07', 'Membuang sampah', 'pending'),
(320, 84, '2025-11-07', 'Membuang sampah', 'pending'),
(321, 188, '2025-11-07', 'Membuang sampah', 'pending'),
(322, 189, '2025-11-07', 'Membuang sampah', 'pending'),
(323, 153, '2025-11-07', 'Membuang sampah', 'pending'),
(324, 154, '2025-11-07', 'Membuang sampah', 'pending'),
(325, 13, '2025-11-10', 'Membuang sampah', 'pending'),
(326, 14, '2025-11-10', 'Membuang sampah', 'pending'),
(327, 49, '2025-11-10', 'Membuang sampah', 'pending'),
(328, 50, '2025-11-10', 'Membuang sampah', 'pending'),
(329, 120, '2025-11-10', 'Membuang sampah', 'pending'),
(330, 121, '2025-11-10', 'Membuang sampah', 'pending'),
(331, 85, '2025-11-10', 'Membuang sampah', 'pending'),
(332, 86, '2025-11-10', 'Membuang sampah', 'pending'),
(333, 190, '2025-11-10', 'Membuang sampah', 'pending'),
(334, 191, '2025-11-10', 'Membuang sampah', 'pending'),
(335, 155, '2025-11-10', 'Membuang sampah', 'pending'),
(336, 156, '2025-11-10', 'Membuang sampah', 'pending'),
(337, 15, '2025-11-11', 'Membuang sampah', 'pending'),
(338, 16, '2025-11-11', 'Membuang sampah', 'pending'),
(339, 51, '2025-11-11', 'Membuang sampah', 'pending'),
(340, 52, '2025-11-11', 'Membuang sampah', 'pending'),
(341, 122, '2025-11-11', 'Membuang sampah', 'pending'),
(342, 123, '2025-11-11', 'Membuang sampah', 'pending'),
(343, 87, '2025-11-11', 'Membuang sampah', 'pending'),
(344, 88, '2025-11-11', 'Membuang sampah', 'pending'),
(345, 192, '2025-11-11', 'Membuang sampah', 'pending'),
(346, 193, '2025-11-11', 'Membuang sampah', 'pending'),
(347, 157, '2025-11-11', 'Membuang sampah', 'pending'),
(348, 158, '2025-11-11', 'Membuang sampah', 'pending'),
(349, 17, '2025-11-12', 'Membuang sampah', 'pending'),
(350, 18, '2025-11-12', 'Membuang sampah', 'pending'),
(351, 53, '2025-11-12', 'Membuang sampah', 'pending'),
(352, 54, '2025-11-12', 'Membuang sampah', 'pending'),
(353, 124, '2025-11-12', 'Membuang sampah', 'pending'),
(354, 125, '2025-11-12', 'Membuang sampah', 'pending'),
(355, 89, '2025-11-12', 'Membuang sampah', 'pending'),
(356, 90, '2025-11-12', 'Membuang sampah', 'pending'),
(357, 194, '2025-11-12', 'Membuang sampah', 'pending'),
(358, 195, '2025-11-12', 'Membuang sampah', 'pending'),
(359, 159, '2025-11-12', 'Membuang sampah', 'pending'),
(360, 160, '2025-11-12', 'Membuang sampah', 'pending'),
(361, 19, '2025-11-13', 'Membuang sampah', 'pending'),
(362, 20, '2025-11-13', 'Membuang sampah', 'pending'),
(363, 55, '2025-11-13', 'Membuang sampah', 'pending'),
(364, 56, '2025-11-13', 'Membuang sampah', 'pending'),
(365, 126, '2025-11-13', 'Membuang sampah', 'pending'),
(366, 127, '2025-11-13', 'Membuang sampah', 'pending'),
(367, 91, '2025-11-13', 'Membuang sampah', 'pending'),
(368, 92, '2025-11-13', 'Membuang sampah', 'pending'),
(369, 196, '2025-11-13', 'Membuang sampah', 'pending'),
(370, 197, '2025-11-13', 'Membuang sampah', 'pending'),
(371, 161, '2025-11-13', 'Membuang sampah', 'pending'),
(372, 162, '2025-11-13', 'Membuang sampah', 'pending'),
(373, 21, '2025-11-14', 'Membuang sampah', 'pending'),
(374, 22, '2025-11-14', 'Membuang sampah', 'pending'),
(375, 57, '2025-11-14', 'Membuang sampah', 'pending'),
(376, 58, '2025-11-14', 'Membuang sampah', 'pending'),
(377, 128, '2025-11-14', 'Membuang sampah', 'pending'),
(378, 129, '2025-11-14', 'Membuang sampah', 'pending'),
(379, 93, '2025-11-14', 'Membuang sampah', 'pending'),
(380, 94, '2025-11-14', 'Membuang sampah', 'pending'),
(381, 198, '2025-11-14', 'Membuang sampah', 'pending'),
(382, 199, '2025-11-14', 'Membuang sampah', 'pending'),
(383, 163, '2025-11-14', 'Membuang sampah', 'pending'),
(384, 164, '2025-11-14', 'Membuang sampah', 'pending'),
(385, 23, '2025-11-17', 'Membuang sampah', 'pending'),
(386, 24, '2025-11-17', 'Membuang sampah', 'pending'),
(387, 59, '2025-11-17', 'Membuang sampah', 'pending'),
(388, 60, '2025-11-17', 'Membuang sampah', 'pending'),
(389, 130, '2025-11-17', 'Membuang sampah', 'pending'),
(390, 131, '2025-11-17', 'Membuang sampah', 'pending'),
(391, 95, '2025-11-17', 'Membuang sampah', 'pending'),
(392, 96, '2025-11-17', 'Membuang sampah', 'pending'),
(393, 200, '2025-11-17', 'Membuang sampah', 'pending'),
(394, 201, '2025-11-17', 'Membuang sampah', 'pending'),
(395, 165, '2025-11-17', 'Membuang sampah', 'pending'),
(396, 166, '2025-11-17', 'Membuang sampah', 'pending'),
(397, 25, '2025-11-18', 'Membuang sampah', 'pending'),
(398, 26, '2025-11-18', 'Membuang sampah', 'pending'),
(399, 61, '2025-11-18', 'Membuang sampah', 'pending'),
(400, 62, '2025-11-18', 'Membuang sampah', 'pending'),
(401, 132, '2025-11-18', 'Membuang sampah', 'pending'),
(402, 133, '2025-11-18', 'Membuang sampah', 'pending'),
(403, 97, '2025-11-18', 'Membuang sampah', 'pending'),
(404, 98, '2025-11-18', 'Membuang sampah', 'pending'),
(405, 202, '2025-11-18', 'Membuang sampah', 'pending'),
(406, 203, '2025-11-18', 'Membuang sampah', 'pending'),
(407, 167, '2025-11-18', 'Membuang sampah', 'pending'),
(408, 168, '2025-11-18', 'Membuang sampah', 'pending'),
(409, 27, '2025-11-19', 'Membuang sampah', 'pending'),
(410, 28, '2025-11-19', 'Membuang sampah', 'pending'),
(411, 63, '2025-11-19', 'Membuang sampah', 'pending'),
(412, 64, '2025-11-19', 'Membuang sampah', 'pending'),
(413, 134, '2025-11-19', 'Membuang sampah', 'pending'),
(414, 135, '2025-11-19', 'Membuang sampah', 'pending'),
(415, 99, '2025-11-19', 'Membuang sampah', 'pending'),
(416, 100, '2025-11-19', 'Membuang sampah', 'pending'),
(417, 204, '2025-11-19', 'Membuang sampah', 'pending'),
(418, 205, '2025-11-19', 'Membuang sampah', 'pending'),
(419, 169, '2025-11-19', 'Membuang sampah', 'pending'),
(420, 170, '2025-11-19', 'Membuang sampah', 'pending'),
(421, 29, '2025-11-20', 'Membuang sampah', 'pending'),
(422, 30, '2025-11-20', 'Membuang sampah', 'pending'),
(423, 65, '2025-11-20', 'Membuang sampah', 'pending'),
(424, 66, '2025-11-20', 'Membuang sampah', 'pending'),
(425, 136, '2025-11-20', 'Membuang sampah', 'pending'),
(426, 137, '2025-11-20', 'Membuang sampah', 'pending'),
(427, 101, '2025-11-20', 'Membuang sampah', 'pending'),
(428, 102, '2025-11-20', 'Membuang sampah', 'pending'),
(429, 206, '2025-11-20', 'Membuang sampah', 'pending'),
(430, 207, '2025-11-20', 'Membuang sampah', 'pending'),
(431, 171, '2025-11-20', 'Membuang sampah', 'pending'),
(432, 172, '2025-11-20', 'Membuang sampah', 'pending'),
(433, 31, '2025-11-21', 'Membuang sampah', 'pending'),
(434, 32, '2025-11-21', 'Membuang sampah', 'pending'),
(435, 67, '2025-11-21', 'Membuang sampah', 'pending'),
(436, 68, '2025-11-21', 'Membuang sampah', 'pending'),
(437, 138, '2025-11-21', 'Membuang sampah', 'pending'),
(438, 139, '2025-11-21', 'Membuang sampah', 'pending'),
(439, 103, '2025-11-21', 'Membuang sampah', 'pending'),
(440, 104, '2025-11-21', 'Membuang sampah', 'pending'),
(441, 208, '2025-11-21', 'Membuang sampah', 'pending'),
(442, 209, '2025-11-21', 'Membuang sampah', 'pending'),
(443, 173, '2025-11-21', 'Membuang sampah', 'pending'),
(444, 174, '2025-11-21', 'Membuang sampah', 'pending'),
(445, 33, '2025-11-24', 'Membuang sampah', 'pending'),
(446, 34, '2025-11-24', 'Membuang sampah', 'pending'),
(447, 69, '2025-11-24', 'Membuang sampah', 'pending'),
(448, 70, '2025-11-24', 'Membuang sampah', 'pending'),
(449, 140, '2025-11-24', 'Membuang sampah', 'pending'),
(450, 141, '2025-11-24', 'Membuang sampah', 'pending'),
(451, 105, '2025-11-24', 'Membuang sampah', 'pending'),
(452, 106, '2025-11-24', 'Membuang sampah', 'pending'),
(453, 210, '2025-11-24', 'Membuang sampah', 'pending'),
(454, 211, '2025-11-24', 'Membuang sampah', 'pending'),
(455, 175, '2025-11-24', 'Membuang sampah', 'pending'),
(456, 176, '2025-11-24', 'Membuang sampah', 'pending'),
(457, 35, '2025-11-25', 'Membuang sampah', 'pending'),
(458, 36, '2025-11-25', 'Membuang sampah', 'pending'),
(459, 71, '2025-11-25', 'Membuang sampah', 'pending'),
(460, 72, '2025-11-25', 'Membuang sampah', 'pending'),
(461, 142, '2025-11-25', 'Membuang sampah', 'pending'),
(462, 143, '2025-11-25', 'Membuang sampah', 'pending'),
(463, 107, '2025-11-25', 'Membuang sampah', 'pending'),
(464, 108, '2025-11-25', 'Membuang sampah', 'pending'),
(465, 212, '2025-11-25', 'Membuang sampah', 'pending'),
(466, 213, '2025-11-25', 'Membuang sampah', 'pending'),
(467, 177, '2025-11-25', 'Membuang sampah', 'pending'),
(468, 178, '2025-11-25', 'Membuang sampah', 'pending'),
(469, 37, '2025-11-26', 'Membuang sampah', 'pending'),
(470, 38, '2025-11-26', 'Membuang sampah', 'pending'),
(471, 73, '2025-11-26', 'Membuang sampah', 'pending'),
(472, 74, '2025-11-26', 'Membuang sampah', 'pending'),
(473, 144, '2025-11-26', 'Membuang sampah', 'pending'),
(474, 145, '2025-11-26', 'Membuang sampah', 'pending'),
(475, 109, '2025-11-26', 'Membuang sampah', 'pending'),
(476, 110, '2025-11-26', 'Membuang sampah', 'pending'),
(477, 214, '2025-11-26', 'Membuang sampah', 'pending'),
(478, 215, '2025-11-26', 'Membuang sampah', 'pending'),
(479, 179, '2025-11-26', 'Membuang sampah', 'pending'),
(480, 180, '2025-11-26', 'Membuang sampah', 'pending'),
(481, 39, '2025-11-27', 'Membuang sampah', 'pending'),
(482, 40, '2025-11-27', 'Membuang sampah', 'pending'),
(483, 75, '2025-11-27', 'Membuang sampah', 'pending'),
(484, 76, '2025-11-27', 'Membuang sampah', 'pending'),
(485, 146, '2025-11-27', 'Membuang sampah', 'pending'),
(486, 112, '2025-11-27', 'Membuang sampah', 'pending'),
(487, 111, '2025-11-27', 'Membuang sampah', 'pending'),
(488, 77, '2025-11-27', 'Membuang sampah', 'pending'),
(489, 216, '2025-11-27', 'Membuang sampah', 'pending'),
(490, 217, '2025-11-27', 'Membuang sampah', 'pending'),
(491, 181, '2025-11-27', 'Membuang sampah', 'pending'),
(492, 147, '2025-11-27', 'Membuang sampah', 'pending'),
(493, 5, '2025-11-28', 'Membuang sampah', 'pending'),
(494, 6, '2025-11-28', 'Membuang sampah', 'pending'),
(495, 41, '2025-11-28', 'Membuang sampah', 'pending'),
(496, 42, '2025-11-28', 'Membuang sampah', 'pending'),
(497, 113, '2025-11-28', 'Membuang sampah', 'pending'),
(498, 114, '2025-11-28', 'Membuang sampah', 'pending'),
(499, 78, '2025-11-28', 'Membuang sampah', 'pending'),
(500, 79, '2025-11-28', 'Membuang sampah', 'pending'),
(501, 182, '2025-11-28', 'Membuang sampah', 'pending'),
(502, 183, '2025-11-28', 'Membuang sampah', 'pending'),
(503, 148, '2025-11-28', 'Membuang sampah', 'pending'),
(504, 149, '2025-11-28', 'Membuang sampah', 'pending'),
(505, 7, '2025-12-01', 'Membuang sampah', 'pending'),
(506, 8, '2025-12-01', 'Membuang sampah', 'pending'),
(507, 43, '2025-12-01', 'Membuang sampah', 'pending'),
(508, 44, '2025-12-01', 'Membuang sampah', 'pending'),
(509, 115, '2025-12-01', 'Membuang sampah', 'pending'),
(510, 116, '2025-12-01', 'Membuang sampah', 'pending'),
(511, 80, '2025-12-01', 'Membuang sampah', 'pending'),
(512, 81, '2025-12-01', 'Membuang sampah', 'pending'),
(513, 184, '2025-12-01', 'Membuang sampah', 'pending'),
(514, 185, '2025-12-01', 'Membuang sampah', 'pending'),
(515, 150, '2025-12-01', 'Membuang sampah', 'pending'),
(516, 151, '2025-12-01', 'Membuang sampah', 'pending'),
(517, 9, '2025-12-02', 'Membuang sampah', 'pending'),
(518, 10, '2025-12-02', 'Membuang sampah', 'pending'),
(519, 45, '2025-12-02', 'Membuang sampah', 'pending'),
(520, 46, '2025-12-02', 'Membuang sampah', 'pending'),
(521, 117, '2025-12-02', 'Membuang sampah', 'pending'),
(522, 118, '2025-12-02', 'Membuang sampah', 'pending'),
(523, 82, '2025-12-02', 'Membuang sampah', 'pending'),
(524, 83, '2025-12-02', 'Membuang sampah', 'pending'),
(525, 186, '2025-12-02', 'Membuang sampah', 'pending'),
(526, 187, '2025-12-02', 'Membuang sampah', 'pending'),
(527, 152, '2025-12-02', 'Membuang sampah', 'pending'),
(528, 153, '2025-12-02', 'Membuang sampah', 'pending'),
(529, 11, '2025-12-03', 'Membuang sampah', 'pending'),
(530, 12, '2025-12-03', 'Membuang sampah', 'pending'),
(531, 47, '2025-12-03', 'Membuang sampah', 'pending'),
(532, 48, '2025-12-03', 'Membuang sampah', 'pending'),
(533, 119, '2025-12-03', 'Membuang sampah', 'pending'),
(534, 120, '2025-12-03', 'Membuang sampah', 'pending'),
(535, 84, '2025-12-03', 'Membuang sampah', 'pending'),
(536, 85, '2025-12-03', 'Membuang sampah', 'pending'),
(537, 188, '2025-12-03', 'Membuang sampah', 'pending'),
(538, 189, '2025-12-03', 'Membuang sampah', 'pending'),
(539, 154, '2025-12-03', 'Membuang sampah', 'pending'),
(540, 155, '2025-12-03', 'Membuang sampah', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `nis` varchar(50) DEFAULT NULL,
  `class_id` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','admin') NOT NULL DEFAULT 'student'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `nis`, `class_id`, `password`, `role`) VALUES
(3, 'Admin', '0000', 1, 'admin123', 'admin'),
(5, 'ABYAN KENZIE KAYANA', '20347', 1, 'X PPLG 1', 'student'),
(6, 'ADENA RAISA UFAIRAH AZRA', '20348', 1, 'X PPLG 1', 'student'),
(7, 'AIRIN NUR AENI', '20349', 1, 'X PPLG 1', 'student'),
(8, 'AISYAH ADELINA CAHYA PERTIWI', '20350', 1, 'X PPLG 1', 'student'),
(9, 'ALIF ENGGAR ARZAKI', '20351', 1, 'X PPLG 1', 'student'),
(10, 'ALUNA KHEYSHA YUNIARTIKA', '20352', 1, 'X PPLG 1', 'student'),
(11, 'ANINDYA ZAHRA SALSABILA', '20353', 1, 'X PPLG 1', 'student'),
(12, 'ANNAJMA NAEVA HUWAIDAA', '20354', 1, 'X PPLG 1', 'student'),
(13, 'ANYA LESTARI', '20355', 1, 'X PPLG 1', 'student'),
(14, 'AVIF MUHAMAD FADILAH', '20356', 1, 'X PPLG 1', 'student'),
(15, 'AVINSA VERDA TAMA', '20357', 1, 'X PPLG 1', 'student'),
(16, 'AZZAM ATYANTA MAULANA PAMBUDI', '20358', 1, 'X PPLG 1', 'student'),
(17, 'DESTIAN REZKY PRATAMA', '20359', 1, 'X PPLG 1', 'student'),
(18, 'FAIZAN SYAHDA RAMADHAN', '20360', 1, 'X PPLG 1', 'student'),
(19, 'FILZA BAHRANI AZ ZULFA', '20361', 1, 'X PPLG 1', 'student'),
(20, 'GEREND PUTRA MAHARDIKA', '20362', 1, 'X PPLG 1', 'student'),
(21, 'GILAR FAIZAL', '20363', 1, 'X PPLG 1', 'student'),
(22, 'INTAN KHURUL NGAINI', '20364', 1, 'X PPLG 1', 'student'),
(23, 'INTAN MUNAWAROH', '20365', 1, 'X PPLG 1', 'student'),
(24, 'IZAZ HANAN ALFIAN', '20366', 1, 'X PPLG 1', 'student'),
(25, 'LAUDZA IZAAZ GHIATS PRADANA', '20367', 1, 'X PPLG 1', 'student'),
(26, 'LIONEL REVTA PRINCESA', '20368', 1, 'X PPLG 1', 'student'),
(27, 'MELKY ORELLA BARESKY LUBIS', '20369', 1, 'X PPLG 1', 'student'),
(28, 'MUHAMAD FATHAN ARSYID ANNAFI', '20370', 1, 'X PPLG 1', 'student'),
(29, 'NAJWAN UQOSAH FAWWAZ', '20371', 1, 'X PPLG 1', 'student'),
(30, 'NANDA DWI AL\'INSYIROH', '20372', 1, 'X PPLG 1', 'student'),
(31, 'RADITHYA MAHESWARA TYAGA PRATAMA', '20373', 1, 'X PPLG 1', 'student'),
(32, 'RAISYA GAYATRI', '20374', 1, 'X PPLG 1', 'student'),
(33, 'RAZI NAZIL ALGHIFARI', '20375', 1, 'X PPLG 1', 'student'),
(34, 'RISQILA AL QADRI', '20376', 1, 'X PPLG 1', 'student'),
(35, 'SALSABILA AURELLIA', '20377', 1, 'X PPLG 1', 'student'),
(36, 'SALSABILA SHAFA ADITYA', '20378', 1, 'X PPLG 1', 'student'),
(37, 'SEPTIANA EKA WIJAYANTI', '20379', 1, 'X PPLG 1', 'student'),
(38, 'SYAZWANI QURRATU AINI', '20380', 1, 'X PPLG 1', 'student'),
(39, 'WILDAN KHOERUL UMAM', '20381', 1, 'X PPLG 1', 'student'),
(40, 'ZAENAL ANDHIKA PRATAMA', '20382', 1, 'X PPLG 1', 'student'),
(41, 'ADILYA ZALFANA HARUM', '20383', 2, 'X PPLG 2', 'student'),
(42, 'AISYAH NUR APRILIA', '20384', 2, 'X PPLG 2', 'student'),
(43, 'AKID MAULANA AS SHIDIQ', '20385', 2, 'X PPLG 2', 'student'),
(44, 'ALISYA RAHMAH RIJADI', '20386', 2, 'X PPLG 2', 'student'),
(45, 'ANISATUN NAFI\'A', '20387', 2, 'X PPLG 2', 'student'),
(46, 'APRILLIA NUR ENJANG', '20388', 2, 'X PPLG 2', 'student'),
(47, 'DIAZ MARA AZZAHRANI', '20389', 2, 'X PPLG 2', 'student'),
(48, 'FABRIAN FITRA ALFANSYAH', '20390', 2, 'X PPLG 2', 'student'),
(49, 'FEBI ITA FADILAH', '20391', 2, 'X PPLG 2', 'student'),
(50, 'FIQIH NUR KHOLIQ', '20392', 2, 'X PPLG 2', 'student'),
(51, 'GALUH SAPUTRA', '20393', 2, 'X PPLG 2', 'student'),
(52, 'HAFIZ MAULANA', '20394', 2, 'X PPLG 2', 'student'),
(53, 'IRMANA SETIYAWATI', '20395', 2, 'X PPLG 2', 'student'),
(54, 'ITA SAFITRI', '20396', 2, 'X PPLG 2', 'student'),
(55, 'IVANO YOSSI ANDREANSYAH', '20397', 2, 'X PPLG 2', 'student'),
(56, 'JESSICA VIDYA FAUZIYYAH', '20398', 2, 'X PPLG 2', 'student'),
(57, 'KARINA SRI INDIRA FATHY', '20399', 2, 'X PPLG 2', 'student'),
(58, 'KRISDIAN DANISH DARMAWAN', '20400', 2, 'X PPLG 2', 'student'),
(59, 'LUJENG RADITYA PRATAMA', '20401', 2, 'X PPLG 2', 'student'),
(60, 'MADINA SAKHI', '20402', 2, 'X PPLG 2', 'student'),
(61, 'MAGDHALENA RATNASARI DEWI', '20403', 2, 'X PPLG 2', 'student'),
(62, 'MIZELA KRISTIANI', '20404', 2, 'X PPLG 2', 'student'),
(63, 'NABILA SYADSA', '20405', 2, 'X PPLG 2', 'student'),
(64, 'NADHIRA DESTRI HUDA', '20406', 2, 'X PPLG 2', 'student'),
(65, 'NAURA DENIT HARTANTI', '20407', 2, 'X PPLG 2', 'student'),
(66, 'QUEENA ANABELLA KALILA SETIAWAN', '20408', 2, 'X PPLG 2', 'student'),
(67, 'QUINSHA SABRINA ZULFIANDRA', '20409', 2, 'X PPLG 2', 'student'),
(68, 'RASYA AULIA EKA PUTRI', '20410', 2, 'X PPLG 2', 'student'),
(69, 'RESTU PRAYOGA', '20411', 2, 'X PPLG 2', 'student'),
(70, 'RIFQI PEBRIAN DAVA SUKMA', '20412', 2, 'X PPLG 2', 'student'),
(71, 'RIZQI BACHTIAR WIJAYANTO', '20413', 2, 'X PPLG 2', 'student'),
(72, 'SYAEKO AKHMAD FADHILAH', '20414', 2, 'X PPLG 2', 'student'),
(73, 'TEGAR HERLAMBANG', '20415', 2, 'X PPLG 2', 'student'),
(74, 'TIFANI SYIFA ADELIA', '20416', 2, 'X PPLG 2', 'student'),
(75, 'TITIS AYU CAHYANI', '20417', 2, 'X PPLG 2', 'student'),
(76, 'ZILDAN YUSUF SETIAWAN', '20418', 2, 'X PPLG 2', 'student'),
(77, 'ABDURROHMAN MUHAMMAD', '19663', 4, 'XI PG', 'student'),
(78, 'ADINDA DWI APRILIANI', '19664', 4, 'XI PG', 'student'),
(79, 'ADISHA MUSAROFAH', '19665', 4, 'XI PG', 'student'),
(80, 'ALLICIA ADELIA PUTRI', '19666', 4, 'XI PG', 'student'),
(81, 'ALMIRA LUBNAA KHANSA', '19667', 4, 'XI PG', 'student'),
(82, 'AMELINDA CAHYANI INDRASARI', '19668', 4, 'XI PG', 'student'),
(83, 'ANGGUN AMRINA UMI NARESWARI', '19669', 4, 'XI PG', 'student'),
(84, 'ARJUNA MURTI DANESWARA', '19670', 4, 'XI PG', 'student'),
(85, 'ASYIFA FEBY FAUZIA', '19671', 4, 'XI PG', 'student'),
(86, 'AULIA SEKAR HANIFA RASYIDAH', '19673', 4, 'XI PG', 'student'),
(87, 'CLEARESTA RAFA FILIA', '19674', 4, 'XI PG', 'student'),
(88, 'FAIRUZ AGHNA MULYA', '19675', 4, 'XI PG', 'student'),
(89, 'FATIMAH ZAHRAH', '19676', 4, 'XI PG', 'student'),
(90, 'FAWWAZ ANGGITA YUMNA QOTRUNNADA', '19677', 4, 'XI PG', 'student'),
(91, 'FAZA RADITYA PARAMA', '19678', 4, 'XI PG', 'student'),
(92, 'HAFIZ NUR SYARIF', '19679', 4, 'XI PG', 'student'),
(93, 'HANEYSHA MOZZALUNA', '19680', 4, 'XI PG', 'student'),
(94, 'IKA SOFIANA MUSYAROFAH', '19681', 4, 'XI PG', 'student'),
(95, 'MICHAEL MUFTI ZAIMANI', '19682', 4, 'XI PG', 'student'),
(96, 'MIGGE TEGAR FALLAHI', '19683', 4, 'XI PG', 'student'),
(97, 'MOCHAMAD ARSA ARDHANA', '19684', 4, 'XI PG', 'student'),
(98, 'MUHAMMAD FAATHIR RAMADHAN', '19685', 4, 'XI PG', 'student'),
(99, 'MUHAMMAD THORIZA MA\'ALI', '19686', 4, 'XI PG', 'student'),
(100, 'MUTIA CITRA UTAMI', '19687', 4, 'XI PG', 'student'),
(101, 'NADIA KHANSA MANAF', '19688', 4, 'XI PG', 'student'),
(102, 'NAILA KHANSA', '19689', 4, 'XI PG', 'student'),
(103, 'NAUFAL ALFARADIS WAFI', '19690', 4, 'XI PG', 'student'),
(104, 'PRASASTI JULIA MUNANDAR', '19691', 4, 'XI PG', 'student'),
(105, 'RAFI ENDRA ADIYATAMA', '19692', 4, 'XI PG', 'student'),
(106, 'RAHMANIA NAYSALMA NIBRASHATI', '19693', 4, 'XI PG', 'student'),
(107, 'RAISSHA NATHANIA ARTANTI', '19694', 4, 'XI PG', 'student'),
(108, 'SITI NUR \'AZIZAH', '19695', 4, 'XI PG', 'student'),
(109, 'WAHYU NURFIKA', '19696', 4, 'XI PG', 'student'),
(110, 'YOJA ALIFYA AMANIAR', '19697', 4, 'XI PG', 'student'),
(111, 'ZAKIA FAHRANI ENDNAN', '19698', 4, 'XI PG', 'student'),
(112, 'AHMAD NADLIFUL NGIZZA', '19699', 3, 'XI RPL', 'student'),
(113, 'ALIEFIA YULIANA SAPUTRI', '19700', 3, 'XI RPL', 'student'),
(114, 'ALQODRI ADI TRI WALUYO', '19701', 3, 'XI RPL', 'student'),
(115, 'ALWAN LUTFI MAULIDA', '19702', 3, 'XI RPL', 'student'),
(116, 'ALYA NUR KINASIH', '19703', 3, 'XI RPL', 'student'),
(117, 'ANINDYA CHRISTY HADISETYO', '19704', 3, 'XI RPL', 'student'),
(118, 'ANNISA JULIANTY', '19705', 3, 'XI RPL', 'student'),
(119, 'AUGUSTY PUTRA ARTHAMEVA', '19707', 3, 'XI RPL', 'student'),
(120, 'AZKA HANANIA SUPRIYADI', '19708', 3, 'XI RPL', 'student'),
(121, 'CALLISTA PUSPITA SANI', '19709', 3, 'XI RPL', 'student'),
(122, 'DLIYA WAHYU RAMADHANI', '19710', 3, 'XI RPL', 'student'),
(123, 'DZASKIA AURELIA JANEETA', '19711', 3, 'XI RPL', 'student'),
(124, 'EGIE HARIANSYAH', '19712', 3, 'XI RPL', 'student'),
(125, 'ERLANGGA IRFAN JATI', '19713', 3, 'XI RPL', 'student'),
(126, 'FADANTYA BALQIS AQILAH', '19714', 3, 'XI RPL', 'student'),
(127, 'GHAFIRA ANINDYA PASHA', '19715', 3, 'XI RPL', 'student'),
(128, 'GHANI FAKKA RINDRA', '19716', 3, 'XI RPL', 'student'),
(129, 'HANA ADILIA RIFAIE', '19717', 3, 'XI RPL', 'student'),
(130, 'HARYA ANANTA DARMA', '19718', 3, 'XI RPL', 'student'),
(131, 'HEVYNA AZALYA PUTRI', '19719', 3, 'XI RPL', 'student'),
(132, 'KAYLEEN NATHALIE YURIKO CORNELISZ', '19720', 3, 'XI RPL', 'student'),
(133, 'KHAIRUNISA SEKARWANI', '19721', 3, 'XI RPL', 'student'),
(134, 'LUTFIANA PUTRI', '19722', 3, 'XI RPL', 'student'),
(135, 'MARSELINA CATUR NURHIDAYAH', '19723', 3, 'XI RPL', 'student'),
(136, 'MUHAMAD FAIZ ABDILLAH', '19724', 3, 'XI RPL', 'student'),
(137, 'NELA OKTAVIA', '19725', 3, 'XI RPL', 'student'),
(138, 'NENA FERNANDA', '19726', 3, 'XI RPL', 'student'),
(139, 'OKTAVIA AYU WULANDARI', '19727', 3, 'XI RPL', 'student'),
(140, 'RAFLY BAGUS ARDIANSYAH', '19728', 3, 'XI RPL', 'student'),
(141, 'RATRI YULIYANTI', '19729', 3, 'XI RPL', 'student'),
(142, 'REFIANA ENINDYA DWI SASMITA', '19730', 3, 'XI RPL', 'student'),
(143, 'RIZKY SETIAWAN', '19731', 3, 'XI RPL', 'student'),
(144, 'SYAFIRA PUTRI NAZARINA', '19732', 3, 'XI RPL', 'student'),
(145, 'WAHYU INDRA SETIAWAN', '19733', 3, 'XI RPL', 'student'),
(146, 'YASMINE AYU ADINDA', '19734', 3, 'XI RPL', 'student'),
(147, 'ADINDA PUTRI ADISTY', '14730', 6, 'XII PG', 'student'),
(148, 'AL TANTUYA FRIZZI', '14731', 6, 'XII PG', 'student'),
(149, 'ANANG RIDHO SUMANTRI', '14732', 6, 'XII PG', 'student'),
(150, 'ANOPWAL SURYA WIDODO', '14733', 6, 'XII PG', 'student'),
(151, 'ARYA BAGUS ARDIANTO', '14734', 6, 'XII PG', 'student'),
(152, 'ASTRID INDAH RIFFIANTI', '14735', 6, 'XII PG', 'student'),
(153, 'ATHOILLAH JATI IRWANSYAH', '14736', 6, 'XII PG', 'student'),
(154, 'AULIA SYIFA ZULFIANA', '14737', 6, 'XII PG', 'student'),
(155, 'AYESHA FARHI MAULIDA', '14738', 6, 'XII PG', 'student'),
(156, 'CAHYANI VRESTY PASHA RAHMADANI', '14739', 6, 'XII PG', 'student'),
(157, 'CHIKA PUTRI PUSPITA WULANDARI', '14740', 6, 'XII PG', 'student'),
(158, 'DZAKY MUSYAFFA', '14741', 6, 'XII PG', 'student'),
(159, 'EZZAR DWI PANGESTU', '14742', 6, 'XII PG', 'student'),
(160, 'FATHAN JANU PRANATA', '14743', 6, 'XII PG', 'student'),
(161, 'FEBRYAN NUR HIDAYATULLOH', '14744', 6, 'XII PG', 'student'),
(162, 'FITRI CAHYA NINDITA', '14745', 6, 'XII PG', 'student'),
(163, 'HANANIAH MULKI ACINTYA QUSHOYYI', '14746', 6, 'XII PG', 'student'),
(164, 'IKHSAN FADILAH', '14747', 6, 'XII PG', 'student'),
(165, 'IKLIL FUHAID ATHAAR', '14748', 6, 'XII PG', 'student'),
(166, 'INTAN PRIMADANI', '14749', 6, 'XII PG', 'student'),
(167, 'ISNAENI NUR DIANA', '14750', 6, 'XII PG', 'student'),
(168, 'JAVANICA ADRIANO', '14751', 6, 'XII PG', 'student'),
(169, 'MOCHAMAD AZZRIL RAYHAN PRATAMA', '14752', 6, 'XII PG', 'student'),
(170, 'MUFTI AKHSANAL KHALIQIN', '14753', 6, 'XII PG', 'student'),
(171, 'MUHAMMAD ADIB ANNAFI', '14754', 6, 'XII PG', 'student'),
(172, 'NAILA WAHYU CAHYANI', '14755', 6, 'XII PG', 'student'),
(173, 'PRABANI ALYAA NABILAH', '14756', 6, 'XII PG', 'student'),
(174, 'RAI HANUM AL KHASNA', '14757', 6, 'XII PG', 'student'),
(175, 'REVIN AGHA FEBRIANO', '14758', 6, 'XII PG', 'student'),
(176, 'RIAN NUH ALAMSYAH', '14759', 6, 'XII PG', 'student'),
(177, 'SHOFIA JASMINE MADINA ASPARA', '14760', 6, 'XII PG', 'student'),
(178, 'TEGAR RAHMAN NURRAIHAN', '14761', 6, 'XII PG', 'student'),
(179, 'UDI ANANDA PRATAMA', '14762', 6, 'XII PG', 'student'),
(180, 'ZALFA TRI NOVELISA', '14763', 6, 'XII PG', 'student'),
(181, 'ZULFA WIDYANISA', '14764', 6, 'XII PG', 'student'),
(182, 'ALVIANA MAYSAROH', '14765', 5, 'XII RPL', 'student'),
(183, 'ANGEL CHRISTINA GRACE', '14766', 5, 'XII RPL', 'student'),
(184, 'ARI BIMA PRASETYA', '14767', 5, 'XII RPL', 'student'),
(185, 'ARKAN MAULIDHANA NURFALAH', '14768', 5, 'XII RPL', 'student'),
(186, 'ASFI ZAINATUL ADQIA', '14769', 5, 'XII RPL', 'student'),
(187, 'AZRIL FATHAN FADLILAH', '14770', 5, 'XII RPL', 'student'),
(188, 'BAGUS WISMA SAPUTRA', '14771', 5, 'XII RPL', 'student'),
(189, 'CANDRA SAPUTRA', '14772', 5, 'XII RPL', 'student'),
(190, 'DIKA SETIA KURNIAWAN', '14773', 5, 'XII RPL', 'student'),
(191, 'FAHREZI APTA RAFFELIANSYAH', '14774', 5, 'XII RPL', 'student'),
(192, 'FARDILA FARADIBA', '14775', 5, 'XII RPL', 'student'),
(193, 'FARKHANSYAH IBRAHIMOVIC', '14776', 5, 'XII RPL', 'student'),
(194, 'HACKY ZALMAN ALVISTA', '14777', 5, 'XII RPL', 'student'),
(195, 'HIRU TOTY RIAWAN', '14778', 5, 'XII RPL', 'student'),
(196, 'INEZ RAISYA LARASATI', '14779', 5, 'XII RPL', 'student'),
(197, 'ISMEY MUKARROMAH', '14780', 5, 'XII RPL', 'student'),
(198, 'LUSIANA', '14781', 5, 'XII RPL', 'student'),
(199, 'MAUDY ARI KHOFIFAH', '14782', 5, 'XII RPL', 'student'),
(200, 'MOCHAMMAD ALVIAN PUTRA PRATAMA', '14783', 5, 'XII RPL', 'student'),
(201, 'MUHAMAD RAFLI FAHREZA', '14784', 5, 'XII RPL', 'student'),
(202, 'MUHAMMAD HAAFIZH HARYATAMA', '14785', 5, 'XII RPL', 'student'),
(203, 'MUHAMMAD NUR SYAFII', '14786', 5, 'XII RPL', 'student'),
(204, 'NAFISTA OKTAFIANI HIDAYAT', '14787', 5, 'XII RPL', 'student'),
(205, 'NAVIZ FASHA PRATAMA', '14788', 5, 'XII RPL', 'student'),
(206, 'RAFLI SUBHI', '14789', 5, 'XII RPL', 'student'),
(207, 'RAHMA QURROTA \'AININ', '14790', 5, 'XII RPL', 'student'),
(208, 'RASYA ADAM SAPUTRA', '14791', 5, 'XII RPL', 'student'),
(209, 'SATRIO AJI KURNIAWAN', '14792', 5, 'XII RPL', 'student'),
(210, 'SATRIO GEMINTANG MAHAMERU', '14793', 5, 'XII RPL', 'student'),
(211, 'SEPTIA WINDI ASTUTI', '14794', 5, 'XII RPL', 'student'),
(212, 'TRI RISKA INDAH SARI', '14795', 5, 'XII RPL', 'student'),
(213, 'WIDIATRI NUR ZAHRA', '14796', 5, 'XII RPL', 'student'),
(214, 'WIWIN PURWANTI', '14797', 5, 'XII RPL', 'student'),
(215, 'YAFI ALIFIA ZAHIDA', '14798', 5, 'XII RPL', 'student'),
(216, 'YOLA YULIA EFENDI', '14799', 5, 'XII RPL', 'student'),
(217, 'ZULIN NAFISAH ZAM ZAMI', '14800', 5, 'XII RPL', 'student');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `major_id_ibfk_1` (`major_id`);

--
-- Indexes for table `majors`
--
ALTER TABLE `majors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reporter_id` (`reporter_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nis` (`nis`),
  ADD KEY `class_id` (`class_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `majors`
--
ALTER TABLE `majors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=541;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=218;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `classes`
--
ALTER TABLE `classes`
  ADD CONSTRAINT `major_id_ibfk_1` FOREIGN KEY (`major_id`) REFERENCES `majors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `reports_ibfk_1` FOREIGN KEY (`reporter_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
