
-- --------------------------------------------------------

--
-- Table structure for table `bin_enchant_scroll_table_common`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `bin_enchant_scroll_table_common` (
  `enchantType` int(3) NOT NULL DEFAULT 0,
  `nameid` int(6) NOT NULL DEFAULT 0,
  `desc_kr` varchar(100) DEFAULT NULL,
  `targetEnchant` int(3) NOT NULL DEFAULT 0,
  `noTargetMaterialList` text DEFAULT NULL,
  `target_category` enum('NONE(0)','WEAPON(1)','ARMOR(2)','ACCESSORY(3)','ELEMENT(4)') NOT NULL DEFAULT 'NONE(0)',
  `isBmEnchantScroll` enum('false','true') NOT NULL DEFAULT 'false',
  `elementalType` int(2) NOT NULL DEFAULT 0,
  `useBlesscodeScroll` int(2) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `bin_enchant_scroll_table_common`:
--
