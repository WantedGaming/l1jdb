
-- --------------------------------------------------------

--
-- Table structure for table `beginner_box`
--
-- Creation: May 21, 2025 at 07:09 AM
-- Last update: May 21, 2025 at 07:09 AM
--

CREATE TABLE `beginner_box` (
  `itemid` int(20) NOT NULL,
  `count` int(20) NOT NULL DEFAULT 0,
  `enchantlvl` int(6) NOT NULL DEFAULT 0,
  `item_name` varchar(50) NOT NULL,
  `desc_kr` varchar(50) NOT NULL,
  `bless` int(10) NOT NULL DEFAULT 1,
  `activate` enum('lancer','fencer','warrior','illusionist','dragonknight','darkelf','wizard','elf','knight','crown','all') NOT NULL DEFAULT 'all'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `beginner_box`:
--
