
-- --------------------------------------------------------

--
-- Table structure for table `marble`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `marble` (
  `marble_id` int(10) NOT NULL,
  `char_id` int(10) DEFAULT NULL,
  `char_name` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `marble`:
--
