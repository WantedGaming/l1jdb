
-- --------------------------------------------------------

--
-- Table structure for table `character_items`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `character_items` (
  `id` int(11) NOT NULL DEFAULT 0,
  `item_id` int(11) NOT NULL,
  `char_id` int(11) NOT NULL,
  `item_name` varchar(255) DEFAULT NULL,
  `count` int(11) NOT NULL DEFAULT 0,
  `is_equipped` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `enchantlvl` int(11) NOT NULL DEFAULT 0,
  `is_id` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `durability` int(2) NOT NULL DEFAULT 0,
  `charge_count` int(11) NOT NULL DEFAULT 0,
  `remaining_time` int(11) NOT NULL DEFAULT 0,
  `last_used` datetime DEFAULT NULL,
  `bless` int(3) NOT NULL DEFAULT 1,
  `attr_enchantlvl` int(3) NOT NULL DEFAULT 0,
  `special_enchant` int(3) NOT NULL DEFAULT 0,
  `doll_ablity` int(4) NOT NULL DEFAULT 0,
  `end_time` datetime DEFAULT NULL,
  `KeyVal` int(6) NOT NULL DEFAULT 0,
  `package` tinyint(1) NOT NULL DEFAULT 0,
  `engrave` tinyint(1) UNSIGNED NOT NULL DEFAULT 0,
  `scheduled` tinyint(1) NOT NULL DEFAULT 0,
  `slot_0` int(5) NOT NULL DEFAULT 0,
  `slot_1` int(5) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `character_items`:
--
