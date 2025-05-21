
-- --------------------------------------------------------

--
-- Table structure for table `craft_npcs`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `craft_npcs` (
  `npc_id` int(10) UNSIGNED NOT NULL,
  `npc_name` varchar(45) NOT NULL DEFAULT '',
  `desc_kr` varchar(45) NOT NULL,
  `craft_id_list` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `craft_npcs`:
--
