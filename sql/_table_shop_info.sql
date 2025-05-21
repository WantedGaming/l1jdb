
-- --------------------------------------------------------

--
-- Table structure for table `shop_info`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `shop_info` (
  `npcId` int(9) NOT NULL DEFAULT 0,
  `name` varchar(50) DEFAULT NULL,
  `type` enum('clan','ein','ncoin','tam','berry','item') NOT NULL DEFAULT 'item',
  `currencyId` int(9) NOT NULL DEFAULT 0,
  `currencyDescId` int(6) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `shop_info`:
--
