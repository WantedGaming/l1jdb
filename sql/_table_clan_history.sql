
-- --------------------------------------------------------

--
-- Table structure for table `clan_history`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `clan_history` (
  `num` int(11) NOT NULL,
  `clan_id` int(11) NOT NULL DEFAULT 0,
  `ckck` int(2) NOT NULL DEFAULT 0,
  `char_name` varchar(50) NOT NULL DEFAULT '',
  `item_name` varchar(50) NOT NULL DEFAULT '',
  `item_count` int(11) NOT NULL DEFAULT 0,
  `time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `clan_history`:
--
