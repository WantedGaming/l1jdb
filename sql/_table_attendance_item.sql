
-- --------------------------------------------------------

--
-- Table structure for table `attendance_item`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `attendance_item` (
  `groupType` int(3) NOT NULL DEFAULT 0,
  `index` int(3) NOT NULL DEFAULT 0,
  `item_id` int(10) NOT NULL DEFAULT 0,
  `item_name` varchar(45) NOT NULL DEFAULT '',
  `desc_kr` varchar(45) NOT NULL,
  `enchant` int(3) DEFAULT 0,
  `count` int(10) DEFAULT 1,
  `broadcast` enum('true','false') NOT NULL DEFAULT 'false',
  `bonus_type` enum('RandomDiceItem(3)','GiveItem(2)','UseItem(1)') NOT NULL DEFAULT 'GiveItem(2)'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `attendance_item`:
--
