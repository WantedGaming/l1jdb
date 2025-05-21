
-- --------------------------------------------------------

--
-- Table structure for table `board_notice`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `board_notice` (
  `id` int(10) NOT NULL,
  `name` varchar(16) DEFAULT NULL,
  `date` varchar(16) DEFAULT NULL,
  `title` varchar(16) DEFAULT NULL,
  `content` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `board_notice`:
--
