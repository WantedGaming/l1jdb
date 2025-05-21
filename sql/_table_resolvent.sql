
-- --------------------------------------------------------

--
-- Table structure for table `resolvent`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `resolvent` (
  `item_id` int(10) NOT NULL DEFAULT 0,
  `note` varchar(45) NOT NULL,
  `crystal_count` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `resolvent`:
--
