
-- --------------------------------------------------------

--
-- Table structure for table `bin_treasureboxreward_common`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `bin_treasureboxreward_common` (
  `nameid` int(6) NOT NULL DEFAULT 0,
  `desc_kr` varchar(50) DEFAULT NULL,
  `grade` enum('Common(0)','Good(1)','Prime(2)','Legendary(3)') NOT NULL DEFAULT 'Common(0)'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `bin_treasureboxreward_common`:
--
