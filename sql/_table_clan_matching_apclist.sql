
-- --------------------------------------------------------

--
-- Table structure for table `clan_matching_apclist`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `clan_matching_apclist` (
  `pc_name` varchar(45) NOT NULL DEFAULT '',
  `pc_objid` int(10) DEFAULT NULL,
  `clan_name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `clan_matching_apclist`:
--
