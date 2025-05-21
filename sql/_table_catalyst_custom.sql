
-- --------------------------------------------------------

--
-- Table structure for table `catalyst_custom`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `catalyst_custom` (
  `itemId` int(10) NOT NULL DEFAULT 0,
  `desc_kr` varchar(100) DEFAULT NULL,
  `desc_en` varchar(100) NOT NULL,
  `input_itemId` int(10) NOT NULL DEFAULT 0,
  `input_enchant` int(3) NOT NULL DEFAULT 0,
  `input_desc_kr` varchar(100) DEFAULT NULL,
  `input_desc` varchar(100) NOT NULL,
  `output_itemId` int(10) NOT NULL DEFAULT 0,
  `output_desc_kr` varchar(100) DEFAULT NULL,
  `output_desc` varchar(100) NOT NULL,
  `successProb` int(3) NOT NULL DEFAULT 100,
  `rewardCount` int(10) NOT NULL DEFAULT 1,
  `rewardEnchant` int(3) NOT NULL DEFAULT 0,
  `broad` enum('true','false') NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `catalyst_custom`:
--
