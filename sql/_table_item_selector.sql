
-- --------------------------------------------------------

--
-- Table structure for table `item_selector`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `item_selector` (
  `itemId` int(11) NOT NULL DEFAULT 0,
  `name` varchar(45) DEFAULT NULL,
  `desc_kr` varchar(45) NOT NULL,
  `selectItemId` int(11) NOT NULL DEFAULT 0,
  `selectName` varchar(45) DEFAULT NULL,
  `select_desc_kr` varchar(45) NOT NULL,
  `count` int(10) NOT NULL DEFAULT 1,
  `enchant` int(4) NOT NULL DEFAULT 0,
  `attr` enum('5','4','3','2','1','0') NOT NULL DEFAULT '0',
  `bless` int(3) NOT NULL DEFAULT 1,
  `limitTime` int(10) NOT NULL DEFAULT 0,
  `delete` enum('false','true') NOT NULL DEFAULT 'true'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `item_selector`:
--
