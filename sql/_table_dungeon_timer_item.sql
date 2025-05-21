
-- --------------------------------------------------------

--
-- Table structure for table `dungeon_timer_item`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `dungeon_timer_item` (
  `itemId` int(10) NOT NULL DEFAULT 0,
  `desc` varchar(50) DEFAULT NULL,
  `desc_kr` varchar(50) NOT NULL,
  `timerId` int(3) NOT NULL DEFAULT 0,
  `groupId` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `dungeon_timer_item`:
--
