
-- --------------------------------------------------------

--
-- Table structure for table `droptype_npc`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `droptype_npc` (
  `mobId` int(11) NOT NULL DEFAULT 0,
  `name` varchar(45) DEFAULT NULL,
  `desc_kr` varchar(45) NOT NULL,
  `type` enum('map','share') NOT NULL DEFAULT 'map'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `droptype_npc`:
--
