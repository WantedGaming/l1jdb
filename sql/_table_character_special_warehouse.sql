
-- --------------------------------------------------------

--
-- Table structure for table `character_special_warehouse`
--
-- Creation: May 21, 2025 at 07:09 AM
-- Last update: May 21, 2025 at 07:09 AM
-- Last check: May 21, 2025 at 07:09 AM
--

CREATE TABLE `character_special_warehouse` (
  `id` int(11) NOT NULL,
  `account_name` varchar(50) DEFAULT NULL,
  `item_id` int(11) DEFAULT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `is_equipped` int(11) DEFAULT NULL,
  `enchantlvl` int(11) DEFAULT NULL,
  `is_id` int(11) DEFAULT NULL,
  `durability` int(11) DEFAULT NULL,
  `charge_count` int(11) DEFAULT NULL,
  `remaining_time` int(11) DEFAULT NULL,
  `last_used` datetime DEFAULT NULL,
  `attr_enchantlvl` int(11) DEFAULT NULL,
  `doll_ablity` int(4) DEFAULT NULL,
  `bless` int(11) DEFAULT 0,
  `second_id` int(11) DEFAULT NULL,
  `round_id` int(11) DEFAULT NULL,
  `ticket_id` int(11) DEFAULT NULL,
  `maan_time` datetime DEFAULT NULL,
  `regist_level` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `character_special_warehouse`:
--
