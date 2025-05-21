
-- --------------------------------------------------------

--
-- Table structure for table `commands`
--
-- Creation: May 21, 2025 at 07:09 AM
--

CREATE TABLE `commands` (
  `name` varchar(255) NOT NULL,
  `access_level` int(10) NOT NULL DEFAULT 9999,
  `class_name` varchar(255) NOT NULL,
  `description` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=euckr COLLATE=euckr_korean_ci;

--
-- RELATIONSHIPS FOR TABLE `commands`:
--
