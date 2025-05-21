
-- --------------------------------------------------------

--
-- Table structure for table `app_alim_log`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `app_alim_log` (
  `id` int(11) NOT NULL,
  `account_name` varchar(50) DEFAULT NULL,
  `logContent` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `type` int(2) NOT NULL DEFAULT 0,
  `insertTime` datetime DEFAULT NULL,
  `status` enum('false','true') NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `app_alim_log`:
--
