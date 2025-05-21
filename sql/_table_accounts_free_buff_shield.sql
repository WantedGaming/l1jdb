
-- --------------------------------------------------------

--
-- Table structure for table `accounts_free_buff_shield`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `accounts_free_buff_shield` (
  `account_name` varchar(50) NOT NULL,
  `favor_locked_time` int(4) NOT NULL DEFAULT 0,
  `pccafe_favor_remain_count` int(1) NOT NULL DEFAULT 0,
  `free_favor_remain_count` int(1) NOT NULL DEFAULT 0,
  `event_favor_remain_count` int(1) NOT NULL DEFAULT 0,
  `pccafe_reward_item_count` int(3) NOT NULL DEFAULT 0,
  `reset_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `accounts_free_buff_shield`:
--
