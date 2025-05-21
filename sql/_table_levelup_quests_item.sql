
-- --------------------------------------------------------

--
-- Table structure for table `levelup_quests_item`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `levelup_quests_item` (
  `id` int(10) NOT NULL,
  `level` int(10) NOT NULL DEFAULT 0,
  `type` int(5) NOT NULL DEFAULT 0,
  `note` varchar(100) DEFAULT NULL,
  `item_name` varchar(50) NOT NULL DEFAULT '',
  `item_id` int(10) NOT NULL DEFAULT 0,
  `count` int(10) NOT NULL DEFAULT 0,
  `enchant` int(6) NOT NULL DEFAULT 0,
  `attrlevel` int(5) NOT NULL DEFAULT 0,
  `bless` int(5) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `levelup_quests_item`:
--
