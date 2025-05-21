
-- --------------------------------------------------------

--
-- Table structure for table `character_eventpush`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `character_eventpush` (
  `push_id` int(10) NOT NULL DEFAULT 0,
  `objId` int(10) NOT NULL DEFAULT 0,
  `subject` varchar(90) DEFAULT NULL,
  `content` varchar(300) DEFAULT NULL,
  `web_url` varchar(200) DEFAULT '',
  `itemId` int(11) NOT NULL DEFAULT 0,
  `item_amount` int(11) NOT NULL DEFAULT 0,
  `item_enchant` int(6) DEFAULT 0,
  `doll_ablity` int(4) DEFAULT NULL,
  `used_immediately` enum('false','true') NOT NULL DEFAULT 'false',
  `status` int(2) NOT NULL DEFAULT 0,
  `enable_date` datetime NOT NULL,
  `image_id` int(6) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `character_eventpush`:
--
