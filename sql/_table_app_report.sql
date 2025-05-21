
-- --------------------------------------------------------

--
-- Table structure for table `app_report`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `app_report` (
  `id` int(10) NOT NULL DEFAULT 0,
  `name` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `targetName` varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type` enum('Sexual','Abuse','Advertisement','Illegal Program','Content','Privacy','Lies','Other') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'Sexual',
  `log` text CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `app_report`:
--
