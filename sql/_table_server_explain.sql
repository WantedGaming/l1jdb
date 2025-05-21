
-- --------------------------------------------------------

--
-- Table structure for table `server_explain`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `server_explain` (
  `num` int(10) NOT NULL,
  `subject` varchar(45) DEFAULT '',
  `content` varchar(1000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `server_explain`:
--
