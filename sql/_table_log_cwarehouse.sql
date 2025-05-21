
-- --------------------------------------------------------

--
-- Table structure for table `log_cwarehouse`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `log_cwarehouse` (
  `id` int(10) NOT NULL,
  `datetime` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `type` varchar(45) NOT NULL,
  `clan_id` int(10) DEFAULT NULL,
  `clan_name` varchar(45) DEFAULT NULL,
  `account` varchar(45) DEFAULT NULL,
  `char_id` int(10) DEFAULT NULL,
  `char_name` varchar(45) DEFAULT NULL,
  `item_id` varchar(45) DEFAULT NULL,
  `item_name` varchar(45) DEFAULT NULL,
  `item_enchantlvl` varchar(45) DEFAULT NULL,
  `item_count` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `log_cwarehouse`:
--
