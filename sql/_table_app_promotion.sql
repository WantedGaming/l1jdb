
-- --------------------------------------------------------

--
-- Table structure for table `app_promotion`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `app_promotion` (
  `id` int(2) NOT NULL DEFAULT 0,
  `title` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `subText` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `promotionDate` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `targetLink` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `promotionImg` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `listallImg` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `app_promotion`:
--
