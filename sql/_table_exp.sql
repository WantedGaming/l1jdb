
-- --------------------------------------------------------

--
-- Table structure for table `exp`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `exp` (
  `level` int(10) NOT NULL,
  `exp` int(11) NOT NULL DEFAULT 0,
  `panalty` varchar(100) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `exp`:
--
