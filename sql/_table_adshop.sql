
-- --------------------------------------------------------

--
-- Table structure for table `adshop`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `adshop` (
  `account` varchar(13) NOT NULL,
  `name` varchar(13) NOT NULL,
  `sex` int(15) NOT NULL,
  `type` int(15) NOT NULL,
  `x` int(15) NOT NULL,
  `y` int(15) NOT NULL,
  `heading` int(15) NOT NULL,
  `map_id` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `adshop`:
--
