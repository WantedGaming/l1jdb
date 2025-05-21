
-- --------------------------------------------------------

--
-- Table structure for table `tb_lfccompensate`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `tb_lfccompensate` (
  `ID` int(10) NOT NULL,
  `LFCID` int(2) DEFAULT 0,
  `PARTITION` int(10) DEFAULT 0,
  `TYPE` varchar(20) DEFAULT NULL,
  `IDENTITY` int(10) DEFAULT 0,
  `QUANTITY` int(50) DEFAULT 0,
  `LEVEL` int(10) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `tb_lfccompensate`:
--
