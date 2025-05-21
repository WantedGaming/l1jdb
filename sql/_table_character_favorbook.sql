
-- --------------------------------------------------------

--
-- Table structure for table `character_favorbook`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `character_favorbook` (
  `charObjId` int(10) NOT NULL DEFAULT 0,
  `category` int(3) NOT NULL DEFAULT 0,
  `slotId` int(1) NOT NULL DEFAULT 0,
  `itemObjId` int(10) NOT NULL DEFAULT 0,
  `itemId` int(10) NOT NULL DEFAULT 0,
  `itemName` varchar(255) DEFAULT '',
  `count` int(10) NOT NULL DEFAULT 1,
  `enchantLevel` int(10) NOT NULL DEFAULT 0,
  `attrLevel` int(10) NOT NULL DEFAULT 0,
  `bless` int(3) NOT NULL DEFAULT 1,
  `endTime` datetime DEFAULT NULL,
  `craftId` int(6) NOT NULL DEFAULT 0,
  `awakening` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `character_favorbook`:
--
