
-- --------------------------------------------------------

--
-- Table structure for table `app_nshop`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `app_nshop` (
  `id` int(10) NOT NULL,
  `itemid` int(10) NOT NULL DEFAULT 0,
  `itemname` varchar(50) NOT NULL,
  `price` int(10) NOT NULL DEFAULT 0,
  `price_type` enum('NCOIN','NPOINT') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'NCOIN',
  `saved_point` int(10) NOT NULL DEFAULT 0,
  `pack` int(10) NOT NULL DEFAULT 0,
  `enchant` int(10) NOT NULL DEFAULT 0,
  `limitCount` int(10) NOT NULL DEFAULT 50,
  `flag` enum('NONE','DISCOUNT','ESSENTIAL','HOT','LIMIT','LIMIT_MONTH','LIMIT_WEEK','NEW','REDKNIGHT') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'NONE',
  `iteminfo` varchar(700) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `app_nshop`:
--
