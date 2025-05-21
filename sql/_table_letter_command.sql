
-- --------------------------------------------------------

--
-- Table structure for table `letter_command`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `letter_command` (
  `id` int(10) NOT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `content` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `letter_command`:
--
