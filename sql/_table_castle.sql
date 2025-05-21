
-- --------------------------------------------------------

--
-- Table structure for table `castle`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `castle` (
  `castle_id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(45) NOT NULL DEFAULT '',
  `desc_kr` varchar(45) NOT NULL,
  `war_time` datetime DEFAULT NULL,
  `tax_rate` int(11) NOT NULL DEFAULT 0,
  `public_money` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `castle`:
--
