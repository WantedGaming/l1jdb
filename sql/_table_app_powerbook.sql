
-- --------------------------------------------------------

--
-- Table structure for table `app_powerbook`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `app_powerbook` (
  `id` int(10) NOT NULL,
  `title` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'NULL',
  `content` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `mainImg` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `main` enum('true','false') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'false',
  `guideMain` enum('true','false') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `app_powerbook`:
--
