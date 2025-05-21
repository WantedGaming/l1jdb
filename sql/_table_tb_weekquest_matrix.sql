
-- --------------------------------------------------------

--
-- Table structure for table `tb_weekquest_matrix`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `tb_weekquest_matrix` (
  `difficulty` int(10) NOT NULL,
  `col1` int(10) DEFAULT NULL,
  `col2` int(10) DEFAULT NULL,
  `col3` int(10) DEFAULT NULL,
  `stamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `tb_weekquest_matrix`:
--
