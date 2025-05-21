
-- --------------------------------------------------------

--
-- Table structure for table `bin_craft_common`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `bin_craft_common` (
  `craft_id` int(6) NOT NULL DEFAULT 0,
  `desc_id` int(6) NOT NULL DEFAULT 0,
  `desc_kr` varchar(100) DEFAULT NULL,
  `min_level` int(3) NOT NULL DEFAULT 0,
  `max_level` int(3) NOT NULL DEFAULT 0,
  `required_gender` int(2) NOT NULL DEFAULT 0,
  `min_align` int(6) NOT NULL DEFAULT 0,
  `max_align` int(6) NOT NULL DEFAULT 0,
  `min_karma` int(10) NOT NULL DEFAULT 0,
  `max_karma` int(10) NOT NULL DEFAULT 0,
  `max_count` int(6) NOT NULL DEFAULT 0,
  `is_show` enum('true','false') NOT NULL DEFAULT 'false',
  `PCCafeOnly` enum('true','false') NOT NULL DEFAULT 'false',
  `bmProbOpen` enum('true','false') NOT NULL DEFAULT 'false',
  `required_classes` int(6) NOT NULL DEFAULT 0,
  `required_quests` text DEFAULT NULL,
  `required_sprites` text DEFAULT NULL,
  `required_items` text DEFAULT NULL,
  `inputs_arr_input_item` text DEFAULT NULL,
  `inputs_arr_option_item` text DEFAULT NULL,
  `outputs_success` text DEFAULT NULL,
  `outputs_failure` text DEFAULT NULL,
  `outputs_success_prob_by_million` int(10) NOT NULL DEFAULT 0,
  `batch_delay_sec` int(10) NOT NULL DEFAULT 0,
  `period_list` text DEFAULT NULL,
  `cur_successcount` int(10) NOT NULL DEFAULT 0,
  `max_successcount` int(10) NOT NULL DEFAULT 0,
  `except_npc` enum('true','false') NOT NULL DEFAULT 'false',
  `SuccessCountType` enum('World(0)','Account(1)','Character(2)','AllServers(3)') NOT NULL DEFAULT 'World(0)'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `bin_craft_common`:
--
