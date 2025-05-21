
-- --------------------------------------------------------

--
-- Table structure for table `character_death_item`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `character_death_item` (
  `char_id` int(10) NOT NULL DEFAULT 0,
  `delete_time` datetime NOT NULL,
  `db_id` int(10) NOT NULL DEFAULT 0,
  `itemId` int(11) NOT NULL,
  `count` int(11) NOT NULL DEFAULT 0,
  `enchant` int(6) NOT NULL DEFAULT 0,
  `identi` enum('false','true') NOT NULL DEFAULT 'false',
  `chargeCount` int(11) NOT NULL DEFAULT 0,
  `bless` int(3) NOT NULL DEFAULT 1,
  `attrEnchant` int(2) NOT NULL DEFAULT 0,
  `specialEnchant` int(2) NOT NULL DEFAULT 0,
  `potential_id` int(3) NOT NULL DEFAULT 0,
  `slot_first` int(5) NOT NULL DEFAULT 0,
  `slot_second` int(5) NOT NULL DEFAULT 0,
  `recovery_cost` int(8) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `character_death_item`:
--
