
-- --------------------------------------------------------

--
-- Table structure for table `report`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `report` (
  `target` varchar(100) NOT NULL,
  `reporter` varchar(100) NOT NULL,
  `count` int(11) NOT NULL DEFAULT 1,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `report`:
--
