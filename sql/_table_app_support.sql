
-- --------------------------------------------------------

--
-- Table structure for table `app_support`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `app_support` (
  `id` int(10) NOT NULL DEFAULT 0,
  `account_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `character_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '',
  `pay_amount` int(10) NOT NULL DEFAULT 0,
  `write_date` datetime DEFAULT NULL,
  `status` enum('STANBY','FINISH') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'STANBY'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `app_support`:
--
