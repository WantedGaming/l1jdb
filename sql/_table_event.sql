
-- --------------------------------------------------------

--
-- Table structure for table `event`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `event` (
  `event_id` int(10) NOT NULL DEFAULT 0,
  `description` varchar(50) DEFAULT NULL,
  `desc_kr` varchar(50) NOT NULL,
  `desc_en` varchar(50) NOT NULL,
  `start_date` datetime DEFAULT NULL,
  `finish_date` datetime DEFAULT NULL,
  `broadcast` enum('true','false') NOT NULL DEFAULT 'false',
  `event_flag` enum('SPAWN_NPC','DROP_ADENA','DROP_ITEM','POLY') NOT NULL DEFAULT 'SPAWN_NPC',
  `spawn_data` text DEFAULT NULL,
  `drop_rate` float NOT NULL DEFAULT 1,
  `finish_delete_item` text DEFAULT NULL,
  `finish_map_rollback` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `event`:
--
