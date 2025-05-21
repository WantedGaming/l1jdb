
-- --------------------------------------------------------

--
-- Table structure for table `town_npc`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `town_npc` (
  `npc_id` int(11) NOT NULL DEFAULT 0,
  `description` varchar(100) DEFAULT NULL,
  `town` enum('TALK_ISLAND','SILVER_KNIGHT','GLUDIO','ORCISH_FOREST','WINDAWOOD','KENT','GIRAN','HEINE','WERLDAN','OREN','ELVEN_FOREST','ADEN','SILENT_CAVERN','BEHEMOTH','SILVERIA','OUM_DUNGEON','RESISTANCE','PIRATE_ISLAND','RECLUSE_VILLAGE','HIDDEN_VALLEY','CLAUDIA','REDSOLDER','SKYGARDEN','RUUN') NOT NULL DEFAULT 'TALK_ISLAND'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `town_npc`:
--
