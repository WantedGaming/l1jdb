
-- --------------------------------------------------------

--
-- Table structure for table `penalty_protect_item`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `penalty_protect_item` (
  `itemId` int(10) NOT NULL DEFAULT 0,
  `name` varchar(45) DEFAULT NULL,
  `desc_kr` varchar(45) NOT NULL,
  `type` enum('have','equip') DEFAULT 'have',
  `itemPanalty` enum('false','true') DEFAULT 'false',
  `expPanalty` enum('false','true') DEFAULT 'false',
  `dropItemId` int(10) DEFAULT 0,
  `msgId` int(5) DEFAULT NULL,
  `mapIds` text DEFAULT NULL,
  `remove` enum('false','true') DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `penalty_protect_item`:
--
