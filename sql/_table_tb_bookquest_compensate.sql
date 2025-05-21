
-- --------------------------------------------------------

--
-- Table structure for table `tb_bookquest_compensate`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `tb_bookquest_compensate` (
  `id` int(10) NOT NULL,
  `difficulty` int(3) DEFAULT 1,
  `type` varchar(20) NOT NULL,
  `num1` int(10) DEFAULT NULL,
  `num2` int(10) DEFAULT NULL,
  `id1` int(10) DEFAULT NULL,
  `id2` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `tb_bookquest_compensate`:
--
