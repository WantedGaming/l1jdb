
-- --------------------------------------------------------

--
-- Table structure for table `app_guide`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `app_guide` (
  `id` int(2) NOT NULL DEFAULT 0,
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `content` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `app_guide`:
--
