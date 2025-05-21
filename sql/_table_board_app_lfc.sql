
-- --------------------------------------------------------

--
-- Table structure for table `board_app_lfc`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `board_app_lfc` (
  `id` int(10) NOT NULL,
  `name` varchar(16) DEFAULT 'NULL',
  `date` varchar(16) DEFAULT 'NULL',
  `title` varchar(16) DEFAULT 'NULL',
  `content` varchar(100) DEFAULT 'NULL'
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `board_app_lfc`:
--
