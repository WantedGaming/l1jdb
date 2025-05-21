
-- --------------------------------------------------------

--
-- Table structure for table `catalyst`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `catalyst` (
  `nameId` int(6) NOT NULL DEFAULT 0,
  `nameId_kr` varchar(100) DEFAULT NULL,
  `nameId_en` varchar(100) NOT NULL,
  `input` int(6) NOT NULL DEFAULT 0,
  `input_kr` varchar(100) DEFAULT NULL,
  `input_en` varchar(100) NOT NULL,
  `successProb` int(3) NOT NULL DEFAULT 0,
  `broad` enum('true','false') NOT NULL DEFAULT 'false'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `catalyst`:
--
