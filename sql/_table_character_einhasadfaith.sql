
-- --------------------------------------------------------

--
-- Table structure for table `character_einhasadfaith`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `character_einhasadfaith` (
  `objId` int(11) NOT NULL DEFAULT 0,
  `groupId` int(3) NOT NULL DEFAULT 0,
  `indexId` int(3) NOT NULL DEFAULT 0,
  `spellId` int(6) NOT NULL DEFAULT -1,
  `expiredTime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `character_einhasadfaith`:
--
