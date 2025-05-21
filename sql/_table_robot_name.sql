
-- --------------------------------------------------------

--
-- Table structure for table `robot_name`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `robot_name` (
  `uid` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `robot_name`:
--
