
-- --------------------------------------------------------

--
-- Table structure for table `connect_reward`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `connect_reward` (
  `id` int(3) NOT NULL DEFAULT 0,
  `description` varchar(50) DEFAULT NULL,
  `desc_kr` varchar(50) NOT NULL,
  `reward_type` enum('NORMAL','STANBY_SERVER') NOT NULL DEFAULT 'NORMAL',
  `reward_item_id` int(10) NOT NULL DEFAULT 0,
  `reward_item_count` int(10) NOT NULL DEFAULT 0,
  `reward_interval_minute` int(6) NOT NULL DEFAULT 0,
  `reward_start_date` datetime DEFAULT NULL,
  `reward_finish_date` datetime DEFAULT NULL,
  `is_use` enum('true','false') NOT NULL DEFAULT 'true'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `connect_reward`:
--
