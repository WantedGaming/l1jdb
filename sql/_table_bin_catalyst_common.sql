
-- --------------------------------------------------------

--
-- Table structure for table `bin_catalyst_common`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `bin_catalyst_common` (
  `nameId` int(6) NOT NULL DEFAULT 0,
  `nameId_kr` varchar(100) DEFAULT NULL,
  `input` int(6) NOT NULL DEFAULT 0,
  `input_kr` varchar(100) DEFAULT NULL,
  `output` int(6) NOT NULL DEFAULT 0,
  `output_kr` varchar(100) DEFAULT NULL,
  `successProb` int(3) NOT NULL DEFAULT 0,
  `rewardCount` int(6) NOT NULL DEFAULT 0,
  `preserveProb` int(3) NOT NULL DEFAULT 0,
  `failOutput` int(6) NOT NULL DEFAULT 0,
  `failOutput_kr` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `bin_catalyst_common`:
--
