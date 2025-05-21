
-- --------------------------------------------------------

--
-- Table structure for table `character_timecollection`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `character_timecollection` (
  `charObjId` int(10) NOT NULL DEFAULT 0,
  `groupId` int(1) NOT NULL DEFAULT 0,
  `setId` int(1) NOT NULL DEFAULT 0,
  `slots` text DEFAULT NULL,
  `registComplet` enum('false','true') NOT NULL DEFAULT 'false',
  `buffType` enum('SHORT','LONG','MAGIC') NOT NULL DEFAULT 'MAGIC',
  `buffTime` datetime DEFAULT NULL,
  `refillCount` int(3) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `character_timecollection`:
--
