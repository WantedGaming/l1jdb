
-- --------------------------------------------------------

--
-- Table structure for table `ub_rank`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `ub_rank` (
  `ub_id` int(10) NOT NULL DEFAULT 0,
  `char_name` varchar(45) CHARACTER SET euckr COLLATE euckr_korean_ci NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- RELATIONSHIPS FOR TABLE `ub_rank`:
--
