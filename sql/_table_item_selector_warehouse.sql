
-- --------------------------------------------------------

--
-- Table structure for table `item_selector_warehouse`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `item_selector_warehouse` (
  `itemId` int(11) NOT NULL DEFAULT 0,
  `name` varchar(45) DEFAULT NULL,
  `desc_kr` varchar(45) NOT NULL,
  `selectItemId` int(11) NOT NULL DEFAULT 0,
  `selectName` varchar(45) DEFAULT NULL,
  `select_desc_kr` varchar(45) NOT NULL,
  `index` int(3) NOT NULL DEFAULT 0,
  `enchantLevel` int(2) NOT NULL DEFAULT 0,
  `attrLevel` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `item_selector_warehouse`:
--
