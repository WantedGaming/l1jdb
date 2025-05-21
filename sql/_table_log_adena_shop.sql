
-- --------------------------------------------------------

--
-- Table structure for table `log_adena_shop`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `log_adena_shop` (
  `startTime` datetime DEFAULT NULL,
  `endTime` datetime DEFAULT NULL,
  `accounts` varchar(20) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `count` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci ROW_FORMAT=COMPACT;

--
-- RELATIONSHIPS FOR TABLE `log_adena_shop`:
--
