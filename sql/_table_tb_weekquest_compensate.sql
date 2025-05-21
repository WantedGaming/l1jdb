
-- --------------------------------------------------------

--
-- Table structure for table `tb_weekquest_compensate`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `tb_weekquest_compensate` (
  `button_no` int(3) NOT NULL,
  `ingredient_itemId` int(10) DEFAULT 0,
  `compen_exp` int(10) DEFAULT 0,
  `compen_exp_level` int(10) DEFAULT 0,
  `compen_itemId` int(10) DEFAULT 0,
  `compen_itemCount` int(10) DEFAULT 0,
  `compen_itemLevel` int(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `tb_weekquest_compensate`:
--
